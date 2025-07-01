<?php

namespace App\Enums;

enum AttendanceStatus: String
{
    case Present = 'present';
    case Absent = 'absent';
    case Late = 'late';
    case Scanned = 'scanned';
    case NotScanned = 'not_scanned';


    public function label()
    {
        return match($this) {
            self::Present => 'Present',
            self::Absent => 'Absent',
            self::Late => 'Late',
            self::Scanned => 'Scanned',
            self::NotScanned => 'Not Scanned',
        };
    }
}
