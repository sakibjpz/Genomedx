<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryTeam extends Model
{
    protected $fillable = ['name', 'email', 'query_types', 'is_active'];
    
    protected $casts = [
        'query_types' => 'array',
        'is_active' => 'boolean'
    ];

    public function assignments()
    {
        return $this->hasMany(QueryAssignment::class, 'team_id');
    }
}