<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use Carbon\Carbon;

class ManageEvents extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedSchoolYear = 'All';
    public $selectedMonth;

    public $newSchoolYear = '';
    public $schoolYears = [];

    public $sortField = 'title';
    public $sortDirection = 'asc';

    public $selection = true;

    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
        $this->schoolYears = Setting::getAvailableSchoolYears(); // loads from SchoolYear model

    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Setting school year
    public function updateSchoolYear()
    {
        Setting::setSchoolYear($this->selectedSchoolYear);
    }

    public function updatedSelectedSchoolYear($value)
    {
        Setting::setSchoolYear($value);
    }

    public function addSchoolYear()
    {
        $this->validate([
            'newSchoolYear' => 'required|regex:/^\d{4}-\d{4}$/|unique:school_years,year',
        ]);

        SchoolYear::create(['year' => $this->newSchoolYear]);

        $this->newSchoolYear = '';
        $this->loadSchoolYears();
    }

    public function render()
    {
        $baseQuery = Event::with('tags');

        $filteredQuery = (clone $baseQuery)
            ->when($this->selectedSchoolYear !== 'All' && $this->selectedSchoolYear !== null, function ($query) {
                $query->where('school_year', $this->selectedSchoolYear);
            })
            ->when($this->selectedMonth !== 'All' && $this->selectedMonth !== null, function ($query) {
                $monthNumber = Carbon::parse("1 {$this->selectedMonth}")->month; // converts month to integer
                $query->whereMonth('date', $monthNumber);
            })
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortDirection);

            // dd($filteredQuery->toSql(), $filteredQuery->getBindings());
        return view('livewire.management.manage-events', [
            'events' => $filteredQuery->get(),
        ]);
    }
}
