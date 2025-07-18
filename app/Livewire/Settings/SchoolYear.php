<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\Setting;
use App\Models\SchoolYear as modelSchoolYear;

use Carbon\Carbon;
use Flux\Flux;

class SchoolYear extends Component
{

    public $selectedSchoolYear;

    public $selectedMonth;

    public $newSchoolYear = '';
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

    // Add school year
    public function addSchoolYear()
    {
        $this->validate([
            'newSchoolYear' => 'required|regex:/^\d{4}-\d{4}$/|unique:school_years,year',
        ]);

        modelSchoolYear::create(['year' => $this->newSchoolYear]);

        $this->newSchoolYear = '';
        $this->schoolYears = Setting::getAvailableSchoolYears();

        // Closes all modals
        // Flux::modals()->close();

    }

    public function render()
    {
        return view('livewire.settings.school-year');
    }
}
