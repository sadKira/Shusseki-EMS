<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class FilterTable extends Component
{
    use WithPagination;

    // Filtering
    public $search = '';
    public $selection = true;
    public $selectedStatus = 'Active Students';
    public $selectedStatus_level = 'All';
    public $selectedStatus_course = 'All';

    // Sorting
    public $sortField = 'name'; // default 
    public $sortDirection = 'asc'; // 'desc'

    // Multi select
    public $selected = [];
    public $selectAll = false;
    public $selectPage = false;

    // Multi selection
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selected = $this->users->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function cancelSelection()
    {
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }


    // Active students table
    // Mark as inactive
    public function markInactive($userId)
    {
        $user = User::find($userId);
        $user->update(['account_status' => 'inactive']);
        session()->flash('message', "{$user->name} has been marked inactive.");


    }

    // Mark selected as inactive
    public function bulkmarkInactive()
    {
        User::whereIn('id', $this->selected)->update(['account_status' => 'inactive']);
        $this->cancelSelection();
        session()->flash('message', 'Selected users marked inactive.');

        $this->toggleSelection();
      
    }

    // Mark ALL existing as inactive
    public function totalbulkmarkInactive()
    {
        User::where('account_status', 'active')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->whereNotIn('status', ['pending'])
        ->update(['account_status' => 'inactive']);
        session()->flash('message', 'All pending users rejected and deleted.');

        $this->toggleSelection();
        $this->cancelSelection();

    }

    // Inactive Students table
    // Remove account
    public function removeAccount($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete(); 

    }

    // Remove selected account
    public function bulkremoveAccount()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->cancelSelection();
        session()->flash('message', 'Selected users removed.');

        $this->toggleSelection();

    }

    // Remove ALL existing inactive accounts
    public function totalbulkremoveAccount()
    {
        User::where('account_status', 'inactive')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->whereNotIn('status', ['pending'])
        ->delete();
        session()->flash('message', 'All exisitng users removed.');

        // dd(User::where('account_status', 'inactive')->toSql());

        $this->toggleSelection();
        $this->cancelSelection();

    }

    // Mark as active
    public function markActive($userId)
    {
        $user = User::find($userId);
        $user->update(['account_status' => 'active']);
        session()->flash('message', "{$user->name} has been marked active.");

    }

    // Mark selected as active
    public function bulkmarkActive()
    {
        User::whereIn('id', $this->selected)->update(['account_status' => 'active']);
        $this->cancelSelection();
        session()->flash('message', 'Selected users marked active.');

        $this->toggleSelection();
      
    }

    // Mark ALL existing as active
    public function totalbulkmarkActive()
    {
        User::where('account_status', 'inactive')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->whereNotIn('status', ['pending'])
        ->update(['account_status' => 'active']);
        session()->flash('message', 'All users marked as active.');

        $this->toggleSelection();
        $this->cancelSelection();
                
    }
    
    // Clear filters
    public function clearFilters()
    {
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
        $this->selectedStatus_level = 'All';
        $this->selectedStatus_course = 'All';
        $this->search = '';
        $this->resetPage();
    }

    // Filters logic
    public function updating($field)
    {
        // Reset filters when switching to active and inactive
        if ($field === 'selectedStatus') {
            $this->clearFilters();
        }

        // Reset page (pagination) when filters added
        if (in_array($field, ['selectedStatus', 'selectedStatus_level', 'selectedStatus_course'])) {
            $this->resetPage();
        }
    }

    // Sorting
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            // If already sorting by the same field, reverse the direction
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Multi select
    public function mount()
    {
        $this->selection = true;
    }

    public function toggleSelection()
    {
        $this->selection = !$this->selection;
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }

    public function render()
    {
        // Base query: approved users with role = user
        $baseQuery = User::where('status', 'approved')
            ->where('role', 'user');

        // Get total approved users count
        $totalApproved = (clone $baseQuery)->count();

        // Count of active and inactive users among approved users
        $activeCount = (clone $baseQuery)
            ->where('account_status', 'active')
            ->count();

        $inactiveCount = (clone $baseQuery)
            ->where('account_status', 'inactive')
            ->count();

        // Build the filtered query for display
        $filteredQuery = (clone $baseQuery)
            ->when($this->selectedStatus === 'Active Students', function ($query) {
                $query->where('account_status', 'active');
            }, function ($query) {
                $query->where('account_status', 'inactive');
            })
            ->when($this->selectedStatus_level !== 'All' && $this->selectedStatus_level !== null, function ($query) {
                $query->where('year_level', $this->selectedStatus_level);
            })
            ->when($this->selectedStatus_course !== 'All' && $this->selectedStatus_course !== null, function ($query) {
                $query->where('course', $this->selectedStatus_course);
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortDirection);

        return view('livewire.management.filter-table', [
            'users' => $filteredQuery->paginate(10),
            'totalApproved' => $totalApproved,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
        ]);
    }
}
