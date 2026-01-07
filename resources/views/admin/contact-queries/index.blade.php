@extends('admin.layouts.app')

@section('title', 'Contact Queries')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Contact Queries</h1>
        <div class="text-sm text-gray-600">
            Total: {{ $queries->total() }} queries
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto" style="max-height: 600px; overflow-y: auto;">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 sticky top-0 z-10">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 70px;">ID</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">Name</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 150px;">Email</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">Query Type</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">Attachment</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 120px;">Team</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 100px;">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 100px;">Date</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="min-width: 80px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($queries as $query)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 text-sm font-medium text-gray-900">#{{ $query->id }}</td>
                        <td class="px-3 py-2 text-sm text-gray-900">{{ $query->name }}</td>
                        <td class="px-3 py-2 text-sm text-gray-600">{{ $query->email }}</td>
                        <td class="px-3 py-2 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 inline-block">
                                {{ $query->query_type }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-sm">
                            @if($query->attachment_path)
                                <a href="{{ asset('storage/' . $query->attachment_path) }}" 
                                   target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 text-xs inline-flex items-center">
                                    <i class="fas fa-paperclip mr-1"></i>
                                    {{ Str::limit($query->attachment_name ?? 'File', 15) }}
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-sm">
                            @if($query->assignment && $query->assignment->team)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full inline-block
                                    {{ $query->assignment->team->name == 'Sales' ? 'bg-green-100 text-green-800' : 
                                       ($query->assignment->team->name == 'Technical Support' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-gray-100 text-gray-800') }}">
                                    {{ Str::limit($query->assignment->team->name, 15) }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">Not assigned</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-sm">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full inline-block
                                {{ $query->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($query->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-green-100 text-green-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $query->status)) }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-sm text-gray-500">
                            {{ $query->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-3 py-2 text-sm font-medium">
                            <a href="{{ route('admin.contact-queries.show', $query->id) }}" 
                               class="text-blue-600 hover:text-blue-900 text-xs">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @foreach($queries as $query)
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900">{{ $query->name }}</h3>
                    <p class="text-sm text-gray-600 mt-1 break-all">{{ $query->email }}</p>
                </div>
                <span class="text-xs font-medium text-gray-500 ml-2 flex-shrink-0">#{{ $query->id }}</span>
            </div>

            <div class="space-y-2 mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Query Type:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $query->query_type }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Status:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $query->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($query->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                           'bg-green-100 text-green-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $query->status)) }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Team:</span>
                    @if($query->assignment && $query->assignment->team)
                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                            {{ $query->assignment->team->name == 'Sales' ? 'bg-green-100 text-green-800' : 
                               ($query->assignment->team->name == 'Technical Support' ? 'bg-yellow-100 text-yellow-800' : 
                               'bg-gray-100 text-gray-800') }}">
                            {{ $query->assignment->team->name }}
                        </span>
                    @else
                        <span class="text-gray-400 text-xs">Not assigned</span>
                    @endif
                </div>

                @if($query->attachment_path)
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Attachment:</span>
                    <a href="{{ asset('storage/' . $query->attachment_path) }}" 
                       target="_blank" 
                       class="text-blue-600 hover:text-blue-800 text-xs inline-flex items-center">
                        <i class="fas fa-paperclip mr-1"></i>
                        {{ Str::limit($query->attachment_name ?? 'File', 20) }}
                    </a>
                </div>
                @endif

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Date:</span>
                    <span class="text-xs text-gray-500">{{ $query->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="pt-3 border-t border-gray-200">
                <a href="{{ route('admin.contact-queries.show', $query->id) }}" 
                   class="block w-full text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                    View Details
                </a>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $queries->links() }}
    </div>
</div>

<style>
    /* Custom scrollbar */
    .overflow-x-auto::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 5px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 5px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Sticky header */
    .sticky {
        position: -webkit-sticky;
        position: sticky;
    }

    /* Mobile specific styles */
    @media (max-width: 767px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        h1 {
            font-size: 1.5rem;
        }
    }
</style>
@endsection