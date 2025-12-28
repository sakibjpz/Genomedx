@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Edit News: {{ $news->title }}</h1>
        <p class="text-gray-600 mt-1">Update the news article</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
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
                <i class="fas fa-save mr-2"></i> Update News
            </button>
        </div>
    </form>
</div>
@endsection