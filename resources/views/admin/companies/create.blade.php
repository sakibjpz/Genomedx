@extends('admin.layouts.app')

@section('title', 'Create Company')

@section('content')
<div class="container mx-auto p-4 max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.companies.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to companies
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Company</h1>

        <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-gray-700 font-medium mb-2">
                    Company Name *
                </label>
                <input type="text" id="name" name="name" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g., Partner Company 1">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div class="mb-6">
                <label for="slug" class="block text-gray-700 font-medium mb-2">
                    URL Slug *
                </label>
                <input type="text" id="slug" name="slug" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="e.g., partner-company-1">
                <p class="text-sm text-gray-500 mt-1">
                    Used in URLs (lowercase, hyphens, no spaces).
                </p>
                @error('slug')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Image -->
            <div class="mb-6">
                <label for="image" class="block text-gray-700 font-medium mb-2">
                    Company Image
                </label>
                <input type="file" id="image" name="image" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-500 mt-1">
                    Upload company logo or image (JPG, PNG, GIF, max 2MB)
                </p>
                @error('image')
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
                    Lower numbers appear first in menu.
                </p>
            </div>

            <!-- Active Status -->
            <div class="mb-8">
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           class="h-4 w-4 text-blue-600" checked>
                    <label for="is_active" class="ml-2 text-gray-700 font-medium">
                        Active (show in menu)
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.companies.index') }}" 
                   class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    Create Company
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    if (nameInput && slugInput) {
        nameInput.addEventListener('input', function() {
            if (!slugInput.dataset.manuallyEdited) {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
                    .replace(/\s+/g, '-')         // Replace spaces with hyphens
                    .replace(/-+/g, '-')          // Remove duplicate hyphens
                    .trim();
                slugInput.value = slug;
            }
        });
        
        // Track manual edits to slug
        slugInput.addEventListener('input', function() {
            this.dataset.manuallyEdited = 'true';
        });
    }
});
</script>
@endsection