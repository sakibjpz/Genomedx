<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use App\Models\QueryTeam;
use App\Models\QueryType;
use App\Models\QueryAssignment;
use App\Notifications\NewContactQueryNotification;
use App\Jobs\UpdateTeamPerformanceMetrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function create()
    {
        // Get social links - check your actual table structure
        $socialLinks = \App\Models\SocialLink::all();
        // Get flags
        $flags = \App\Models\Flag::all();
        // Get menus
        $menus = \App\Models\Menu::all();
        // Get active query types from database
        $queryTypes = QueryType::active()->ordered()->get();
        
        return view('front.contact', compact('socialLinks', 'flags', 'menus', 'queryTypes'));
    }

    /**
     * Store a new contact query.
     */
    public function store(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'query_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'required|string|max:255',
            'profile' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Save to database
        $contactQuery = ContactQuery::create($validated);

        // 1. Find the right team for this query type
        $team = $this->findTeamForQuery($contactQuery->query_type);
        
        if ($team) {
            // 2. Create assignment
            $assignment = QueryAssignment::create([
                'contact_query_id' => $contactQuery->id,
                'team_id' => $team->id,
                'status' => 'pending',
                'assigned_at' => now()
            ]);

            // 3. Send notification to team email
            try {
                Notification::route('mail', $team->email)
                    ->notify(new NewContactQueryNotification($contactQuery));
            } catch (\Exception $e) {
                \Log::error('Failed to send notification: ' . $e->getMessage());
            }

            // 4. Update team performance metrics
            UpdateTeamPerformanceMetrics::dispatch($team->id);
        }

        return back()->with('success', 'Your message has been sent successfully! We will contact you soon.');
    }

    /**
     * Find the appropriate team for a query type
     */
    private function findTeamForQuery($queryTypeName)
    {
        // Find query type in database
        $queryType = QueryType::where('name', $queryTypeName)->first();
        
        // If query type exists and has a team, return the team
        if ($queryType && $queryType->team) {
            return $queryType->team;
        }
        
        // If query type doesn't exist in database (shouldn't happen with proper admin setup)
        // Log error and assign to default team
        \Log::warning("Query type '{$queryTypeName}' not found in database. Assigning to default team.");
        
        $defaultTeam = QueryTeam::where('name', 'General Support')->first();
        
        // Create the missing query type for future
        if ($defaultTeam && !$queryType) {
            QueryType::create([
                'name' => $queryTypeName,
                'display_name' => $queryTypeName,
                'team_id' => $defaultTeam->id,
                'is_active' => false, // Mark as inactive so admin can review
                'sort_order' => 999
            ]);
        }
        
        return $defaultTeam;
    }
}