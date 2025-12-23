@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    {{ isset($feature) ? 'Edit Feature' : 'Add New Feature' }}
                </h2>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">Product:</span>
                        <span class="font-medium">{{ $product->name }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
              <a href="{{ route('admin.product-groups.products.edit', [$product->productGroup, $product->id]) }}#features"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to Product
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <form action="{{ isset($feature) 
                ? route('admin.products.features.update', [$product->id, $feature->id]) 
                : route('admin.products.features.store', $product->id) }}" 
                method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($feature))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            Title *
                        </label>
                        <input type="text" name="title" id="title"
                            value="{{ old('title', $feature->title ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="e.g., HIGH SPECIFICITY, HIGH SENSITIVITY"
                            required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Description (Bullet Points)
                        </label>
                        <textarea name="description" id="description" rows="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                            placeholder="Enter each bullet point on a new line. Example:
• Secured by targeting specific conservative DNA sequence
• Prevents detection failure caused by mutations
• Detection of all HBV genotypes A – H">{{ old('description', $feature->description ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">
                            Each new line will be converted to a bullet point. Leave empty lines between paragraphs.
                        </p>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Download Link -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Download Label -->
    <div>
        <label for="download_label" class="block text-sm font-medium text-gray-700">
            Download Button Text
        </label>
        <input type="text" name="download_label" id="download_label"
            value="{{ old('download_label', $feature->download_label ?? 'Download Laboratory Workflow') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
            placeholder="e.g., Download Laboratory Workflow">
        @error('download_label')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Download File Upload -->
    <div>
        <label for="download_link" class="block text-sm font-medium text-gray-700">
            PDF File Upload
        </label>
        <input type="file" name="download_file" id="download_link"
    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        @if(isset($feature) && $feature->download_link)
            <p class="mt-2 text-sm text-green-600">
                ✓ PDF already uploaded: {{ basename($feature->download_link) }}
            </p>
        @endif
        
        @error('download_link')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

                    <!-- Icon and Color -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Icon -->
                        <div>
                            <label for="icon" class="block text-sm font-medium text-gray-700">
                                Icon (FontAwesome Class)
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-icons text-gray-400"></i>
                                </div>
                                <input type="text" name="icon" id="icon"
                                    value="{{ old('icon', $feature->icon ?? '') }}"
                                    placeholder="fas fa-check-circle, fas fa-shield-alt, etc."
                                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Use FontAwesome classes. Visit <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-600">fontawesome.com</a> for icons.
                            </p>
                            @error('icon')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">
                                Color
                            </label>
                            <div class="mt-1 flex items-center space-x-4">
                                <input type="color" name="color" id="color-picker"
                                    value="{{ old('color', $feature->color ?? '#3b82f6') }}"
                                    class="h-10 w-10 cursor-pointer rounded border border-gray-300">
                                <input type="text" name="color" id="color"
                                    value="{{ old('color', $feature->color ?? '#3b82f6') }}"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="#3b82f6">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Hex color code for the feature card background.
                            </p>
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sort Order and Active Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700">
                                Sort Order
                            </label>
                            <input type="number" name="sort_order" id="sort_order"
                                value="{{ old('sort_order', $feature->sort_order ?? 0) }}"
                                min="0"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <p class="mt-1 text-xs text-gray-500">
                                Lower numbers appear first.
                            </p>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-end">
                            <div class="flex items-center h-10">
                                <input type="checkbox" name="is_active" id="is_active" value="1"
                                    {{ old('is_active', isset($feature) ? $feature->is_active : true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Active Feature
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Preview</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0 h-12 w-12 flex items-center justify-center rounded-md bg-blue-100"
                                     id="preview-icon-container">
                                    <i class="fas fa-check-circle text-blue-600 text-lg" id="preview-icon"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900" id="preview-title">
                                        {{ old('title', $feature->title ?? 'FEATURE TITLE') }}
                                    </h4>
                                    <div class="mt-2 text-sm text-gray-600 space-y-1" id="preview-description">
                                        @if(old('description', $feature->description ?? ''))
                                            @foreach(explode("\n", old('description', $feature->description ?? '')) as $line)
                                                @if(trim($line))
                                                    <div>• {{ trim($line) }}</div>
                                                @endif
                                            @endforeach
                                        @else
                                            <div>• First bullet point will appear here</div>
                                            <div>• Second bullet point will appear here</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                 <a href="{{ route('admin.product-groups.products.edit', [$product->productGroup, $product->id]) }}#features"
                       class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ isset($feature) ? 'Update Feature' : 'Create Feature' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Update Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get elements
        const titleInput = document.getElementById('title');
        const descriptionInput = document.getElementById('description');
        const iconInput = document.getElementById('icon');
        const colorInput = document.getElementById('color');
        const colorPicker = document.getElementById('color-picker');
        
        const previewTitle = document.getElementById('preview-title');
        const previewDescription = document.getElementById('preview-description');
        const previewIcon = document.getElementById('preview-icon');
        const previewIconContainer = document.getElementById('preview-icon-container');

        // Update title preview
        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value || 'FEATURE TITLE';
        });

        // Update description preview
        descriptionInput.addEventListener('input', function() {
            const lines = this.value.split('\n');
            let html = '';
            lines.forEach(line => {
                if (line.trim()) {
                    html += `<div>• ${line.trim()}</div>`;
                }
            });
            if (!html) {
                html = '<div>• First bullet point will appear here</div>' +
                       '<div>• Second bullet point will appear here</div>';
            }
            previewDescription.innerHTML = html;
        });

        // Update icon preview
        iconInput.addEventListener('input', function() {
            if (this.value) {
                previewIcon.className = this.value + ' text-lg';
                previewIcon.style.display = 'block';
            } else {
                previewIcon.className = 'fas fa-check-circle text-lg';
            }
        });

        // Update color preview
        function updateColorPreview(color) {
            // Lighten color for background (20% opacity)
            const bgColor = hexToRgba(color, 0.2);
            previewIconContainer.style.backgroundColor = bgColor;
            previewIcon.style.color = color;
        }

        // Sync color inputs
        colorInput.addEventListener('input', function() {
            colorPicker.value = this.value;
            updateColorPreview(this.value);
        });

        colorPicker.addEventListener('input', function() {
            colorInput.value = this.value;
            updateColorPreview(this.value);
        });

        // Initialize color preview
        updateColorPreview(colorInput.value);

        // Helper function to convert hex to rgba
        function hexToRgba(hex, alpha) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            return `rgba(${r}, ${g}, ${b}, ${alpha})`;
        }
    });
</script>
@endsection