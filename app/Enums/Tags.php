<?php

namespace App\Enums;

enum Tags: String
{
    case Required = 'required';

    case NotRequired = 'not_required';

    public function label()
    {
        return match($this) {
            self::Required => 'Required',
            self::NotRequired => 'Not Required',
        };
    }
}
