<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $fillable = [

        'key',
        'value'
    ];

    public static function getAvailableSchoolYears()
    {
        return SchoolYear::orderByDesc('year')->pluck('year')->toArray();
    }

    public static function getSchoolYear()
    {
        return static::where('key', 'current_school_year')->value('value');
    }

    public static function setSchoolYear($year)
    {
        return static::updateOrCreate(
            ['key' => 'current_school_year'],
            ['value' => $year]
        );
    }
}
