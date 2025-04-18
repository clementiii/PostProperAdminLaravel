<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentVerificationController extends Controller
{
    /**
     * Verify a document signature from QR code
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        // Validate request
        $request->validate([
            'signature' => 'required|string'
        ]);

        $signature = $request->input('signature');
        $signatureHash = hash('sha256', $signature);
        
        // Check if signature exists in database
        $document = DB::table('document_signatures')
            ->join('document_requests', 'document_signatures.document_request_id', '=', 'document_requests.Id')
            ->where('document_signatures.signature_hash', $signatureHash)
            ->select(
                'document_signatures.*', 
                'document_requests.Name', 
                'document_requests.DocumentType',
                'document_requests.Address', 
                'document_requests.Age', 
                'document_requests.birthday',
                'document_requests.Purpose'
            )
            ->first();
        
        if ($document) {
            // Document is verified
            return response()->json([
                'success' => true,
                'message' => 'Document verified successfully',
                'document_info' => [
                    'document_type' => $document->DocumentType,
                    'requester_name' => $document->Name,
                    'address' => $document->Address,
                    'age' => $document->Age,
                    'birthday' => $document->birthday,
                    'purpose' => $document->Purpose,
                    'issued_date' => $document->created_at,
                    'verified' => true
                ]
            ]);
        } else {
            // Document not found
            return response()->json([
                'success' => false,
                'message' => 'Invalid document signature. This document could not be verified.'
            ], 404);
        }
    }
}