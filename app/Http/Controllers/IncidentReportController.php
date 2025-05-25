<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
            // Store old status to check for changes
            $oldStatus = $incidentReport->status;
            
            $incidentReport->status = 'resolved';
            
            // Set resolved_at to current Manila time (Asia/Manila timezone)
            $incidentReport->resolved_at = Carbon::now('Asia/Manila');
            $incidentReport->save();
            
            // Create notification for status change (only if status actually changed)
            if (strtolower($oldStatus) !== 'resolved') {
                $this->createIncidentStatusNotification($incidentReport, 'resolved');
            }
            
            return redirect()->route('incident-reports.show', $incidentReport)
                ->with('success', 'Report has been marked as resolved successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to mark report as resolved: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to mark report as resolved. Please try again.');
        }
    }

    /**
     * Helper method to create incident status change notifications
     */
    private function createIncidentStatusNotification($incidentReport, $newStatus)
    {
        try {
            // Only create notification if we have a valid user ID
            if (!$incidentReport->user_id) {
                Log::warning("No user_id found for incident report ID: " . $incidentReport->id);
                return;
            }

            $title = '';
            $message = '';

            switch (strtolower($newStatus)) {
                case 'resolved':
                    $title = 'Incident Report Resolved';
                    $message = "Your incident report '{$incidentReport->title}' has been resolved. Thank you for bringing this matter to our attention.";
                    break;
                    
                default:
                    // Don't create notification for other status changes
                    return;
            }

            // Create the notification record directly in database
            DB::table('notifications')->insert([
                'user_id' => $incidentReport->user_id,
                'type' => 'incident_status',
                'title' => $title,
                'message' => $message,
                'related_id' => $incidentReport->id,
                'is_read' => false,
                'created_at' => now(),
            ]);

            Log::info("Notification created for user {$incidentReport->user_id} - Incident {$incidentReport->id} status changed to {$newStatus}");

        } catch (\Exception $e) {
            Log::error('Error creating incident notification: ' . $e->getMessage(), [
                'incident_id' => $incidentReport->id,
                'user_id' => $incidentReport->user_id,
                'status' => $newStatus
            ]);
        }
    }
}