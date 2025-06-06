<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $documentRequests = DocumentRequest::query()
            ->when(request('search'), function ($query) {
                $query->where('Name', 'like', '%' . request('search') . '%')
                      ->orWhere('Id', 'like', '%' . request('search') . '%');
            })
            ->paginate(10); // Paginate the results

        // Calculate counts for summary cards
        $totalRequest = DocumentRequest::count();
        $pendingCount = DocumentRequest::where('Status', 'pending')->count();
        $approvedCount = DocumentRequest::where('Status', 'approved')->count();
        $rejectedCount = DocumentRequest::where('Status', 'rejected')->count();
        $overdueCount = DocumentRequest::where('Status', 'overdue')->count();

        return view('documents', compact(
            'documentRequests',
            'totalRequest',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'overdueCount'
        ));
    }

    public function show($id)
    {
        $documentRequest = DocumentRequest::findOrFail($id); // Fetches the request or fails

        // Helper function for price calculation (can be moved to Model later)
        $price = $this->calculatePrice($documentRequest->DocumentType, $documentRequest->Quantity);

        // Pass the document request and calculated price to the view
        return view('document_verify', compact('documentRequest', 'price'));
    }

    // Method to handle the status update form submission
    public function update(Request $request, $id)
    {
        try {
            $documentRequest = DocumentRequest::findOrFail($id);
            
            $request->validate([
                'status' => 'required|string|in:pending,approved,rejected,cancelled,overdue',
                'reason' => 'required_if:status,rejected|nullable|string|max:255',
                'pickup_status' => 'nullable|string|in:pending,picked_up',
            ]);

            $newStatus = $request->input('status');
            $reason = $request->input('reason');
            $pickupStatus = $request->input('pickup_status');

            // Store old status to check for changes
            $oldStatus = $documentRequest->Status;

            $dateApproved = $documentRequest->date_approved;
            if ($newStatus === 'approved' && strtolower($documentRequest->Status) !== 'approved') {
                $dateApproved = Carbon::now('Asia/Manila');
            }

            // Prepare data for update
            $updateData = [
                'Status' => $newStatus,
                'date_approved' => $dateApproved,
            ];

            // Add rejection_reason only when status is rejected
            if ($newStatus === 'rejected') {
                $updateData['rejection_reason'] = $reason;
            } else {
                // Set an empty string instead of null for rejection_reason to avoid NOT NULL constraint
                $updateData['rejection_reason'] = '';
            }

            // Only update pickup status if document is approved
            if ($newStatus === 'approved') {
                $updateData['pickup_status'] = $pickupStatus ?? 'pending';
            } else {
                $updateData['pickup_status'] = 'pending';
            }

            // Update the document
            $documentRequest->update($updateData);

            // Create notifications for status changes (only if status actually changed)
            if (strtolower($oldStatus) !== strtolower($newStatus)) {
                $this->createStatusChangeNotification($documentRequest, $newStatus, $reason);
            }

            return response()->json([
                'success' => true,
                'message' => 'Document request updated successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating document request', [
                'exception' => $e->getMessage(),
                'id' => $id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating document request: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method to update pickup status (already exists and looks okay)
    public function updatePickupStatus(Request $request)
    {
        // Your existing code here... looks fine
        $requestId = $request->input('requestId');
        $newStatus = $request->input('newStatus');

        try {
            $documentRequest = DocumentRequest::findOrFail($requestId);
            // Add validation: only allow update if status is 'Approved'
            if (strtolower($documentRequest->Status) !== 'approved') {
                 return response()->json(['success' => false, 'error' => 'Document must be approved to update pickup status.']);
            }
            $documentRequest->update(['pickup_status' => $newStatus]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error updating pickup status for ID {$requestId}: " . $e->getMessage()); // Add logging
            return response()->json(['success' => false, 'error' => 'Failed to update pickup status.']); // Generic error message
        }
    }

    // Helper method to create status change notifications
    private function createStatusChangeNotification($documentRequest, $newStatus, $reason = null)
    {
        try {
            // Only create notification if we have a valid user ID
            if (!$documentRequest->userId) {
                Log::warning("No userId found for document request ID: " . $documentRequest->Id);
                return;
            }

            $title = '';
            $message = '';

            switch (strtolower($newStatus)) {
                case 'approved':
                    $title = 'Document Approved';
                    $message = "Your {$documentRequest->DocumentType} request has been approved. Please visit the barangay office to pick it up during office hours (Monday-Friday, 8:00 AM - 5:00 PM).";
                    break;
                    
                case 'rejected':
                    $title = 'Document Rejected';
                    $message = "Your {$documentRequest->DocumentType} request has been rejected.";
                    if ($reason) {
                        $message .= " Reason: {$reason}";
                    }
                    $message .= " Please contact the barangay office for more information.";
                    break;
                    
                case 'cancelled':
                    $title = 'Document Cancelled';
                    $message = "Your {$documentRequest->DocumentType} request has been cancelled.";
                    break;
                    
                case 'overdue':
                    $title = 'Document Overdue';
                    $message = "Your {$documentRequest->DocumentType} request is now overdue. Please contact the barangay office.";
                    break;
                    
                default:
                    // Don't create notification for other status changes
                    return;
            }

            // Create the notification record directly in database
            DB::table('notifications')->insert([
                'user_id' => $documentRequest->userId,
                'type' => 'document_status',
                'title' => $title,
                'message' => $message,
                'related_id' => $documentRequest->Id,
                'is_read' => false,
                'created_at' => now(),
            ]);

            Log::info("Notification created for user {$documentRequest->userId} - Document {$documentRequest->Id} status changed to {$newStatus}");

        } catch (\Exception $e) {
            Log::error('Error creating notification: ' . $e->getMessage(), [
                'document_id' => $documentRequest->Id,
                'user_id' => $documentRequest->userId,
                'status' => $newStatus
            ]);
        }
    }

    // Helper function for price calculation (extracted from old PHP)
    private function calculatePrice($documentType, $quantity) {
        switch($documentType) {
            case 'Barangay Clearance':
            case 'Barangay Certification':
            case 'Certificate of Indigency':
            case 'First Time Job Certificate':
                // Ensure quantity is treated as a number
                $quantity = intval($quantity);
                if ($quantity <= 0) $quantity = 1; // Default to 1 if quantity is invalid
                return "₱" . number_format(50.00 * $quantity, 2);
            case 'Cedula':
                return 'Depends on the income';
            default:
                return 'Price not set';
        }
    }
}