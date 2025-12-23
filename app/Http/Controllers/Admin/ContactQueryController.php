<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use App\Models\QueryAssignment;
use App\Models\QueryResponse;
use App\Models\User;
use App\Jobs\UpdateTeamPerformanceMetrics;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    /**
     * Display a listing of contact queries.
     */
    public function index()
    {
        $queries = ContactQuery::with(['assignment.team', 'assignment.assignee', 'responses'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.contact-queries.index', compact('queries'));
    }

    /**
     * Display a single contact query.
     */
    public function show(ContactQuery $contactQuery)
    {
        $contactQuery->load(['assignment.team', 'assignment.assignee', 'responses.user']);
        $users = User::all(); // For assigning to users
        $statuses = ['pending', 'in_progress', 'resolved'];

        return view('admin.contact-queries.show', compact('contactQuery', 'users', 'statuses'));
    }

    /**
     * Update query status.
     */
    public function updateStatus(Request $request, ContactQuery $contactQuery)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved'
        ]);

        $contactQuery->update(['status' => $request->status]);

        // Update assignment if exists
        if ($contactQuery->assignment) {
            $contactQuery->assignment->update([
                'status' => $request->status,
                'resolved_at' => $request->status === 'resolved' ? now() : null
            ]);

            // Update team performance metrics
            UpdateTeamPerformanceMetrics::dispatch($contactQuery->assignment->team_id);
        }

        return back()->with('success', 'Status updated successfully.');
    }

    /**
     * Assign query to a team member.
     */
    public function assignToUser(Request $request, ContactQuery $contactQuery)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        if ($contactQuery->assignment) {
            $contactQuery->assignment->update([
                'assigned_to' => $request->user_id,
                'assigned_at' => now()
            ]);
        } else {
            // Create assignment if doesn't exist
            QueryAssignment::create([
                'contact_query_id' => $contactQuery->id,
                'team_id' => 1, // Default team, you can adjust
                'assigned_to' => $request->user_id,
                'status' => 'pending',
                'assigned_at' => now()
            ]);
        }

        return back()->with('success', 'Query assigned successfully.');
    }

    /**
     * Show form to record a response.
     */
    public function showResponseForm(ContactQuery $contactQuery)
    {
        $contactQuery->load(['assignment.team', 'responses.user']);
        $users = User::all();
        
        return view('admin.contact-queries.response', compact('contactQuery', 'users'));
    }

    /**
     * Record a response to a query.
     */
    public function recordResponse(Request $request, ContactQuery $contactQuery)
    {
        $request->validate([
            'type' => 'required|in:email,phone,message,internal_note',
            'content' => 'required|string|min:10',
            'customer_notified' => 'boolean',
            'update_status' => 'nullable|in:in_progress,resolved'
        ]);

        // Record the response
        QueryResponse::recordResponse(
            $contactQuery->id,
            auth()->id(), // Current logged in user
            $request->type,
            $request->content,
            $request->boolean('customer_notified')
        );

        // Update status if requested
        if ($request->update_status) {
            $contactQuery->update(['status' => $request->update_status]);
            
            if ($contactQuery->assignment) {
                $contactQuery->assignment->update([
                    'status' => $request->update_status,
                    'resolved_at' => $request->update_status === 'resolved' ? now() : null
                ]);

                // Update team performance metrics
                UpdateTeamPerformanceMetrics::dispatch($contactQuery->assignment->team_id);
            }
        }

        return redirect()
            ->route('admin.contact-queries.show', $contactQuery->id)
            ->with('success', 'Response recorded successfully.');
    }
}