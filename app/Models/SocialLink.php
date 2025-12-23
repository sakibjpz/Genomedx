<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    // Add the fields you allow for mass assignment
    protected $fillable = [
        'icon',
        'url',
          'platform',
    ];
}
