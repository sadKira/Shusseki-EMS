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

    // Obtain school year
    public static function getSchoolYear()
    {
        return static::where('key', 'current_school_year')->value('value');
    }

    // Set school year
    public static function setSchoolYear($year)
    {
        return static::updateOrCreate(
            ['key' => 'current_school_year'],
            ['value' => $year]
        );
    }

    // Obtain admin key
    public static function getAdminKey()
    {
        return static::where('key', 's_a_k');
    }

}
