<?php

namespace App\Http\Controllers;

use App\Models\IncidentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade if not already imported
use Illuminate\View\View; // Import View class

class ReportsController extends Controller
{
    public function index(): View // Specify return type as View
    {
        // Summary Statistics using Laravel Query Builder (safer and more Laravel-like)
        $totalReports = IncidentReport::count();
        $pendingReports = IncidentReport::where('status', 'pending')->count();
        $resolvedReports = IncidentReport::where('status', 'resolved')->count();

        // Fetch reports for the table using Eloquent
        $reports = IncidentReport::select(['id', 'name', 'title', 'description', 'date_submitted', 'status'])->get();

        return view('reports.index', [ // Ensure view path is correct: reports.index
            'totalReports' => $totalReports,
            'pendingReports' => $pendingReports,
            'resolvedReports' => $resolvedReports,
            'reports' => $reports,
        ]);
    }

    public function truncateDescription($description, $maxWords = 12): string
    {
        $words = explode(' ', $description);
        if (count($words) > $maxWords) {
            return implode(' ', array_slice($words, 0, $maxWords)) . '...';
        }
        return $description;
    }
}