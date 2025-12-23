<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\ProductDocument; // Add this
use App\Models\ProductFeature; // Add this

class Product extends Model
{
    protected $fillable = [
        'product_group_id',
        'name',
        'slug',
        'short_description',
        'image',
        'position',
        'status',
        'badge',
        'certifications',
    ];

    // Product belongs to a group
    public function productGroup(): BelongsTo
    {
        return $this->belongsTo(ProductGroup::class, 'product_group_id');
    }

    // Product has one detail page
    public function details(): HasOne
    {
        return $this->hasOne(ProductDetail::class, 'product_id');
    }

    // Product has many documents (PDFs)
    public function documents(): HasMany
    {
        return $this->hasMany(ProductDocument::class, 'product_id');
    }

    // Product has many features (advantages)
    public function features(): HasMany
    {
        return $this->hasMany(ProductFeature::class, 'product_id');
    }

    // Product has many related products
    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_related',
            'product_id',
            'related_product_id'
        )
        ->withPivot('sort_order')
        ->orderByPivot('sort_order');
    }
}