<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    protected $fillable = [
        'query_type',
        'name',
        'email',
        'phone',
        'company',
        'profile',
        'country',
        'message',
        'status',
        'attachment_path', 
    'attachment_name'
    ];

    protected $appends = ['response_time', 'resolution_time'];

    public function assignment()
    {
        return $this->hasOne(QueryAssignment::class);
    }

    public function team()
    {
        return $this->hasOneThrough(
            QueryTeam::class,
            QueryAssignment::class,
            'contact_query_id',
            'id',
            'id',
            'team_id'
        );
    }

    public function responses()
    {
        return $this->hasMany(QueryResponse::class);
    }

    public function firstResponse()
    {
        return $this->hasOne(QueryResponse::class)->oldestOfMany('responded_at');
    }

    public function lastResponse()
    {
        return $this->hasOne(QueryResponse::class)->latestOfMany('responded_at');
    }

    public function getResponseTimeAttribute()
    {
        if ($this->firstResponse) {
            return $this->created_at->diffInHours($this->firstResponse->responded_at);
        }
        return null;
    }

    public function getResolutionTimeAttribute()
    {
        if ($this->status === 'resolved' && $this->assignment && $this->assignment->resolved_at) {
            return $this->created_at->diffInHours($this->assignment->resolved_at);
        }
        return null;
    }

    public function hasBeenRespondedTo()
    {
        return $this->responses()->exists();
    }
}