<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DocumentRequest;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DocumentRequestTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterField = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = DocumentRequest::query()
            ->select([
                'Id',
                'Name',
                'DocumentType',
                'Quantity',
                'DateRequested',
                'Status'
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $searchTerm = $this->search;
                    if (Str::startsWith(strtolower($searchTerm), 'txn-')) {
                        $searchTerm = substr($searchTerm, 4); // Remove 'TXN-' prefix
                    }
                    
                    $query->where('Id', 'like', '%' . $searchTerm . '%')
                        ->orWhere('Name', 'like', '%' . $this->search . '%')
                        ->orWhere('DocumentType', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterField, function ($query) {
                $query->orderBy($this->filterField);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $requests = $query->paginate($this->perPage);

        // Get statistics
        $registeredResidents = \App\Models\UserAccount::count();
        $pendingDocuments = DocumentRequest::where('Status', 'pending')->count();
        $incidentReports = \App\Models\IncidentReport::count();

        // Debug the IDs
        foreach ($requests as $request) {
            $request->formatted_id = str_pad($request->Id, 2, '0', STR_PAD_LEFT);
        }

        return view('livewire.document-request-table', [
            'requests' => $requests,
            'registeredResidents' => $registeredResidents,
            'pendingDocuments' => $pendingDocuments,
            'incidentReports' => $incidentReports
        ]);
    }
} 