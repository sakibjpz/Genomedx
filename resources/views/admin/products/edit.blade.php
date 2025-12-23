@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Edit Product: {{ $product->name }}
                </h2>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">Group:</span>
                        <span class="font-medium">{{ $product->productGroup->name ?? 'No Group' }}</span>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">Status:</span>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $product->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('products.show', $product->slug) }}"
                   target="_blank"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View Live
                </a>
              <a href="{{ route('admin.product-groups.products.index', $product->productGroup) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to List
                </a>
            </div>
        </div>

        <!-- Main Content Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <a href="#basic-info" 
                       onclick="showTab('basic-info')"
                       class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm active">
                        Basic Information
                    </a>
                    <a href="#features" 
                       onclick="showTab('features')"
                       class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Features
                    </a>
                    <a href="#details" 
                       onclick="showTab('details')"
                       class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Details
                    </a>
                    <a href="#documents" 
                       onclick="showTab('documents')"
                       class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Documents
                    </a>
                    <a href="#related" 
                       onclick="showTab('related')"
                       class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Related Products
                    </a>
                    <a href="#order-info" onclick="showTab('order-info')" class="tab-link border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
        Order Info
    </a>
                </nav>
            </div>
        </div>

        <!-- Tab Contents -->
        <div class="space-y-6">
            <!-- Basic Information Tab -->
            <div id="basic-info" class="tab-content">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                    
                    <form action="{{ route('admin.product-groups.products.update', [$product->productGroup, $product->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Product Name -->
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Product Name *
                                </label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name', $product->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Product Group -->
                            <div>
                                <label for="product_group_id" class="block text-sm font-medium text-gray-700">
                                    Product Group
                                </label>
                                <select name="product_group_id" id="product_group_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    <option value="">Select Group</option>
                                    @foreach($productGroups as $group)
                                        <option value="{{ $group->id }}" 
                                            {{ $product->product_group_id == $group->id ? 'selected' : '' }}>
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_group_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700">
                                    Position
                                </label>
                                <input type="number" name="position" id="position"
                                    value="{{ old('position', $product->position) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('position')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Short Description -->
                            {{-- <div class="col-span-2">
                                <label for="short_description" class="block text-sm font-medium text-gray-700">
                                    Short Description
                                </label>
                                <textarea name="short_description" id="short_description" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('short_description', $product->short_description) }}</textarea>
                                @error('short_description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">
                                    Product Image
                                </label>
                                <div class="mt-1 flex items-center space-x-4">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}"
                                             class="h-20 w-20 object-cover rounded-md">
                                    @endif
                                    <input type="file" name="image" id="image"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Badge -->
                            <div>
                                <label for="badge" class="block text-sm font-medium text-gray-700">
                                    Badge
                                </label>
                                <input type="text" name="badge" id="badge"
                                    value="{{ old('badge', $product->badge) }}"
                                    placeholder="e.g., NEW, BEST SELLER"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('badge')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Certifications -->
                            <div>
                                <label for="certifications" class="block text-sm font-medium text-gray-700">
                                    Certifications
                                </label>
                                <input type="text" name="certifications" id="certifications"
                                    value="{{ old('certifications', $product->certifications) }}"
                                    placeholder="e.g., CE/IVD"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('certifications')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-span-2">
                                <div class="flex items-center">
                                    <input type="checkbox" name="status" id="status" value="1"
                                        {{ old('status', $product->status) ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="status" class="ml-2 block text-sm text-gray-900">
                                        Active Product
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-6 flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Features Tab - This is the section you already have -->
            <div id="features" class="tab-content" style="display: none;">
                @include('admin.products.edit-features')
            </div>

   <!-- Details Tab -->
<div id="details" class="tab-content" style="display: none;">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Product Details & Resources</h3>
                <p class="text-sm text-gray-500 mt-1">All product information, documents, and resources</p>
            </div>
            <a href="{{ route('admin.products.details.edit', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-edit mr-2"></i>
                Manage All Details
            </a>
        </div>
        
        @if($product->details || $product->features->count() > 0 || $product->documents->count() > 0)
            <div class="space-y-8">
                
                <!-- Features Section -->
                @if($product->features->count() > 0)
                <div class="border border-gray-200 rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-star text-yellow-600 mr-2"></i>
                        Product Features
                        <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                            {{ $product->features->count() }} features
                        </span>
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($product->features as $feature)
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                @if($feature->icon)
                                    <div class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center mr-3">
                                        <i class="{{ $feature->icon }} text-blue-600"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">{{ $feature->title }}</div>
                                    @if($feature->description)
                                        <div class="text-sm text-gray-600 mt-1">{{ $feature->description }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Images Section -->
                @if(($product->details && ($product->details->image || $product->details->second_image)) || $product->image)
                <div class="border border-gray-200 rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-images text-purple-600 mr-2"></i>
                        Product Images
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Main Product Image -->
                        @if($product->image)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <div class="p-3 bg-gray-50 border-b">
                                <div class="text-xs font-medium text-gray-700">Main Product Image</div>
                            </div>
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="Main product image"
                                 class="w-full h-48 object-contain bg-white p-4">
                        </div>
                        @endif

                        <!-- Detail Images -->
                        @if($product->details)
                            @if($product->details->image)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="p-3 bg-gray-50 border-b">
                                    <div class="text-xs font-medium text-gray-700">Detail Image 1</div>
                                </div>
                                <img src="{{ asset('storage/' . $product->details->image) }}" 
                                     alt="Product detail image 1"
                                     class="w-full h-48 object-contain bg-white p-4">
                            </div>
                            @endif

                            @if($product->details->second_image)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <div class="p-3 bg-gray-50 border-b">
                                    <div class="text-xs font-medium text-gray-700">Detail Image 2</div>
                                </div>
                                <img src="{{ asset('storage/' . $product->details->second_image) }}" 
                                     alt="Product detail image 2"
                                     class="w-full h-48 object-contain bg-white p-4">
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
                @endif

               <!-- Order Table -->
@if($product->details && $product->details->order_table)
<div class="border border-gray-200 rounded-lg p-6">
    <h4 class="text-sm font-medium text-gray-900 mb-4 flex items-center">
        <i class="fas fa-table text-green-600 mr-2"></i>
        Order Table / Pricing
    </h4>
    
    @php
        $orderTable = $product->details->order_table;
        
        // Try to decode if it's JSON string
        if (is_string($orderTable)) {
            $decoded = json_decode($orderTable, true);
            $orderTable = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }
        
        $hasValidOrderTable = false;
        $headers = [];
        $tableData = [];
        
        if (is_array($orderTable) && count($orderTable) > 0) {
            // Check if it's a valid table
            $firstRow = $orderTable[0] ?? [];
            if (is_array($firstRow) && count($firstRow) > 0) {
                $hasValidOrderTable = true;
                $headers = array_keys($firstRow);
                $tableData = $orderTable;
            }
        }
    @endphp
    
    @if($hasValidOrderTable)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ ucfirst(str_replace('_', ' ', $header)) }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tableData as $row)
                        <tr class="hover:bg-gray-50">
                            @foreach($row as $cell)
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    {{ $cell }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
            <i class="fas fa-table text-gray-400 text-3xl mb-3"></i>
            <p class="text-gray-500">Order table data exists but format is invalid</p>
            <p class="text-sm text-gray-400 mt-2">Please edit the details to fix the order table format</p>
            <a href="{{ route('admin.products.details.edit', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 mt-4">
                <i class="fas fa-edit mr-2"></i>
                Fix Order Table
            </a>
        </div>
    @endif
</div>
@endif

                <!-- Documents Section -->
                @if($product->documents->count() > 0)
                <div class="border border-gray-200 rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                        Documents & Downloads
                        <span class="ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                            {{ $product->documents->count() }} documents
                        </span>
                    </h4>
                    
                    <div class="space-y-3">
                        @foreach($product->documents as $document)
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-file-pdf text-red-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $document->title }}</div>
                                        <div class="text-sm text-gray-500 flex items-center mt-1">
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded mr-2">
                                                {{ ucfirst(str_replace('_', ' ', $document->category)) }}
                                            </span>
                                            @if($document->file_size)
                                                <span class="mr-3">{{ round($document->file_size / 1024, 1) }} KB</span>
                                            @endif
                                            @if($document->is_active)
                                                <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded">Active</span>
                                            @else
                                                <span class="px-2 py-0.5 bg-gray-100 text-gray-800 text-xs rounded">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($document->category === 'product_leaflet')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">Leaflet</span>
                                    @elseif($document->category === 'laboratory_workflow')
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs rounded">Workflow</span>
                                    @elseif($document->category === 'brochure')
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded">Brochure</span>
                                    @endif
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank"
                                       class="text-blue-600 hover:text-blue-800 ml-2">
                                        <i class="fas fa-external-link-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Brochure Section -->
                @if($product->details && $product->details->brochure)
                <div class="border border-gray-200 rounded-lg p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-book-open text-indigo-600 mr-2"></i>
                        Product Brochure
                    </h4>
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-50 to-white border border-indigo-100 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-book text-indigo-700 text-xl"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900">Product Brochure</div>
                                <div class="text-sm text-gray-600 mt-1">Detailed product information and specifications</div>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $product->details->brochure) }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <i class="fas fa-download mr-2"></i>
                            Download PDF
                        </a>
                    </div>
                </div>
                @endif

            </div>
        @else
            <!-- No Details Added -->
            <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
                <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Product Details Found</h4>
                <p class="text-gray-500 mb-6">Add features, images, documents, and brochures for this product.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('admin.products.details.edit', $product->id) }}"
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add Product Details
                    </a>
                    <a href="{{ route('admin.products.features.create', $product->id) }}"
                       class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-star mr-2"></i>
                        Add Features
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

            <!-- Documents Tab (Placeholder) -->
           <div id="documents" class="tab-content" style="display: none;">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Product Documents</h3>
            <a href="{{ route('admin.products.documents.create', $product->id) }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-plus mr-2"></i>
                Upload Document
            </a>
        </div>
        
        @if($product->documents->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($product->documents as $document)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $document->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $document->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-file-pdf mr-1"></i> View PDF
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.products.documents.edit', [$product->id, $document->id]) }}"
                                       class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    
                                    <form action="{{ route('admin.products.documents.destroy', [$product->id, $document->id]) }}" 
                                          method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to delete this document?')"
                                                class="text-red-600 hover:text-red-900">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-file-pdf text-gray-400 text-4xl mb-4"></i>
                <p class="text-gray-500">No documents uploaded yet.</p>
                <a href="{{ route('admin.products.documents.create', $product->id) }}"
                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    <i class="fas fa-plus mr-2"></i>
                    Upload your first document
                </a>
            </div>
        @endif
    </div>
</div>

            <!-- Related Products Tab (Placeholder) -->
            <div id="related" class="tab-content" style="display: none;">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Related Products</h3>
                    <p class="text-gray-500">Related products management will be implemented here.</p>
                </div>
            </div>

            <!-- Order Information Tab -->
<div id="order-info" class="tab-content" style="display: none;">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Product Order Information</h3>
                <p class="text-sm text-gray-500 mt-1">Custom order info for this product</p>
            </div>
            <a href="{{ route('admin.order-information.edit') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-cog mr-2"></i>
                Global Settings
            </a>
        </div>
        
        <!-- Note about global settings -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                <div>
                    <h4 class="font-medium text-blue-900 mb-1">Global Order Information</h4>
                    <p class="text-blue-800 text-sm">
                        Order information is managed globally. Changes affect all products.
                        Use the "Global Settings" button to edit contact details, phone numbers, and other order information.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Current Global Settings Preview -->
        @php
            $orderInfo = App\Models\OrderInformation::first();
        @endphp
        
        @if($orderInfo)
            <div class="border border-gray-200 rounded-lg p-6">
                <h4 class="font-medium text-gray-900 mb-4">Current Global Settings Preview</h4>
                
                <div class="space-y-4">
                    @if($orderInfo->show_sales_section)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-phone-alt text-blue-600 mr-3"></i>
                            <div>
                                <div class="font-medium text-gray-900">Sales Phone</div>
                                <div class="text-sm text-gray-600">{{ $orderInfo->sales_phone ?: 'Not set' }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Active</span>
                    </div>
                    @endif
                    
                    @if($orderInfo->show_support_section)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-headset text-green-600 mr-3"></i>
                            <div>
                                <div class="font-medium text-gray-900">Technical Support</div>
                                <div class="text-sm text-gray-600">{{ $orderInfo->support_phone ?: 'Not set' }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Active</span>
                    </div>
                    @endif
                    
                    @if($orderInfo->show_address_section)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-gray-600 mr-3"></i>
                            <div>
                                <div class="font-medium text-gray-900">Company Address</div>
                                <div class="text-sm text-gray-600">
                                    {{ Str::limit($orderInfo->company_address, 50) ?: 'Not set' }}
                                </div>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Active</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-blue-600 mr-3"></i>
                            <div>
                                <div class="font-medium text-gray-900">Contact Button</div>
                                <div class="text-sm text-gray-600">{{ $orderInfo->contact_button_text }}</div>
                            </div>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Set</span>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('admin.order-information.edit') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Global Settings
                        </a>
                        
                        <a href="{{ url('/contact') }}" target="_blank"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            View Contact Page
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
                <i class="fas fa-shopping-cart text-gray-400 text-4xl mb-4"></i>
                <h4 class="text-lg font-medium text-gray-900 mb-2">No Order Information Set</h4>
                <p class="text-gray-500 mb-6">Set up global order information to display on product pages.</p>
                <a href="{{ route('admin.order-information.edit') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-cog mr-2"></i>
                    Set Up Order Information
                </a>
            </div>
        @endif
    </div>
</div>
        </div>
    </div>
</div>

<!-- Tab Switching JavaScript -->
<script>
    function showTab(tabId) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });
        
        // Remove active class from all tab links
        document.querySelectorAll('.tab-link').forEach(link => {
            link.classList.remove('active', 'border-blue-500', 'text-blue-600');
            link.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById(tabId).style.display = 'block';
        
        // Add active class to clicked tab link
        event.target.classList.remove('border-transparent', 'text-gray-500');
        event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
    }
    
    // Show first tab by default
    document.addEventListener('DOMContentLoaded', function() {
        showTab('basic-info');
    });
</script>

<style>
    .tab-link.active {
        border-color: #3b82f6;
        color: #2563eb;
    }
</style>
@endsection