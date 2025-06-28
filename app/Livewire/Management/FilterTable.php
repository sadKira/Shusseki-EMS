<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class FilterTable extends Component
{
    use WithPagination;

    // #[Url]
    // public int $page = 1;

    // Active students table
    // Mark as inactive
    public function markInactive($userId)
    {
        $user = User::find($userId);
        $user->update(['account_status' => 'inactive']);
        session()->flash('message', "{$user->name} has been marked inactive.");

        // return redirect(request()->route('manage_approval')); 
    }

    // Remove account
    public function removeAccount($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete(); // This permanently deletes the account

    }

    //Inactive Students table
    //Mark as active
    public function markActive($userId)
    {
        $user = User::find($userId);
        $user->update(['account_status' => 'active']);
        session()->flash('message', "{$user->name} has been marked active.");
    }

    // // Set active dropdown for active & inactive

    // // public function selectStatus($status)
    // // {
    // //     $this->selectedStatus = $status;
    // // }


    // Clear filters
    public function clearFilters()
    {
        $this->selectedStatus_level = 'All';
        $this->selectedStatus_course = 'All';
        $this->search = '';
        $this->resetPage();
    }



    public $perPage = 10;
    public $search = '';
    public $year = '';
    public $selectedStatus = 'Active Students';

    public $selectedStatus_level = 'All';
    public $selectedStatus_course = 'All';

    public $sortField = 'name'; // default 
    public $sortDirection = 'asc'; // 'desc'

    // Reset pagination when filters change
    public function updating($field)
    {
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

    // public function render()
    // {
    //     return view('livewire.management.filter-table', [
    //         'users' => User::search($this->search)
    //             ->where('status', 'approved')
    //             ->where('role', 'user')
    //             ->when($this->selectedStatus === 'Active Students', function ($query) {
    //                 $query->where('account_status', 'active');
    //             }, function ($query) {
    //                 $query->where('account_status', 'inactive');
    //             })
    //             ->when($this->selectedStatus_level != 'All' && $this->selectedStatus_level !== null,function ($query) {
    //                 $query->where('year_level', $this->selectedStatus_level);
    //             }) 
    //             ->when($this->selectedStatus_course != 'All'  && $this->selectedStatus_course !== null, function ($query) {
    //                 $query->where('course', $this->selectedStatus_course);
    //             })

    //             ->orderBy($this->sortField, $this->sortDirection)
    //             ->paginate(5)
    //     ]);
    // }

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
