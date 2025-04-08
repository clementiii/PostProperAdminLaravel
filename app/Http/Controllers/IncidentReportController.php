<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class IncidentReportController extends Controller
{
    public function index()
    {
        // Get a list of incident reports for the index page
        $incidentReports = IncidentReport::orderBy('created_at', 'desc')->paginate(10);
        return view('reports.incident_report', compact('incidentReports'));
    }

    public function show(IncidentReport $incidentReport)
    {
        // Return the verification view and pass the report data to it
        return view('report_verify', compact('incidentReport'));
    }
    
    /**
     * Mark an incident report as resolved
     *
     * @param IncidentReport $incidentReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsResolved(IncidentReport $incidentReport)
    {
        try {
            $incidentReport->status = 'resolved';
            
            // Set resolved_at to current Manila time (Asia/Manila timezone)
            $incidentReport->resolved_at = Carbon::now('Asia/Manila');
            $incidentReport->save();
            
            return redirect()->route('incident-reports.show', $incidentReport)
                ->with('success', 'Report has been marked as resolved successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to mark report as resolved: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to mark report as resolved. Please try again.');
        }
    }
}