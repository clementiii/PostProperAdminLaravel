<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DocumentRequest;

class DocumentRequests extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';
    public $perPage = 10;

    protected $queryString = ['search', 'statusFilter', 'dateFilter', 'perPage'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage(); // Ensure pagination resets when the filter changes
    }

    public function updatingDateFilter()
    {
        $this->resetPage(); // Ensure pagination resets when the date filter changes
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'statusFilter' || $propertyName === 'dateFilter') {
            $this->resetPage(); // Reset pagination when filters are updated
        }
    }

    public function render()
    {
        $documentRequests = DocumentRequest::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('Name', 'like', '%' . $this->search . '%')
                      ->orWhere('Id', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('Status', $this->statusFilter); // Ensure exact match for the filter
            })
            ->when($this->dateFilter, function ($query) {
                // Using LIKE for partial date matching (e.g., year only, month and year, etc.)
                if ($this->dateFilter === 'today') {
                    $query->whereDate('DateRequested', now()->format('Y-m-d'));
                } elseif ($this->dateFilter === 'this_week') {
                    $query->whereBetween('DateRequested', [now()->startOfWeek()->format('Y-m-d'), now()->endOfWeek()->format('Y-m-d')]);
                } elseif ($this->dateFilter === 'this_month') {
                    $query->whereMonth('DateRequested', now()->month)
                          ->whereYear('DateRequested', now()->year);
                } elseif ($this->dateFilter === 'this_year') {
                    $query->whereYear('DateRequested', now()->year);
                }
            })
            ->orderBy('DateRequested', 'desc') // Sort by latest document request
            ->paginate($this->perPage);

        $totalRequest = DocumentRequest::count();
        $pendingCount = DocumentRequest::where('Status', 'pending')->count();
        $approvedCount = DocumentRequest::where('Status', 'approved')->count();
        $rejectedCount = DocumentRequest::where('Status', 'rejected')->count();
        $overdueCount = DocumentRequest::where('Status', 'overdue')->count();

        return view('livewire.document-requests', compact(
            'documentRequests',
            'totalRequest',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'overdueCount'
        ));
    }
}
