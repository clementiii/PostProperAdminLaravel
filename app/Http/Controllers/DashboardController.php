<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRequest;
use App\Models\UserAccount; // Import UserAccount model
use App\Models\IncidentReport; // Import IncidentReport model
use Illuminate\Support\Facades\Log; // Optional: For logging errors

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    // Method to show details for a specific document request (used by dashboard.js modal)
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
            Log::error("Error retrieving document request ID {$id}: " . $e->getMessage()); // Log the error
            return response()->json(['error' => 'Error retrieving document request details.'], 500); // Generic error message
        }
    }

    // ** FIX: Add the missing fetchData method with caching **
    public function fetchData(Request $request)
    {
        try {
            // Cache key for dashboard data
            $cacheKey = 'dashboard_stats';
            $cacheDuration = 30; // 30 seconds cache duration
            
            // Check if data is cached
            $cachedData = \Illuminate\Support\Facades\Cache::get($cacheKey);
            if ($cachedData) {
                Log::info("Dashboard data served from cache");
                return response()->json($cachedData);
            }
            
            Log::info("Fetching fresh dashboard data from database");
            
            // Fetch counts from respective models
            // Ensure your UserAccount model correctly represents residents
            $registeredResidents = UserAccount::where('status', 'verified')->count(); // Example: Count only verified users

            // Count pending document requests
            $pendingDocuments = DocumentRequest::where('Status', 'pending')->count();

            // Count unresolved incident reports (adjust status value if needed)
            $incidentReports = IncidentReport::where('status', 'pending')->count(); // Assuming 'pending' means unresolved

            // Prepare response data
            $data = [
                'registeredResidents' => $registeredResidents,
                'pendingDocuments' => $pendingDocuments,
                'incidentReports' => $incidentReports,
            ];
            
            // Cache the data
            \Illuminate\Support\Facades\Cache::put($cacheKey, $data, $cacheDuration);
            
            // Return data in JSON format matching what dashboard.js expects
            return response()->json($data);

        } catch (\Exception $e) {
            // Log any error that occurs during data fetching
            Log::error("Error fetching dashboard data: " . $e->getMessage());

            // Return a generic error response
            // Avoid sending detailed exception messages to the client in production
            return response()->json(['error' => 'Failed to fetch dashboard data.'], 500);
        }
    }
    
    /**
     * Clear dashboard cache - call this when data changes that affect dashboard stats
     */
    public static function clearDashboardCache()
    {
        \Illuminate\Support\Facades\Cache::forget('dashboard_stats');
        Log::info("Dashboard cache cleared");
    }
}
