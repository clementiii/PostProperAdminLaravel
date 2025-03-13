<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\IncidentReport;
use Livewire\WithPagination;

class IncidentReportTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'date_submitted';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field 
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
            
        $this->sortField = $field;
    }

    public function render()
    {
        $reports = IncidentReport::where('name', 'like', '%'.$this->search.'%')
            ->orWhere('title', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $totalReports = IncidentReport::count();
        $pendingReports = IncidentReport::where('status', 'pending')->count();
        $resolvedReports = IncidentReport::where('status', 'resolved')->count();

        return view('livewire.incident-report-table', [
            'reports' => $reports,
            'totalReports' => $totalReports,
            'pendingReports' => $pendingReports,
            'resolvedReports' => $resolvedReports,
        ]);
    }
}