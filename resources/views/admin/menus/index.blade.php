@extends('admin.layouts.app')

@section('title', 'Menus')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Menus</h1>
        <a href="{{ route('admin.menus.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-center text-sm sm:text-base hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-1"></i> Add Menu
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Desktop Table View -->
    <div class="hidden md:block bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Order</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Menu & Submenu</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="menu-list">
                    @foreach($menus as $menu)
                        <tr data-id="{{ $menu->id }}" class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3 text-center font-medium">{{ $menu->order }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <span class="font-semibold text-gray-900">{{ $menu->name }}</span>

                                {{-- Show submenus --}}
                                @if($menu->children->count() > 0)
                                    <ul class="ml-6 mt-2 list-disc text-sm text-gray-600">
                                        @foreach($menu->children as $child)
                                            <li class="mt-1">{{ $child->name }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure?')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4">
        @foreach($menus as $menu)
        <div data-id="{{ $menu->id }}" class="bg-white rounded-lg shadow p-4">
            <!-- Header with Order Badge -->
            <div class="flex justify-between items-start mb-3 pb-3 border-b">
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900">{{ $menu->name }}</h3>
                </div>
                <span class="ml-3 flex-shrink-0 bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">
                    Order: {{ $menu->order }}
                </span>
            </div>

            <!-- Submenus -->
            @if($menu->children->count() > 0)
            <div class="mb-4">
                <p class="text-xs font-medium text-gray-600 mb-2">Submenus:</p>
                <ul class="space-y-1">
                    @foreach($menu->children as $child)
                        <li class="flex items-center text-sm text-gray-700">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-2"></span>
                            {{ $child->name }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="mb-4">
                <p class="text-xs text-gray-500 italic">No submenus</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex gap-2 pt-3 border-t">
                <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                   class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this menu?')" 
                      class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 transition">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>

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

    /* Table styling improvements */
    @media (min-width: 768px) {
        table {
            border-collapse: collapse;
        }
        
        table td {
            vertical-align: top;
        }
    }
</style>

{{-- Optional: Add drag-and-drop reorder script later --}}

@endsection