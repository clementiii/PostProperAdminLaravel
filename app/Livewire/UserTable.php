<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\UserAccount;
use Livewire\WithPagination;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterField = '';
    public $sortField = 'lastName';
    public $sortDirection = 'asc';
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
        // Set inactive threshold
        $inactiveThreshold = now()->subDays(30);

        $query = UserAccount::query()
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

        // Get total counts for statistics - Only count verified users
        $verifiedUsers = UserAccount::where('status', 'verified')->get();
        $registeredResidentsCount = $verifiedUsers->count();
        
        // For active users, only count verified users who were active in the last 30 days
        $activeUsersCount = $verifiedUsers->where('last_active', '>=', $inactiveThreshold)->count();
        
        // Inactive users are verified users who haven't been active in the last 30 days
        $inactiveUsersCount = $registeredResidentsCount - $activeUsersCount;

        return view('livewire.user-table', [
            'users' => $users,
            'registeredResidentsCount' => $registeredResidentsCount,
            'activeUsersCount' => $activeUsersCount,
            'inactiveUsersCount' => $inactiveUsersCount
        ]);
    }
}