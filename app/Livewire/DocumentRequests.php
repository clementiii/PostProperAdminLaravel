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

    protected $queryString = ['search', 'statusFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage(); // Ensure pagination resets when the filter changes
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'statusFilter') {
            $this->resetPage(); // Reset pagination when statusFilter is updated
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
            ->paginate(10);

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
