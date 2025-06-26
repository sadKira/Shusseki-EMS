<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;


class FilterTable extends Component
{
    use WithPagination;

    #[Url]
    public int $page = 1;

    public string $sortField = 'name'; // default sort field
    
  
    public string $sortDirection = 'asc'; // or 'desc'

   
    protected $paginationTheme = 'tailwind';

    // Reset pagination when filters change
    public function updating($field)
    {
        if (in_array($field, ['selectedStatus', 'selectedStatus_level', 'selectedStatus_course'])) {
            $this->resetPage();
        }
    }

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

        // return redirect(request()->route('manage_approval')); 
    }

    #[Url]
    public $selectedStatus = 'Active Students';
   

    // #[Url]
    // public $selectedStatus_level = 'All';

    // #[Url]
    // public $selectedStatus_course = 'All';


    // Set active dropdown for active & inactive

    // public function selectStatus($status)
    // {
    //     $this->selectedStatus = $status;
    // }
    public function render()
    {
        // Query builder
        $users = User::query();

        // Base filters: role and status
        $users->where('status', 'approved')
            ->where('role', 'user');

        // Active/Inactive conditions
        if ($this->selectedStatus == 'Active Students') {
            $users->where('account_status', 'active');
        } else {
            $users->where('account_status', 'inactive');
        }

        // // Year level filter
        // if ($this->selectedStatus_level !== 'All') {
        //     $users->where('year_level', $this->selectedStatus_level);
        // } 

        // // Course filter
        // if ($this->selectedStatus_course !== 'All') {
        //     $users->where('course', $this->selectedStatus_course);
        // }

        // Execute query
        $users = $users
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10); // you can change the number per page

        return view('livewire.management.filter-table', ['users' => $users]);
    }

}