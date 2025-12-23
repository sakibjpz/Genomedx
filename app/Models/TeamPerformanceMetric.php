<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPerformanceMetric extends Model
{
    protected $fillable = [
        'team_id',
        'metric_date',
        'total_queries',
        'pending_queries',
        'in_progress_queries',
        'resolved_queries',
        'avg_response_hours',
        'avg_resolution_hours'
    ];

    protected $casts = [
        'metric_date' => 'date'
    ];

    public function team()
    {
        return $this->belongsTo(QueryTeam::class);
    }

    /**
     * Calculate and update today's metrics for a team
     */
    public static function updateTeamMetrics($teamId)
    {
        $today = now()->toDateString();
        
        // Get today's queries for this team
        $queries = ContactQuery::whereHas('assignment', function($q) use ($teamId) {
            $q->where('team_id', $teamId);
        })->whereDate('created_at', $today)->get();

        // Calculate metrics
        $total = $queries->count();
        $pending = $queries->where('status', 'pending')->count();
        $inProgress = $queries->where('status', 'in_progress')->count();
        $resolved = $queries->where('status', 'resolved')->count();

        // Update or create today's metrics
        return self::updateOrCreate(
            [
                'team_id' => $teamId,
                'metric_date' => $today
            ],
            [
                'total_queries' => $total,
                'pending_queries' => $pending,
                'in_progress_queries' => $inProgress,
                'resolved_queries' => $resolved
            ]
        );
    }

    /**
     * Get performance metrics for all teams for a date range
     */
    public static function getTeamPerformance($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? now()->subDays(7)->toDateString();
        $endDate = $endDate ?? now()->toDateString();

        return self::with('team')
            ->whereBetween('metric_date', [$startDate, $endDate])
            ->orderBy('metric_date', 'desc')
            ->get()
            ->groupBy('team_id');
    }
}