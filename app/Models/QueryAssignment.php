<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryAssignment extends Model
{
    protected $fillable = [
        'contact_query_id', 
        'team_id', 
        'assigned_to', 
        'status', 
        'notes',
        'assigned_at',
        'resolved_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'resolved_at' => 'datetime'
    ];

public function contactQuery()
    {
        return $this->belongsTo(ContactQuery::class, 'contact_query_id');
    }

    public function team()
    {
        return $this->belongsTo(QueryTeam::class, 'team_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}