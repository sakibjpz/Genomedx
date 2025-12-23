@extends('admin.layouts.app')

@section('title', 'Team Performance Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Team Performance Dashboard</h1>
        <div class="text-sm text-gray-600">
            Last updated: {{ now()->format('M d, Y H:i') }}
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="flex items-center space-x-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" name="start_date" value="{{ request('start_date', now()->subDays(7)->format('Y-m-d')) }}"
                       class="border border-gray-300 rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">To Date</label>
                <input type="date" name="end_date" value="{{ request('end_date', now()->format('Y-m-d')) }}"
                       class="border border-gray-300 rounded px-3 py-2">
            </div>
            <div class="pt-5">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filter
                </button>
                <a href="{{ route('admin.team-performance.index') }}" 
                   class="ml-2 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Performance Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Queries Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-envelope text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Queries</p>
                    <p class="text-2xl font-bold">{{ $totalQueries }}</p>
                </div>
            </div>
        </div>

        <!-- Pending Queries Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Pending Queries</p>
                    <p class="text-2xl font-bold">{{ $pendingQueries }}</p>
                </div>
            </div>
        </div>

        <!-- Resolved Rate Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Resolution Rate</p>
                    <p class="text-2xl font-bold">{{ $totalQueries > 0 ? round(($resolvedQueries / $totalQueries) * 100) : 0 }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Performance Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Team Performance</h2>
            <p class="text-sm text-gray-600">Performance metrics for each team</p>
        </div>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Queries</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pending</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">In Progress</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolved</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolution Rate</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Avg Response</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
    @foreach($teams as $team)
    @php
        $teamStats = $teamQueries[$team->id] ?? [
            'total' => 0,
            'pending' => 0,
            'in_progress' => 0,
            'resolved' => 0,
            'resolution_rate' => 0
        ];
    @endphp
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full 
                    {{ $team->name == 'Sales' ? 'bg-green-100' : 
                       ($team->name == 'Technical Support' ? 'bg-yellow-100' : 
                       'bg-blue-100') }} 
                    flex items-center justify-center">
                    <i class="fas 
                        {{ $team->name == 'Sales' ? 'fa-dollar-sign text-green-600' : 
                           ($team->name == 'Technical Support' ? 'fa-tools text-yellow-600' : 
                           'fa-headset text-blue-600') }}"></i>
                </div>
                <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ $team->name }}</div>
                    <div class="text-sm text-gray-500">{{ $team->email }}</div>
                </div>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-lg font-semibold">{{ $teamStats['total'] }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                {{ $teamStats['pending'] }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                {{ $teamStats['in_progress'] }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                {{ $teamStats['resolved'] }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="w-24 bg-gray-200 rounded-full h-2 mr-3">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $teamStats['resolution_rate'] }}%"></div>
                </div>
                <span class="text-sm font-medium">{{ $teamStats['resolution_rate'] }}%</span>
            </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
            <a href="{{ route('admin.contact-queries.index') }}?team={{ $team->id }}" 
               class="text-blue-600 hover:text-blue-900">
                View Queries →
            </a>
        </td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Recent Activity</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recentQueries as $query)
                <div class="flex items-start border-b pb-4 last:border-0 last:pb-0">
                    <div class="flex-shrink-0">
                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-user text-gray-500"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium text-gray-900">{{ $query->name }}</p>
                            <span class="text-xs text-gray-500">{{ $query->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm text-gray-600">{{ $query->query_type }}</p>
                        <p class="text-xs text-gray-500 mt-1">Assigned to 
                            <span class="font-medium">
                                {{ $query->assignment && $query->assignment->team ? $query->assignment->team->name : 'No team' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $query->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($query->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                               'bg-green-100 text-green-800') }}">
                            {{ ucfirst($query->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection