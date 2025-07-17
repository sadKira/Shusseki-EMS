<?php

namespace App\Enums;

enum EventStatus: String
{
    case NotFinished = 'not_finished';
    case Finished = 'finished';
    case Postponed = 'postponed';
   

    public function label()
    {
        return match($this) {
            self::NotFinished => 'Upcoming',
            self::Finished => 'Finished',
            self::Postponed => 'Postponed',
        };
    }
}
