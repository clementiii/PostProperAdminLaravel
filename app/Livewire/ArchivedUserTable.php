<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserAccount;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;

class ArchivedUserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterField = '';
    public $sortField = 'archived_at';
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
        $query = UserAccount::query()
            ->where('archived', 1) // Only show archived users
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('firstName', 'like', '%' . $this->search . '%')
                        ->orWhere('lastName', 'like', '%' . $this->search . '%')
                        ->orWhere('adrStreet', 'like', '%' . $this->search . '%')
                        ->orWhere('adrZone', 'like', '%' . $this->search . '%')
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterField, function ($query) {
                $query->orderBy($this->filterField);
            })
            ->orderBy($this->sortField, $this->sortDirection);

        // Get paginated results
        $users = $query->paginate($this->perPage);
        
        // Format date for each user
        foreach ($users as $user) {
            try {
                if ($user->archived_at) {
                    $user->formatted_archived_at = Carbon::parse($user->archived_at)->format('M d, Y h:i A');
                } else {
                    $user->formatted_archived_at = 'N/A';
                }
            } catch (\Exception $e) {
                $user->formatted_archived_at = 'N/A';
            }
        }
        
        // Count total archived users
        $archivedCount = UserAccount::where('archived', 1)->count();

        return view('livewire.archived-user-table', [
            'users' => $users,
            'archivedCount' => $archivedCount
        ]);
    }
}
