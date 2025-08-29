<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{

    protected $fillable = [

        'key',
        'value'
    ];

    public static function getAvailableSchoolYears()
    {
        return Cache::remember('school_years:list', 86400, function () {
            return SchoolYear::orderByDesc('year')->pluck('year')->toArray();
        });

        // return SchoolYear::orderByDesc('year')->pluck('year')->toArray();
        
    }

    // Obtain school year
    public static function getSchoolYear()
    {
        return Cache::rememberForever('settings:current_school_year', function () {
            return static::where('key', 'current_school_year')->value('value');
        });

        // return static::where('key', 'current_school_year')->value('value');
    }

    // Set school year
    public static function setSchoolYear($year)
    {
        $result = static::updateOrCreate(['key' => 'current_school_year'], ['value' => $year]);
        Cache::forget('settings:current_school_year');
        Cache::forget('school_years:list'); // optional if you show “current year” in that list

        return $result;

        // return static::updateOrCreate(
        //     ['key' => 'current_school_year'],
        //     ['value' => $year]
        // );
    }

    // Obtain admin key
    public static function getAdminKey()
    {
        return static::where('key', 's_a_k');
    }

}
