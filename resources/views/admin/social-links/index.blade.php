@extends('admin.layouts.app')

@section('title', 'Social Links')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Social Links</h1>
        <a href="{{ route('admin.social-links.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-center text-sm sm:text-base hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-1"></i> Add Social Link
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
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Icon</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">URL</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($socialLinks as $link)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <i class="{{ $link->icon }} text-2xl text-gray-700"></i>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <a href="{{ $link->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm break-all">
                                    {{ $link->url }}
                                </a>
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.social-links.edit', $link->id) }}" 
                                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.social-links.destroy', $link->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this social link?')" 
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
        @foreach($socialLinks as $link)
        <div class="bg-white rounded-lg shadow p-4">
            <!-- Icon & URL Header -->
            <div class="flex items-start mb-4 pb-3 border-b">
                <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                    <i class="{{ $link->icon }} text-2xl text-gray-700"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs text-gray-600 font-medium mb-1">Social Link URL:</p>
                    <a href="{{ $link->url }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 break-all">
                        {{ $link->url }}
                    </a>
                </div>
            </div>

            <!-- Icon Class Display -->
            <div class="mb-4 bg-gray-50 rounded p-3">
                <p class="text-xs text-gray-600 font-medium mb-1">Icon Class:</p>
                <code class="text-xs text-gray-900 font-mono">{{ $link->icon }}</code>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('admin.social-links.edit', $link->id) }}" 
                   class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.social-links.destroy', $link->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this social link?')" 
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

        @if($socialLinks->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-share-alt text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No social links yet.</p>
            <a href="{{ route('admin.social-links.create') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                Add your first social link →
            </a>
        </div>
        @endif
    </div>

    <!-- Empty state for desktop -->
    @if($socialLinks->isEmpty())
    <div class="hidden md:block bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-share-alt text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg mb-4">No social links yet.</p>
        <a href="{{ route('admin.social-links.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add your first social link
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