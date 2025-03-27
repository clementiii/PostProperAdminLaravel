<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $documentRequest = DocumentRequest::findOrFail($id);

        $request->validate([ // Add basic validation
            'status' => 'required|string|in:Pending,Approved,Rejected,Cancelled',
            'reason' => 'required_if:status,Rejected|nullable|string|max:255',
        ]);

        $newStatus = $request->input('status');
        $reason = $request->input('reason'); // Null if not provided

        $dateApproved = $documentRequest->date_approved; // Keep existing if not changing to Approved
        if ($newStatus === 'Approved' && $documentRequest->Status !== 'Approved') {
            // Set approval date only when status changes to Approved
            $dateApproved = Carbon::now('Asia/Manila'); // Use Carbon and correct timezone
        }

        // Prepare data for update
        $updateData = [
            'Status' => $newStatus,
            // Store null if status is not 'Rejected' or reason is empty
            'rejection_reason' => ($newStatus === 'Rejected') ? $reason : null,
            'date_approved' => $dateApproved,
        ];

        // If changing *away* from Approved, clear the approval date (optional, depends on logic)
        // if ($newStatus !== 'Approved') {
        //     $updateData['date_approved'] = null;
        // }


        $documentRequest->update($updateData);

        // Redirect back to the documents list with a success message
        return redirect()->route('documents.index')->with('success', 'Document request updated successfully!');
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