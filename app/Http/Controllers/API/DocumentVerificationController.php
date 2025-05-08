<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpseclib3\Crypt\RSA;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

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
        $documentSignature = DB::table('document_signatures')
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
        
        if (!$documentSignature) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid document signature. This document could not be verified.'
            ], 404);
        }

        // Check document expiry
        $expiry = Carbon::parse($documentSignature->expiry_date ?? 
                               Carbon::parse($documentSignature->created_at)->addYear()->format('Y-m-d H:i:s'));
        
        $now = Carbon::now();
        $isExpired = $now->gt($expiry);
        
        // Perform cryptographic verification if possible
        $verified = false;
        $verificationMethod = "database";
        
        if (!empty($documentSignature->public_key) && !empty($documentSignature->signed_data)) {
            try {
                // Load public key
                $publicKey = RSA::loadPublicKey($documentSignature->public_key);
                
                // Get the original signed data
                $originalData = $documentSignature->signed_data;
                
                // Convert base64 signature back to binary for verification
                $signatureData = base64_decode($signature);
                
                // Verify the signature with phpseclib3
                $verified = $publicKey->verify($originalData, $signatureData);
                
                if ($verified) {
                    $verificationMethod = "cryptographic";
                    Log::info('Document verified via cryptographic method successfully.');
                } else {
                    Log::warning('Cryptographic verification failed for signature: ' . $signatureHash);
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid document signature. Cryptographic verification failed.'
                    ], 400);
                }
            } catch (\Exception $e) {
                // Log the verification error
                Log::error('Document verification error: ' . $e->getMessage());
                
                // Return error response when verification fails
                return response()->json([
                    'success' => false,
                    'message' => 'Error verifying document: ' . $e->getMessage()
                ], 400);
            }
        } else {
            // If required data is missing, return error
            return response()->json([
                'success' => false,
                'message' => 'Incomplete signature data. This document cannot be cryptographically verified.'
            ], 400);
        }
        
        // Get verification details from signed data if available
        $documentDetails = [];
        if (!empty($documentSignature->signed_data)) {
            $documentDetails = json_decode($documentSignature->signed_data, true);
        }
        
        if ($verified) {
            // Document is verified
            return response()->json([
                'success' => true,
                'message' => $isExpired ? 'Document verified but has expired.' : 'Document verified successfully.',
                'document_info' => [
                    'document_type' => $documentSignature->DocumentType,
                    'requester_name' => $documentSignature->Name,
                    'address' => $documentSignature->Address,
                    'age' => $documentSignature->Age,
                    'birthday' => $documentSignature->birthday,
                    'purpose' => $documentSignature->Purpose,
                    'issued_date' => $documentSignature->created_at,
                    'expires_on' => $expiry->format('Y-m-d H:i:s'),
                    'is_expired' => $isExpired,
                    'verified' => true,
                    'verification_method' => $verificationMethod,
                    'document_details' => $documentDetails
                ]
            ]);
        } else {
            // Signature verification failed
            return response()->json([
                'success' => false,
                'message' => 'Invalid document signature. Verification failed.'
            ], 400);
        }
    }
}