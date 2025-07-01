<?php

namespace App\Enums;

enum AccountStatus: String
{
    case Active = 'active';
    case Inactive = 'inactive';

    public function label()
    {
        return match($this) {
            self::Active => 'Active',
            self::Inactive => 'Inactive',
        };
    }
}
