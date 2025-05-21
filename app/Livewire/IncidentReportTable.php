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
    public $filterField = '';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field 
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
            
        $this->sortField = $field;
    }
    
    public function updatingFilterField()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = IncidentReport::query();
        
        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('title', 'like', '%'.$this->search.'%');
            });
        }
        
        // Apply filter
        if ($this->filterField) {
            if ($this->filterField === 'title') {
                $query->orderBy('title');
            } elseif ($this->filterField === 'date_submitted') {
                $query->orderBy('date_submitted', 'desc');
            } elseif ($this->filterField === 'status') {
                $query->orderBy('status');
            }
        }
        
        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);
        
        $reports = $query->paginate($this->perPage);

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