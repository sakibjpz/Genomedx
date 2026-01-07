@extends('admin.layouts.app')

@section('title', 'Query Types Management')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Query Types Management</h1>
        <a href="{{ route('admin.query-types.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-center text-sm sm:text-base">
            <i class="fas fa-plus mr-2"></i>Add Query Type
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sort</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Query Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Team</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usage</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable">
                    @foreach($queryTypes as $queryType)
                    <tr data-id="{{ $queryType->id }}" class="hover:bg-gray-50 cursor-move">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <i class="fas fa-grip-vertical text-gray-400"></i>
                            <span class="text-sm text-gray-500 ml-2">{{ $queryType->sort_order }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $queryType->display_name }}</div>
                            <div class="text-sm text-gray-500">{{ $queryType->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $queryType->team->name == 'Sales' ? 'bg-green-100 text-green-800' : 
                                   ($queryType->team->name == 'Technical Support' ? 'bg-yellow-100 text-yellow-800' : 
                                   'bg-blue-100 text-blue-800') }}">
                                {{ $queryType->team->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-700 max-w-xs truncate">{{ $queryType->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $queryType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $queryType->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $queryType->queries->count() }} queries
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.query-types.edit', $queryType->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.query-types.destroy', $queryType->id) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Delete this query type?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4" id="sortable-mobile">
        @foreach($queryTypes as $queryType)
        <div data-id="{{ $queryType->id }}" class="bg-white rounded-lg shadow p-4">
            <!-- Drag Handle & Sort Order -->
            <div class="flex items-center justify-between mb-3 pb-3 border-b">
                <div class="flex items-center">
                    <i class="fas fa-grip-vertical text-gray-400 text-lg mr-3 cursor-move"></i>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">{{ $queryType->display_name }}</h3>
                        <p class="text-xs text-gray-500">{{ $queryType->name }}</p>
                    </div>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">#{{ $queryType->sort_order }}</span>
            </div>

            <!-- Info Grid -->
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Team:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $queryType->team->name == 'Sales' ? 'bg-green-100 text-green-800' : 
                           ($queryType->team->name == 'Technical Support' ? 'bg-yellow-100 text-yellow-800' : 
                           'bg-blue-100 text-blue-800') }}">
                        {{ $queryType->team->name }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Status:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $queryType->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $queryType->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Usage:</span>
                    <span class="text-xs text-gray-900 font-medium">{{ $queryType->queries->count() }} queries</span>
                </div>

                @if($queryType->description)
                <div class="pt-2 border-t">
                    <p class="text-xs text-gray-600 font-medium mb-1">Description:</p>
                    <p class="text-sm text-gray-700">{{ $queryType->description }}</p>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-3 border-t">
                <a href="{{ route('admin.query-types.edit', $queryType->id) }}" 
                   class="flex-1 text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.query-types.destroy', $queryType->id) }}" 
                      method="POST" class="flex-1" 
                      onsubmit="return confirm('Delete this query type?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $queryTypes->links() }}
    </div>
</div>

<!-- Sortable JS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Desktop sortable
        const sortable = document.getElementById('sortable');
        
        if (sortable) {
            new Sortable(sortable, {
                animation: 150,
                handle: '.fa-grip-vertical',
                onEnd: function(evt) {
                    const order = [];
                    document.querySelectorAll('#sortable tr').forEach((row, index) => {
                        order.push(row.getAttribute('data-id'));
                    });

                    // Send AJAX request to update order
                    fetch('{{ route("admin.query-types.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });
        }

        // Mobile sortable
        const sortableMobile = document.getElementById('sortable-mobile');
        
        if (sortableMobile) {
            new Sortable(sortableMobile, {
                animation: 150,
                handle: '.fa-grip-vertical',
                onEnd: function(evt) {
                    const order = [];
                    document.querySelectorAll('#sortable-mobile > div').forEach((card, index) => {
                        order.push(card.getAttribute('data-id'));
                    });

                    // Send AJAX request to update order
                    fetch('{{ route("admin.query-types.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    });
                }
            });
        }
    });
</script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Mobile specific adjustments */
    @media (max-width: 767px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
    }

    /* Sortable ghost styling */
    .sortable-ghost {
        opacity: 0.4;
        background: #f3f4f6;
    }

    /* Mobile drag handle visibility */
    @media (max-width: 767px) {
        .fa-grip-vertical {
            cursor: grab;
        }
        
        .fa-grip-vertical:active {
            cursor: grabbing;
        }
    }

    /* Fix for query types table column overflow */
.min-w-full {
    table-layout: fixed;
}

.min-w-full th,
.min-w-full td {
    word-wrap: break-word;
    overflow-wrap: break-word;
    vertical-align: middle;
}

/* Specific column width adjustments for Query Types table */
.min-w-full th:nth-child(1),
.min-w-full td:nth-child(1) {
    width: 8%;
    min-width: 80px;
}

.min-w-full th:nth-child(2),
.min-w-full td:nth-child(2) {
    width: 20%;
    min-width: 200px;
}

.min-w-full th:nth-child(3),
.min-w-full td:nth-child(3) {
    width: 12%;
    min-width: 120px;
}

.min-w-full th:nth-child(4),
.min-w-full td:nth-child(4) {
    width: 25%;
    min-width: 250px;
}

.min-w-full th:nth-child(5),
.min-w-full td:nth-child(5) {
    width: 10%;
    min-width: 100px;
}

.min-w-full th:nth-child(6),
.min-w-full td:nth-child(6) {
    width: 10%;
    min-width: 100px;
}

.min-w-full th:nth-child(7),
.min-w-full td:nth-child(7) {
    width: 15%;
    min-width: 120px;
}

/* Prevent long descriptions from breaking layout */
.truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Adjust cell padding for better spacing */
.px-6.py-4 {
    padding-left: 1rem !important;
    padding-right: 1rem !important;
}
</style>
@endsection