<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueryResponse extends Model
{
    protected $fillable = [
        'contact_query_id',
        'user_id',
        'type',
        'content',
        'customer_notified',
        'responded_at'
    ];

    protected $casts = [
        'customer_notified' => 'boolean',
        'responded_at' => 'datetime'
    ];

    public function contactQuery()
    {
        return $this->belongsTo(ContactQuery::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->hasOneThrough(
            QueryTeam::class,
            QueryAssignment::class,
            'contact_query_id',
            'id',
            'contact_query_id',
            'team_id'
        );
    }

    /**
     * Record a response to a query
     */
    public static function recordResponse($contactQueryId, $userId, $type, $content, $notifyCustomer = true)
    {
        return self::create([
            'contact_query_id' => $contactQueryId,
            'user_id' => $userId,
            'type' => $type,
            'content' => $content,
            'customer_notified' => $notifyCustomer,
            'responded_at' => now()
        ]);
    }

    /**
     * Get response time for a query (first response)
     */
    public static function getResponseTime($contactQueryId)
    {
        $firstResponse = self::where('contact_query_id', $contactQueryId)
            ->orderBy('responded_at', 'asc')
            ->first();
        
        if (!$firstResponse) {
            return null;
        }

        $query = ContactQuery::find($contactQueryId);
        if (!$query) {
            return null;
        }

        return $query->created_at->diffInHours($firstResponse->responded_at);
    }
}