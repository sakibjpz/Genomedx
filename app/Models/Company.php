<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug', 
        'is_active',
        'sort_order',
        'image'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class);
    }

    public function activeProductGroups()
    {
        return $this->hasMany(ProductGroup::class)->where('status', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}