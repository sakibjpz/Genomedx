<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $fillable = [
        'name',
        'parent_id',
        'order',
        'status',
    ];

    // children (for dropdown menu)
    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id')->orderBy('order');
    }

    // parent (for nested structure)
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    // active only
    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('order');
    }
}
