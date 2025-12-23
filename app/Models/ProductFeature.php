<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeature extends Model
{
    protected $fillable = [
    'product_id',
    'title',
    'description',
    'icon',
    'color',
    'sort_order',
    'is_active',
    'download_label', // This should already be there
    'download_link',  // ← ADD THIS LINE
];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'formatted_description',
    ];

    /**
     * Get the product that owns the feature.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Scope active features
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get formatted description with bullet points
     */
    public function getFormattedDescriptionAttribute()
    {
        if (!$this->description) {
            return '';
        }

        // Convert line breaks to list items like GeneProof
        $lines = explode("\n", $this->description);
        $formatted = '';
        
        foreach ($lines as $line) {
            if (trim($line)) {
                $formatted .= '• ' . trim($line) . "\n";
            }
        }
        
        return trim($formatted);
    }
}