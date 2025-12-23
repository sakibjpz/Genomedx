<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProductDetail extends Model
{
    protected $fillable = [
        'product_id',
        'description',
        'specifications',
        'order_table',
        'brochure',
        'image',
        'second_image',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'specifications' => 'array',
        'order_table' => 'array',
    ];

    // Detail belongs to a product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Access product's documents through product
    public function documents()
    {
        return $this->hasManyThrough(
            ProductDocument::class,
            Product::class,
            'id', // Foreign key on products table
            'product_id', // Foreign key on documents table
            'product_id', // Local key on product_details table
            'id' // Local key on products table
        );
    }

    // Access product's features through product
    public function features()
    {
        return $this->hasManyThrough(
            ProductFeature::class,
            Product::class,
            'id', // Foreign key on products table
            'product_id', // Foreign key on features table
            'product_id', // Local key on product_details table
            'id' // Local key on products table
        );
    }

    /**
     * Get description safely
     */
    public function getDescriptionAttribute($value): string
    {
        return $value ?: '';
    }

    /**
     * Get specifications safely
     */
   public function getSpecificationsAttribute($value): array
{
    // If it's already an array (due to casting), return it
    if (is_array($value)) {
        return $value;
    }
    
    // If it's a string, try to decode it
    if (is_string($value)) {
        $decoded = json_decode($value, true);
        
        // If decoding failed OR result is not an array, return empty array
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return [];
        }
        
        return $decoded;
    }
    
    // Default empty array
    return [];
}
}