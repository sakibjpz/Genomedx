<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QueryTeam;
use App\Models\ContactQuery;
use App\Models\TeamPerformanceMetric;
use Illuminate\Http\Request;

class TeamPerformanceController extends Controller
{
    /**
     * Display team performance dashboard.
     */
    public function index(Request $request)
    {
        // Date range
        $startDate = $request->input('start_date', now()->subDays(7)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // Get all teams
        $teams = QueryTeam::where('is_active', true)->get();

        // Get team performance metrics
        $teamPerformance = TeamPerformanceMetric::getTeamPerformance($startDate, $endDate);

        // Get team-wise queries
        $teamQueries = [];
        $totalQueries = 0;
        $pendingQueries = 0;
        $resolvedQueries = 0;

        foreach ($teams as $team) {
            $teamQuery = ContactQuery::whereHas('assignment', function($q) use ($team) {
                $q->where('team_id', $team->id);
            })->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

            $teamTotal = $teamQuery->count();
            $teamPending = $teamQuery->clone()->where('status', 'pending')->count();
            $teamResolved = $teamQuery->clone()->where('status', 'resolved')->count();
            $teamInProgress = $teamQuery->clone()->where('status', 'in_progress')->count();

            $teamQueries[$team->id] = [
                'total' => $teamTotal,
                'pending' => $teamPending,
                'resolved' => $teamResolved,
                'in_progress' => $teamInProgress,
                'resolution_rate' => $teamTotal > 0 ? round(($teamResolved / $teamTotal) * 100) : 0
            ];

            $totalQueries += $teamTotal;
            $pendingQueries += $teamPending;
            $resolvedQueries += $teamResolved;
        }

        // Get recent queries for activity feed
        $recentQueries = ContactQuery::with(['assignment.team'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.team-performance.index', compact(
            'teams',
            'teamPerformance',
            'teamQueries',
            'totalQueries',
            'pendingQueries',
            'resolvedQueries',
            'recentQueries',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Update team metrics manually (for testing).
     */
    public function updateMetrics()
    {
        $teams = QueryTeam::where('is_active', true)->get();
        
        foreach ($teams as $team) {
            TeamPerformanceMetric::updateTeamMetrics($team->id);
        }

        return back()->with('success', 'Team performance metrics updated successfully.');
    }
}