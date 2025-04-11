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
            // Add detailed logging
            Log::info('Update request received', [
                'id' => $id,
                'inputs' => $request->all()
            ]);
            
            $documentRequest = DocumentRequest::findOrFail($id);
            
            // Debug info
            $originalStatus = $documentRequest->Status;
            $originalData = $documentRequest->toArray();
            
            Log::info('Original document data', [
                'data' => $originalData
            ]);
            
            $request->validate([
                'status' => 'required|string|in:pending,approved,rejected,cancelled,overdue',
                'reason' => 'required_if:status,rejected|nullable|string|max:255',
                'pickup_status' => 'nullable|string|in:pending,picked_up',
            ]);

            $newStatus = $request->input('status');
            $reason = $request->input('reason');
            $pickupStatus = $request->input('pickup_status');

            $dateApproved = $documentRequest->date_approved;
            if ($newStatus === 'approved' && strtolower($documentRequest->Status) !== 'approved') {
                $dateApproved = Carbon::now('Asia/Manila');
            }

            // Prepare data for update
            $updateData = [
                'Status' => $newStatus,
                'rejection_reason' => ($newStatus === 'rejected') ? $reason : null,
                'date_approved' => $dateApproved,
            ];

            // Only update pickup status if document is approved
            if ($newStatus === 'approved') {
                $updateData['pickup_status'] = $pickupStatus ?? 'pending';
            } else {
                $updateData['pickup_status'] = 'pending';
            }
            
            Log::info('Update data prepared', [
                'data' => $updateData
            ]);

            // Try both direct DB update and model update
            try {
                // Direct DB update for debugging
                $updated = DB::table('document_requests')
                    ->where('Id', $id)
                    ->update($updateData);
                
                Log::info('Direct DB update result', [
                    'updated_rows' => $updated
                ]);
                
                if ($updated === 0) {
                    // If direct update failed, try with model
                    $documentRequest->fill($updateData);
                    $modelUpdated = $documentRequest->save();
                    
                    Log::info('Model update result', [
                        'success' => $modelUpdated
                    ]);
                }
            } catch (\Exception $dbException) {
                Log::error('Error during update operation', [
                    'exception' => $dbException->getMessage(),
                    'trace' => $dbException->getTraceAsString()
                ]);
                
                throw $dbException;
            }
                
            // Refetch the document to check if update worked
            $refreshedDoc = DocumentRequest::findOrFail($id);
            
            Log::info('Document refetched after update', [
                'data' => $refreshedDoc->toArray()
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Document request updated successfully!',
                'debug' => [
                    'id' => $id,
                    'original_status' => $originalStatus,
                    'new_status' => $newStatus,
                    'update_data' => $updateData,
                    'updated_rows' => $updated ?? 0,
                    'original_data' => $originalData,
                    'refreshed_data' => $refreshedDoc->toArray()
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error in update method', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error updating document request: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
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


    // Helper function for price calculation (extracted from old PHP)
    private function calculatePrice($documentType, $quantity) {
        switch($documentType) {
            case 'Barangay Clearance':
            case 'Barangay Certification':
            case 'Certificate of Indigency':
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