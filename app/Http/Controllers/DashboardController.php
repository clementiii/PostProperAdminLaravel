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
        $request = DocumentRequest::find($id);

        if (!$request) {
            return response()->json(['error' => 'Document request not found'], 404);
        }

        return response()->json($request);
    }
}




