<?php

namespace App\Enums;

enum UserRole: String
{
    case User = 'user';
    case Admin = 'admin';
    case Super_Admin = 'super_admin';
    case Tsuushin = 'tsuushin';

}

