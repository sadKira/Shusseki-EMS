<?php

namespace App\Enums;

enum UserApproval: String
{
    case Pending = 'pending';
    case Approved = 'approved';
}
