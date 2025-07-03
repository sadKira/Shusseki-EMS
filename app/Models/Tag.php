<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\Tags;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [

        'tag',

    ];

    protected $casts = [
        'tag' => Tags::class,
    ];

    public function events()
    {
        return $this->belongsToMany(Event::class);
    }


}
