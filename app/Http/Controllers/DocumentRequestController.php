<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $documentRequests = DocumentRequest::all();

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
        $documentRequest = DocumentRequest::findOrFail($id);
        return view('document_verify', compact('documentRequest'));
    }

    public function update(Request $request, $id)
    {
        $documentRequest = DocumentRequest::findOrFail($id);

        $newStatus = $request->input('status');
        $reason = $request->input('reason');

        if ($newStatus === 'Rejected' && empty($reason)) {
            return redirect()->back()->with('error', 'Please provide a reason for rejection.');
        }

        $dateApproved = null;
        if ($newStatus === 'Approved') {
            $dateApproved = now(); // Use Carbon for datetime handling
        }

        $documentRequest->update([
            'Status' => $newStatus,
            'rejection_reason' => $reason,
            'date_approved' => $dateApproved,
        ]);

        return redirect()->route('documents.index')->with('success', 'Document request updated!');
    }

    public function updatePickupStatus(Request $request)
    {
        $requestId = $request->input('requestId');
        $newStatus = $request->input('newStatus');

        try {
            $documentRequest = DocumentRequest::findOrFail($requestId);
            $documentRequest->update(['pickup_status' => $newStatus]);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}