<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Setting;
use App\Models\SchoolYear;

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
        return view('livewire.management.admin-dashboard');
    }
}
