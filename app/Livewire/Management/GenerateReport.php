<?php

namespace App\Livewire\Management;

use Livewire\Component;
use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use Carbon\Carbon;
use App\Enums\EventStatus;

use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReport extends Component
{

    public $selectedSchoolYear;
    public $selectedMonth;

    // Mounting data
    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }

    public function render()
    {
        return view('livewire.management.generate-report');
    }
}
