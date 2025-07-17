<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Carbon\Carbon;
// use App\Enums\EventStatus;

class MarkUntrackedEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:mark-untracked';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark past events as untracked if not already finished or postponed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $now = Carbon::now('Asia/Manila');

        // $updated = Event::where('status', '!=', EventStatus::Finished)
        //     ->where('status', '!=', EventStatus::Postponed)
        //     ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') < ?", [$now])
        //     ->update(['status' => EventStatus::Untracked]);

        // $this->info("Updated {$updated} event(s) as untracked.");
    }
}
