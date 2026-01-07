@extends('admin.layouts.app')

@section('title', 'Companies Management')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Companies Management</h1>
        <a href="{{ route('admin.companies.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-center text-sm sm:text-base">
            <i class="fas fa-plus mr-2"></i>Add Company
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Groups</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="sortable">
                    @foreach($companies as $company)
                    <tr data-id="{{ $company->id }}" class="hover:bg-gray-50 cursor-move">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <i class="fas fa-grip-vertical text-gray-400"></i>
                            <span class="text-sm text-gray-500 ml-2">{{ $company->sort_order }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $company->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $company->slug }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $company->productGroups->count() > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $company->productGroups->count() }} groups
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $company->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.companies.edit', $company->id) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.companies.destroy', $company->id) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Delete this company?')">
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
        @foreach($companies as $company)
        <div data-id="{{ $company->id }}" class="bg-white rounded-lg shadow p-4">
            <!-- Drag Handle & Header -->
            <div class="flex items-center justify-between mb-3 pb-3 border-b">
                <div class="flex items-center flex-1">
                    <i class="fas fa-grip-vertical text-gray-400 text-lg mr-3 cursor-move"></i>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900 truncate">{{ $company->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $company->slug }}</p>
                    </div>
                </div>
                <span class="ml-3 flex-shrink-0 text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded">#{{ $company->sort_order }}</span>
            </div>

            <!-- Info Grid -->
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Product Groups:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $company->productGroups->count() > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $company->productGroups->count() }} groups
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-600 font-medium">Status:</span>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $company->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $company->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-3 border-t">
                <a href="{{ route('admin.companies.edit', $company->id) }}" 
                   class="flex-1 text-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.companies.destroy', $company->id) }}" 
                      method="POST" class="flex-1" 
                      onsubmit="return confirm('Delete this company?')">
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
        {{ $companies->links() }}
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
                    fetch('{{ route("admin.companies.reorder") }}', {
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
                    fetch('{{ route("admin.companies.reorder") }}', {
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

    /* Drag handle styling */
    .fa-grip-vertical {
        cursor: grab;
    }
    
    .fa-grip-vertical:active {
        cursor: grabbing;
    }
</style>
@endsection