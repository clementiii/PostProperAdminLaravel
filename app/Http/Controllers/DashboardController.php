<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DocumentRequest;
use App\Models\IncidentReport;
use App\Models\UserAccount;


class DashboardController extends Controller
{
    public function index()
    {
        $registeredResidents = UserAccount::count();
        $pendingDocuments = DocumentRequest::where('status', 'pending')->count();
        $incidentReports = IncidentReport::count();


        $recentRequests = DocumentRequest::orderBy('id', 'desc')
        ->take(10)
        ->get(['id', 'Name', 'DocumentType', 'Quantity', 'DateRequested','Status','Gender','Address', ]);




        return view('dashboard', compact('registeredResidents', 'pendingDocuments', 'incidentReports', 'recentRequests'));
    }
    public function show($id,)
{
    $request = DocumentRequest::find($id);


    if (!$request) {
        return response()->json(['error' => 'Document request not found'], 404);
    }


    return response()->json($request);
}




    public function fetchData()
    {
        return response()->json([
            'registeredResidents' => User::count(),
            'pendingDocuments' => DocumentRequest::where('status', 'pending')->count(),
            'incidentReports' => IncidentReport::count(),
        ]);
    }
}




