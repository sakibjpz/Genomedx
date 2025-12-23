@extends('admin.layouts.app')

@section('title', 'Create Query Type')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.query-types.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to query types
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Query Type</h1>

        <form action="{{ route('admin.query-types.store') }}" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-medium mb-2">
                    System Name *
                </label>
                <input type="text" id="name" name="name" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g., alaset, viasure_ngs">
                <p class="text-sm text-gray-500 mt-1">
                    Internal name (lowercase, no spaces). Used in database.
                </p>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Display Name -->
            <div class="mb-6">
                <label for="display_name" class="block text-gray-700 font-medium mb-2">
                    Display Name *
                </label>
                <input type="text" id="display_name" name="display_name" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g., Alaset, VIASURE NGS">
                <p class="text-sm text-gray-500 mt-1">
                    Name shown to users on contact form.
                </p>
                @error('display_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-gray-700 font-medium mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Brief description of this query type"></textarea>
            </div>

            <!-- Team Assignment -->
            <div class="mb-6">
                <label for="team_id" class="block text-gray-700 font-medium mb-2">
                    Assigned Team *
                </label>
                <select id="team_id" name="team_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Team</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}">
                            {{ $team->name }} ({{ $team->email }})
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-500 mt-1">
                    Queries of this type will be sent to this team.
                </p>
                @error('team_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Sort Order -->
            <div class="mb-6">
                <label for="sort_order" class="block text-gray-700 font-medium mb-2">
                    Sort Order
                </label>
                <input type="number" id="sort_order" name="sort_order" value="0"
                       class="w-32 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">
                    Lower numbers appear first on contact form.
                </p>
            </div>

            <!-- Active Status -->
            <div class="mb-8">
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           class="h-4 w-4 text-blue-600" checked>
                    <label for="is_active" class="ml-2 text-gray-700 font-medium">
                        Active (show on contact form)
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.query-types.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Create Query Type
                </button>
            </div>
        </form>
    </div>
</div>
@endsection