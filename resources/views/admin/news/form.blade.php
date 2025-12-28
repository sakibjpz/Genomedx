<div class="space-y-6">
    <!-- Title -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
        <input type="text" 
               name="title" 
               value="{{ old('title', $news->title ?? '') }}" 
               class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               required>
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Excerpt -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt (Short Description)</label>
        <textarea name="excerpt" 
                  rows="3" 
                  class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('excerpt', $news->excerpt ?? '') }}</textarea>
        <p class="mt-1 text-sm text-gray-500">Brief summary shown on news cards (max 500 chars)</p>
        @error('excerpt')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Content -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
        <textarea name="content" 
                  rows="6" 
                  class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('content', $news->content ?? '') }}</textarea>
        @error('content')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Image Upload -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
        
        @if(isset($news) && $news->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $news->image) }}" 
                     alt="Current image" 
                     class="w-64 h-48 object-cover rounded-lg mb-2">
                <p class="text-sm text-gray-600">Current image</p>
            </div>
        @endif
        
        <input type="file" 
               name="image" 
               accept="image/*"
               class="w-full border border-gray-300 rounded-lg p-2">
        <p class="mt-1 text-sm text-gray-500">Upload JPG, PNG, GIF (max 2MB)</p>
        @error('image')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Category & Date Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Category -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
            <select name="category" 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required>
                <option value="news" {{ old('category', $news->category ?? '') == 'news' ? 'selected' : '' }}>News</option>
                <option value="event" {{ old('category', $news->category ?? '') == 'event' ? 'selected' : '' }}>Event</option>
                <option value="update" {{ old('category', $news->category ?? '') == 'update' ? 'selected' : '' }}>Update</option>
                <option value="achievement" {{ old('category', $news->category ?? '') == 'achievement' ? 'selected' : '' }}>Achievement</option>
            </select>
            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Published Date -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Published Date *</label>
            <input type="date" 
                   name="published_date" 
                   value="{{ old('published_date', isset($news) ? $news->published_date->format('Y-m-d') : date('Y-m-d')) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   required>
            @error('published_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Status & Sort Order Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Status -->
        <div>
            <label class="flex items-center space-x-3">
                <input type="checkbox" 
                       name="is_published" 
                       value="1"
                       {{ old('is_published', isset($news) ? $news->is_published : true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="text-sm font-medium text-gray-700">Publish this news</span>
            </label>
        </div>

        <!-- Sort Order -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
            <input type="number" 
                   name="sort_order" 
                   value="{{ old('sort_order', $news->sort_order ?? 0) }}"
                   class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
            @error('sort_order')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>