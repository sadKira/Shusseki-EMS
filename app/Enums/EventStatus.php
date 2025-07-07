<?php

namespace App\Enums;

enum EventStatus: String
{
    case NotFinished = 'not_finished';
    case Finished = 'finished';

    public function label()
    {
        return match($this) {
            self::NotFinished => 'Upcoming',
            self::Finished => 'Finished',
        };
    }
}
