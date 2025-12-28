@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">News Management</h1>
        <a href="{{ route('admin.news.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Add News
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($news as $item)
                    <tr>
                        <td class="px-6 py-4">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-newspaper text-gray-400"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-gray-900">{{ $item->title }}</div>
                            @if($item->excerpt)
                                <div class="text-sm text-gray-600 mt-1">{{ Str::limit($item->excerpt, 80) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full {{ $item->categoryColor }}">
                                {{ $item->categoryLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $item->published_date->format('d M, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($item->is_published)
                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">
                                    Published
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $item->views }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium space-x-2">
                            <a href="{{ route('admin.news.edit', $item) }}" 
                               class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('admin.news.destroy', $item) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No news articles found. <a href="{{ route('admin.news.create') }}" class="text-blue-600">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($news->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $news->links() }}
            </div>
        @endif
    </div>
</div>
@endsection