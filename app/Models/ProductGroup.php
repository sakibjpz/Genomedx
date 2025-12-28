<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
   protected $fillable = [
    'name',
    'slug',
    'company_id', // ADD THIS LINE
    'color',
    'icon',
    'position',
    'status',
];

    // A group has many products
   public function products()
{
    return $this->hasMany(Product::class)
                ->orderBy('position');
}

// ADD THIS METHOD:
public function productsCount()
{
    return $this->products()->count();
}

    public function company()
{
    return $this->belongsTo(Company::class);
}

    // Helper method to get HEX value of Tailwind color
    public function colorHex()
    {
        return match($this->color) {
            'red-500' => '#ef4444',
            'green-500' => '#22c55e',
            'blue-500' => '#3b82f6',
            'orange-500' => '#f97316',
            'purple-600' => '#9333ea',
            'cyan-500' => '#06b6d4',
            'lime-500' => '#84cc16',
            'amber-700' => '#b45309',
            'gray-400' => '#9ca3af',
            default => '#000000',
        };
    }
}
