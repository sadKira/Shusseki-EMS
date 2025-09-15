<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use App\Models\Setting;
use App\Enums\AccountStatus;
use App\Enums\TsuushinRole;
use Flux\Flux;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApprove;
use App\Mail\Test;

class FilterTable extends Component
{
    use WithPagination;

    // Global schoolyear
    public $selectedSchoolYear;

    // Percentage display
    // public  $activePercentage;
    // public $inactivePercentage;

    // Filtering
    public $search = '';
    public $selection = true;
    public $selectedStatus = 'Active Accounts';
    public $selectedStatus_level = 'All';
    public $selectedStatus_course = 'All';

    // Sorting
    public $sortField = 'name'; // default 
    public $sortDirection = 'asc'; // 'desc'

    // Multi select
    public $selected = [];
    public $selectAll = false;
    public $selectPage = false;

    protected function clearUserCaches(): void
    {
        Cache::forget('students:counts:approved');
        Cache::forget('students:counts:active');
        Cache::forget('students:counts:inactive');
        Cache::forget('students:counts:tsuushin');
        Cache::forget('students:counts:pending');

        // Clear school-year related student records
        $schoolYear = Setting::getSchoolYear();
        Cache::forget("students:attendance:doughnut:{$schoolYear}");
        Cache::forget("students:missing:count:{$schoolYear}");
        Cache::forget("students:base:counts:{$schoolYear}");
        Cache::forget("events:finished:{$schoolYear}");
        Cache::forget("attendance:logs:{$schoolYear}");
    }

    // Reset pagination when search changes
    public function updatingSearch()
    {
        $this->resetPage();
        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;
    }

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
        $this->search = '';
    }


    // Active Accounts table
    // Mark as inactive
    public function markInactive($userId)
    {
        $user = User::find($userId);
        $user->update(['account_status' => 'inactive']);

        $this->cancelSelection();

        // Close modal
        Flux::modals()->close();

    }

    // Test Email
    public function sendEmail($userId)
    {
        $user = User::find($userId);

        Mail::to($user->email)->queue(new AccountApprove($user));

        $this->cancelSelection();


    }

    // Mark selected as inactive
    public function bulkmarkInactive()
    {
        User::whereIn('id', $this->selected)
        // ->where('tsuushin', TsuushinRole::NotMember)
        ->update(['account_status' => 'inactive']);
        $this->cancelSelection();
        $this->toggleSelection();

        // Clear cache manually
        $this->clearUserCaches();

        // Close modal
        Flux::modals()->close();
      
    }

    // Mark ALL existing as inactive
    public function totalbulkmarkInactive()
    {
        User::where('account_status', 'active')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->whereNotIn('status', ['pending'])
        ->where('tsuushin', TsuushinRole::NotMember)
        ->update(['account_status' => 'inactive']);
        
        // Clear cache manually
        $this->clearUserCaches();

        $this->toggleSelection();
        $this->cancelSelection();

        // Close modal
        Flux::modals()->close();

    }

    // Inactive Accounts table
    // Remove account
    public function removeAccount($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete(); 

        // Close modal
        Flux::modals()->close();

    }

    // Remove selected account
    public function bulkremoveAccount()
    {
        User::whereIn('id', $this->selected)->delete();
        $this->cancelSelection();
        $this->toggleSelection();

        // Clear cache manually
        $this->clearUserCaches();

        // Close modal
        Flux::modals()->close();
    }

    // Remove ALL existing inactive accounts
    public function totalbulkremoveAccount()
    {
        User::where('account_status', 'inactive')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->whereNotIn('status', ['pending'])
        ->delete();

        // dd(User::where('account_status', 'inactive')->toSql());
        // Clear cache manually
        $this->clearUserCaches();

        $this->toggleSelection();
        $this->cancelSelection();

        // Close modal
        Flux::modals()->close();

    }

    // Mark as active
    public function markActive($userId)
    {
        $user = User::find($userId);
        $user->update(['account_status' => 'active']);

        $this->cancelSelection();   

        // Close modal
        Flux::modals()->close();

    }

    // Mark selected as active
    public function bulkmarkActive()
    {
        User::whereIn('id', $this->selected)->update(['account_status' => 'active']);
        $this->cancelSelection();
        $this->toggleSelection();

        // Clear cache manually
        $this->clearUserCaches();
      
        // Close modal
        Flux::modals()->close();
    }

    // Mark ALL existing as active
    public function totalbulkmarkActive()
    {
        User::where('account_status', 'inactive')
        ->whereNotIn('role', ['admin', 'super_admin', 'tsuushin'])
        ->whereNotIn('status', ['pending'])
        ->update(['account_status' => 'active']);
       

        // Clear cache manually
        $this->clearUserCaches();

        $this->toggleSelection();
        $this->cancelSelection();

        // Close modal
        Flux::modals()->close();
                
    }

    // Mark student as Tsuushin
    public function markTsuushin($userId)
    {
        $user = User::find($userId);
        $user->update(['tsuushin' => 'member']);

        $this->cancelSelection();

        // Close modal
        Flux::modals()->close();

    }

    // Revoke student as Tsuushin
    public function removeTsuushin($userId)
    {
        $user = User::find($userId);
        $user->update(['tsuushin' => 'not_member']);

        $this->cancelSelection();

        // Close modal
        Flux::modals()->close();

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

        // Retrieve the globally set school year from session
        $this->selectedSchoolYear = Setting::getSchoolYear();
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

        // Get total approved users count (cached)
        $totalApproved = Cache::remember('students:counts:approved', 600, function () use ($baseQuery) {
            return (clone $baseQuery)->count();
        });

        // Count of active and inactive users among approved users (cached)
        $activeCount = Cache::remember('students:counts:active', 600, function () use ($baseQuery) {
            return (clone $baseQuery)
                ->where('account_status', 'active')
                ->count();
        });

        $inactiveCount = Cache::remember('students:counts:inactive', 600, function () use ($baseQuery) {
            return (clone $baseQuery)
                ->where('account_status', 'inactive')
                ->count();
        });

        // Tsuushin Member Count (cached)
        $tsuushinCount = Cache::remember('students:counts:tsuushin', 600, function () use ($baseQuery) {
            return (clone $baseQuery)
                ->where('tsuushin', 'member')
                ->count();
        });

        // Build the filtered query for display
        $filteredQuery = (clone $baseQuery)
            ->when($this->selectedStatus === 'Active Accounts', function ($query) {
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
            // Prioritize tsuushin = 'member'
            ->orderByRaw("CASE WHEN tsuushin = 'member' THEN 0 ELSE 1 END")
            ->orderBy($this->sortField, $this->sortDirection);

        

        // Percentage display
        $activePercentage = $totalApproved > 0 ? round(($activeCount / $totalApproved) * 100, 1) : 0;
        $inactivePercentage = $totalApproved > 0 ? round(($inactiveCount / $totalApproved) * 100, 1) : 0;

        return view('livewire.management.filter-table', [
            'users' => $filteredQuery->paginate(10),
            'totalApproved' => $totalApproved,
            'activeCount' => $activeCount,
            'inactiveCount' => $inactiveCount,
            'tsuushinCount' => $tsuushinCount,
            'schoolYear' => $this->selectedSchoolYear,
            'activePercentage' => $activePercentage,
            'inactivePercentage' => $inactivePercentage,
        ]);
    }
}
