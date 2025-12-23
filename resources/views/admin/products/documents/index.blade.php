@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Documents for: {{ $product->name }}
                </h2>
                <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">Product:</span>
                        <span class="font-medium">{{ $product->name }}</span>
                    </div>
                    <div class="mt-2 flex items-center text-sm text-gray-500">
                        <span class="mr-2">Documents:</span>
                        <span class="font-medium">{{ $documents->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
                <a href="{{ route('admin.product-groups.products.edit', [$product->productGroup, $product->id]) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to Product
                </a>
                <a href="{{ route('admin.products.documents.create', $product->id) }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-plus mr-2"></i>
                    Add New Document
                </a>
            </div>
        </div>

        <!-- Documents by Category -->
        @foreach($categories as $categoryKey => $categoryName)
            @php
                $categoryDocs = $documents->where('category', $categoryKey)->where('is_active', true);
            @endphp
            
            @if($categoryDocs->count() > 0)
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $categoryName }}</h3>
                
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        @foreach($categoryDocs as $document)
                        <li>
                            <div class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-4">
                                            <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $document->title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $document->file_name }} • 
                                                {{ round($document->file_size / 1024, 2) }} KB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $document->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $document->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.products.documents.edit', [$product->id, $document->id]) }}"
                                               class="text-blue-600 hover:text-blue-900">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.products.documents.destroy', [$product->id, $document->id]) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('Delete this document?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        @endforeach

        @if($documents->count() === 0)
        <div class="text-center py-12">
            <i class="fas fa-file-pdf text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No documents yet</h3>
            <p class="text-gray-500 mb-6">Get started by uploading your first document.</p>
            <a href="{{ route('admin.products.documents.create', $product->id) }}"
               class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <i class="fas fa-upload mr-2"></i>
                Upload First Document
            </a>
        </div>
        @endif
    </div>
</div>
@endsection