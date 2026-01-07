@extends('admin.layouts.app')

@section('title', 'Flags')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 gap-3">
        <h1 class="text-xl sm:text-2xl font-bold">Flags</h1>
        <a href="{{ route('admin.flags.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded text-center text-sm sm:text-base hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-1"></i> Add Flag
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
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Name</th>
                        <th class="border border-gray-300 px-4 py-3 text-center text-sm font-semibold">Image</th>
                        <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($flags as $flag)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-3">
                                <span class="text-sm font-medium text-gray-900">{{ $flag->name }}</span>
                            </td>
                            <td class="border border-gray-300 px-4 py-3 text-center">
                                <img src="{{ asset('storage/flags/'.$flag->image) }}" 
                                     alt="{{ $flag->name }}" 
                                     class="w-12 h-8 object-cover inline-block rounded border border-gray-200 shadow-sm">
                            </td>
                            <td class="border border-gray-300 px-4 py-3">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.flags.edit', $flag->id) }}" 
                                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.flags.destroy', $flag->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this flag?')" 
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
        @foreach($flags as $flag)
        <div class="bg-white rounded-lg shadow p-4">
            <!-- Flag Image & Name -->
            <div class="flex items-center mb-4 pb-3 border-b">
                <div class="flex-shrink-0 mr-4">
                    <img src="{{ asset('storage/flags/'.$flag->image) }}" 
                         alt="{{ $flag->name }}" 
                         class="w-16 h-10 object-cover rounded border-2 border-gray-200 shadow-sm">
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900">{{ $flag->name }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Flag Image</p>
                </div>
            </div>

            <!-- Image Path Info -->
            <div class="mb-4 bg-gray-50 rounded p-3">
                <p class="text-xs text-gray-600 font-medium mb-1">Image Path:</p>
                <code class="text-xs text-gray-900 font-mono break-all">storage/flags/{{ $flag->image }}</code>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <a href="{{ route('admin.flags.edit', $flag->id) }}" 
                   class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white text-sm font-medium rounded hover:bg-yellow-600 transition">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.flags.destroy', $flag->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this flag?')" 
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

        @if($flags->isEmpty())
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-flag text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">No flags yet.</p>
            <a href="{{ route('admin.flags.create') }}" class="inline-block mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium">
                Add your first flag →
            </a>
        </div>
        @endif
    </div>

    <!-- Empty state for desktop -->
    @if($flags->isEmpty())
    <div class="hidden md:block bg-white rounded-lg shadow p-8 text-center">
        <i class="fas fa-flag text-5xl text-gray-300 mb-4"></i>
        <p class="text-gray-500 text-lg mb-4">No flags yet.</p>
        <a href="{{ route('admin.flags.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus mr-2"></i> Add your first flag
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

    /* Image styling */
    img {
        display: inline-block;
    }
</style>

@endsection