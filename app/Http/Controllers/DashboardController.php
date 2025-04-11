<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function show($id)
    {
        try {
            $request = DocumentRequest::find($id);

            if (!$request) {
                return response()->json(['error' => 'Document request not found'], 404);
            }

            // Format dates if present
            if ($request->DateRequested) {
                $request->DateRequested = \Carbon\Carbon::parse($request->DateRequested)->format('F d, Y h:i A');
            }
            
            if ($request->date_approved) {
                $request->date_approved = \Carbon\Carbon::parse($request->date_approved)->format('F d, Y h:i A');
            }

            return response()->json($request);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error retrieving document request: ' . $e->getMessage()], 500);
        }
    }
}




