<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'category',
        'published_date',
        'is_published',
        'views',
        'sort_order'
    ];

    protected $casts = [
        'published_date' => 'date',
        'is_published' => 'boolean'
    ];

    // Automatically generate slug from title
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
        
        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    // Scope for published news
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->orderBy('published_date', 'desc')
                     ->orderBy('sort_order');
    }

    // Scope for latest news (limit)
    public function scopeLatestNews($query, $limit = 3)
    {
        return $query->published()->limit($limit);
    }

    // Get category color
    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'event' => 'bg-blue-500',
            'update' => 'bg-green-500',
            'achievement' => 'bg-purple-500',
            default => 'bg-red-500', // news
        };
    }

    // Get category label
    public function getCategoryLabelAttribute()
    {
        return match($this->category) {
            'event' => 'Event',
            'update' => 'Update',
            'achievement' => 'Achievement',
            default => 'News',
        };
    }
}