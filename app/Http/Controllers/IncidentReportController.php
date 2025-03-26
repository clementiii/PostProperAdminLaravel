<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;

class IncidentReportController extends Controller
{
    public function index()
    {
        return view('reports.incident_report');
    }

    public function show(IncidentReport $incidentReport)
    {
        // Return the verification view and pass the report data to it.
        return view('report_verify', compact('incidentReport'));
    }
    
}
