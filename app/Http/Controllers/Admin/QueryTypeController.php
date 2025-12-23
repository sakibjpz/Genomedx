<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QueryType;
use App\Models\QueryTeam;
use Illuminate\Http\Request;

class QueryTypeController extends Controller
{
    /**
     * Display a listing of query types.
     */
    public function index()
    {
        $queryTypes = QueryType::with('team')
            ->ordered()
            ->paginate(20);

        return view('admin.query-types.index', compact('queryTypes'));
    }

    /**
     * Show the form for creating a new query type.
     */
    public function create()
    {
        $teams = QueryTeam::where('is_active', true)->get();
        return view('admin.query-types.create', compact('teams'));
    }

    /**
     * Store a newly created query type.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:query_types',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'required|exists:query_teams,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        QueryType::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'team_id' => $request->team_id,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        return redirect()->route('admin.query-types.index')
            ->with('success', 'Query type created successfully.');
    }

    /**
     * Show the form for editing a query type.
     */
    public function edit(QueryType $queryType)
    {
        $teams = QueryTeam::where('is_active', true)->get();
        return view('admin.query-types.edit', compact('queryType', 'teams'));
    }

    /**
     * Update the specified query type.
     */
    public function update(Request $request, QueryType $queryType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:query_types,name,' . $queryType->id,
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'team_id' => 'required|exists:query_teams,id',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $queryType->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'team_id' => $request->team_id,
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $request->sort_order ?? $queryType->sort_order
        ]);

        return redirect()->route('admin.query-types.index')
            ->with('success', 'Query type updated successfully.');
    }

    /**
     * Remove the specified query type.
     */
    public function destroy(QueryType $queryType)
    {
        // Check if query type is used in any queries
        if ($queryType->queries()->count() > 0) {
            return back()->with('error', 'Cannot delete query type that is in use.');
        }

        $queryType->delete();

        return redirect()->route('admin.query-types.index')
            ->with('success', 'Query type deleted successfully.');
    }

    /**
     * Update sort order via AJAX.
     */
    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            QueryType::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}