<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = [

        'year'
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'school_year', 'year');
    }
    
}
