@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Banners</h1>
        <a href="{{ route('admin.banners.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-center text-sm sm:text-base hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-1"></i> Add Banner
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
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Title</th>
                        <th class="border border-gray-300 px-4 py-3 text-center text-sm font-semibold">Image</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Button</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">
                                <div class="text-sm text-gray-900">{!! $banner->title !!}</div>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <img src="{{ asset('images/'.$banner->image) }}" 
                                     alt="Banner" 
                                     class="w-32 h-16 object-cover inline-block rounded border border-gray-200 shadow-sm">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                @if($banner->button_text)
                                    <a href="{{ $banner->button_url }}" 
                                       target="_blank"
                                       class="inline-block bg-orange-500 text-white px-3 py-1 rounded text-sm hover:bg-orange-600 transition">
                                        {{ $banner->button_text }}
                                    </a>
                                @else
                                    <span class="text-gray-400 text-sm">N/A</span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.banners.edit', $banner->id) }}" 
                                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this banner?')" 
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600 transition">
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
        @foreach($banners as $banner)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Banner Image -->
            <div class="w-full h-32 sm:h-40 bg-gray-100">
                <img src="{{ asset('images/'.$banner->image) }}" 
                     alt="Banner" 
                     class="w-full h-full object-cover">
            </div>

            <!-- Card Content -->
            <div class="p-4">
                <!-- Title -->
                <div class="mb-3">
                    <h3 class="text-sm font-semibold text-gray-700 mb-1">Banner Title:</h3>
                    <div class="text-sm text-gray-900">{!! $banner->title !!}</div>
                </div>

                <!-- Button Info -->
                <div class="mb-4 pb-3 border-b">
                    <h3 class="text-xs font-semibold text-gray-700 mb-2">Button Details:</h3>
                    @if($banner->button_text)
                        <div class="space-y-2">
                            <div class="flex items-center justify-between bg-gray-50 rounded p-2">
                                <span class="text-xs text-gray-600">Text:</span>
                                <span class="text-xs font-medium text-gray-900">{{ $banner->button_text }}</span>
                            </div>
                            <div class="bg-gray-50 rounded p-2">
                                <span class="text-xs text-gray-600 block mb-1">URL:</span>
                                <a href="{{ $banner->button_url }}" 
                                   target="_blank" 
                                   class="text-xs text-blue-600 hover:text-blue-800 break-all">
                                    {{ $banner->button_url }}
                                </a>
                            </div>
                            <a href="{{ $banner->button_url }}" 
                               target="_blank"
                               class="block w-full text-center bg-orange-500 text-white px-3 py-2 rounded text-sm hover:bg-orange-600 transition">
                                Preview Button: {{ $banner->button_text }}
                            </a>
                        </div>
                    @else
                        <p class="text-xs text-gray-400 italic">No button configured</p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.banners.edit', $banner->id) }}" 
                       class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this banner?')" 
                          class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white text-sm font-medium rounded hover:bg-red-600 transition">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        @if($banners->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-image text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No banners yet.</p>
            <a href="{{ route('admin.banners.create') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                Add your first banner →
            </a>
        </div>
        @endif
    </div>

    <!-- Empty state for desktop -->
    @if($banners->isEmpty())
    <div class="hidden md:block bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-image text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg mb-4">No banners yet.</p>
        <a href="{{ route('admin.banners.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add your first banner
        </a>
    </div>
    @endif

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
            vertical-align: middle;
        }
    }

    /* Break long URLs properly */
    .break-all {
        word-break: break-all;
        overflow-wrap: break-word;
    }
</style>

@endsection