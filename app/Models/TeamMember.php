<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'regions',
        'email',
        'phone',
        'image',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Get active team members ordered by position
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order');
    }
}