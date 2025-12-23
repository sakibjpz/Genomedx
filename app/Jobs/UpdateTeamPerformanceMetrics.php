<?php

namespace App\Jobs;

use App\Models\QueryTeam;
use App\Models\TeamPerformanceMetric;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateTeamPerformanceMetrics implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $teams = QueryTeam::where('is_active', true)->get();
        
        foreach ($teams as $team) {
            TeamPerformanceMetric::updateTeamMetrics($team->id);
        }
        
        \Log::info('Team performance metrics updated for ' . $teams->count() . ' teams');
    }
}