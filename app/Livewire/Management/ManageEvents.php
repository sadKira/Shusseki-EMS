<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use Carbon\Carbon;
use App\Enums\EventStatus;

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

    // Mounting data
    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
        $this->schoolYears = Setting::getAvailableSchoolYears(); // loads from SchoolYear model

    }

    // Obtaining events for the next month
    public function getNextMonthEventsProperty()
    {
        $startOfNextMonth = Carbon::parse($this->selectedMonth)->addMonth()->startOfMonth();
        $endOfNextMonth = Carbon::parse($this->selectedMonth)->addMonth()->endOfMonth();

        return Event::where('school_year', $this->selectedSchoolYear)
            ->whereBetween('date', [$startOfNextMonth, $endOfNextMonth])
            ->orderBy('date')
            ->get();
    }

    // Timeline logic
    public function getGroupedEventsProperty()
    {
        return Event::whereMonth('date', now()->month)
            ->where('school_year', $this->selectedSchoolYear)
            ->orderBy('date')
            ->get()
            ->groupBy(function ($event) {
                return Carbon::parse($event->date)->format('Y-m-d');
            });
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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $baseQuery = Event::query(); 

        $filteredQuery = (clone $baseQuery)
            ->when($this->selectedSchoolYear !== 'All' && $this->selectedSchoolYear !== null, function ($query) {
                $query->where('school_year', $this->selectedSchoolYear);
            })
            ->when($this->selectedMonth !== 'All' && $this->selectedMonth !== null, function ($query) {
                $monthNumber = Carbon::parse("1 {$this->selectedMonth}")->month;
                $query->whereMonth('date', $monthNumber);
            });

        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        $events = $filteredQuery
            ->orderByRaw("CASE WHEN status = ? THEN 1 ELSE 0 END", [EventStatus::Finished->value])
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();

        return view('livewire.management.manage-events', [
            'events' => $events,
            'eventCount' => $filteredEventCount
        ]);
    }
}
