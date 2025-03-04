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


        return view('dashboard', compact('registeredResidents', 'pendingDocuments', 'incidentReports'));
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
