@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Add New News</h1>
        <p class="text-gray-600 mt-1">Create a new news article for the frontend</p>
    </div>

    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="bg-white rounded-lg shadow p-6">
            @include('admin.news.form')
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('admin.news.index') }}" 
               class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                Cancel
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-save mr-2"></i> Save News
            </button>
        </div>
    </form>
</div>
@endsection