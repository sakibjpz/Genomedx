<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    // Allow mass assignment on all required columns
    protected $fillable = [
        'name',
        'country',
        'code',
        'image',
        'icon',
    ];
}
