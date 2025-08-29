<?php

namespace App\Livewire\Management;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use App\Models\Event;
use App\Models\Setting;
use App\Models\SchoolYear;
use Carbon\Carbon;
use App\Enums\EventStatus;

class ManageEvents extends Component
{
    use WithPagination;
    public $selectedSchoolYear = 'All';
    public $selectedMonth;


    // Mounting data
    public function mount()
    {
        // Get current month as a full capitalized string, e.g., "June"
        $this->selectedMonth = Carbon::now()->format('F');

        // Setting default school year
        $this->selectedSchoolYear = Setting::getSchoolYear();
    }


    // Timeline logic
    public function getGroupedEventsProperty()
    {
        $sy = $this->selectedSchoolYear;
        $ym = now()->format('Y-m');
        return Cache::remember("manage:lists:grouped_current_month:{$sy}:{$ym}", 120, function () use ($sy) {
            return Event::whereMonth('date', now()->month)
                ->where('school_year', $sy)
                ->orderBy('date')
                ->get()
                ->groupBy(function ($event) {
                    return Carbon::parse($event->date)->format('Y-m-d');
                });
        });
    }

    public function render()
    {
        $baseQuery = Event::query(); 

        $filteredQuery = (clone $baseQuery)
            ->where('school_year', $this->selectedSchoolYear)
            ->whereMonth('date', Carbon::parse("1 {$this->selectedMonth}")->month)
            ->whereYear('date', now()->year);

            // ->when($this->selectedMonth !== 'All' && $this->selectedMonth !== null, function ($query) {
            //     $monthNumber = Carbon::parse("1 {$this->selectedMonth}")->month;
            //     $query->whereMonth('date', $monthNumber);
            // });

        // Count of filtered events
        $filteredEventCount = (clone $filteredQuery)->count();

        // Order of events (cached per SY + month/year)
        $sy = $this->selectedSchoolYear;
        $monthNum = Carbon::parse("1 {$this->selectedMonth}")->month;
        $yearNow = now()->year;
        $events = Cache::remember("manage:lists:month_events:{$sy}:{$yearNow}-{$monthNum}", 120, function () use ($filteredQuery) {
            return $filteredQuery
                ->orderByRaw("
                CASE 
                    WHEN status = ? THEN 2
                    WHEN status = ? THEN 1
                    ELSE 0
                END", [EventStatus::Postponed->value, EventStatus::Finished->value])
                ->orderBy('date', $this->sortDirection ?? 'asc')
                ->get();
        });

        // event count
        $now = now();

        // Count of events for the month where status is not postponed (cached)
        $nonPostponedEventCount = Cache::remember("manage:counts:non_postponed_month:{$sy}:{$yearNow}-{$monthNum}", 600, function () use ($sy, $monthNum, $yearNow) {
            return Event::where('school_year', $sy)
                ->whereMonth('date', $monthNum)
                ->whereYear('date', $yearNow)
                ->where('status', '!=', EventStatus::Postponed->value)
                ->count();
        });
        
        // Count of postponed events for the month (cached)
        $postponedEventCount = Cache::remember("manage:counts:postponed_month:{$sy}:{$yearNow}-{$monthNum}", 600, function () use ($sy, $monthNum, $yearNow) {
            return Event::where('school_year', $sy)
                ->whereMonth('date', $monthNum)
                ->whereYear('date', $yearNow)
                ->where('status', EventStatus::Postponed->value)
                ->count();
        });

        // Untracked count for the month (cached)
        $untrackedCount = Cache::remember("manage:counts:untracked_month:{$sy}:{$yearNow}-{$monthNum}", 600, function () use ($sy, $monthNum, $yearNow, $now) {
            return Event::where('school_year', $sy)
                ->where('status', EventStatus::NotFinished->value)
                ->whereMonth('date', $monthNum)
                ->whereYear('date', $yearNow)
                ->where(function ($query) use ($now) {
                    $query->whereDate('date', '<', $now->toDateString())
                        ->orWhere(function ($q) use ($now) {
                            $q->whereDate('date', $now->toDateString())
                                ->whereTime('end_time', '<', $now->toTimeString());
                        });
                })
                ->count();
        });

        

        return view('livewire.management.manage-events', [
            'events' => $events,
            'eventCount' => $filteredEventCount,
            'groupedEvents' => $this->groupedEvents,
            'nonPostponedEventCount' => $nonPostponedEventCount,
            'postponedEventCount' => $postponedEventCount,
            'untrackedCount' => $untrackedCount,
            
           
        ]);
    }
}
