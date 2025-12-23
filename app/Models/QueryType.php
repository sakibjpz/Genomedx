<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryType extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'team_id',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function team()
    {
        return $this->belongsTo(QueryTeam::class);
    }

    public function queries()
    {
        return $this->hasMany(ContactQuery::class, 'query_type', 'name');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('display_name');
    }
}