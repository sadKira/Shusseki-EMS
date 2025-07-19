<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Setting;
use App\Models\SchoolYear;
use App\Models\Event;
use App\Enums\EventStatus;

use Carbon\Carbon;

class AdminDashboard extends Component
{

    public $selectedSchoolYear = 'All';

    public $selectedMonth;

    public $schoolYears = [];

    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
        $this->schoolYears = Setting::getAvailableSchoolYears(); // loads from SchoolYear model

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
            ->orderByRaw("
                CASE 
                    WHEN status = ? THEN 2
                    WHEN status = ? THEN 1
                    ELSE 0
                END", [EventStatus::Postponed->value, EventStatus::Finished->value])
            ->orderBy('date', $this->sortDirection ?? 'asc')
            ->get();

        return view('livewire.management.admin-dashboard', [
            'events' => $events,
            'eventCount' => $filteredEventCount
        ]);
    }
}
