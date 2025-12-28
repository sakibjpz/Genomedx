@extends('front.layouts.inner')

@section('title', 'News & Events - GenomeDX')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <!-- Page Header -->
    <div class="text-center mb-8 md:mb-12">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4">
            News & Events
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg">
            Stay updated with our latest achievements, events, and announcements
        </p>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 mb-8 md:mb-12">
        @forelse($allNews as $news)
            <article class="group relative bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <!-- Image Container -->
                <div class="relative h-48 md:h-56 overflow-hidden">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-50 to-gray-100 flex items-center justify-center">
                            <i class="fas fa-newspaper text-gray-300 text-5xl"></i>
                        </div>
                    @endif
                    
                    <!-- Category Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 text-xs font-semibold text-white rounded-full {{ $news->categoryColor }}">
                            {{ $news->categoryLabel }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 md:p-6">
                    <time class="text-sm text-gray-500 mb-2 block">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ $news->published_date->format('d M, Y') }}
                    </time>
                    
                    <h3 class="text-lg md:text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">
                        <a href="{{ route('news.show', $news) }}" class="hover:no-underline">
                            {{ $news->title }}
                        </a>
                    </h3>
                    
                    @if($news->excerpt)
                        <p class="text-gray-600 mb-4 line-clamp-3 text-sm md:text-base">
                            {{ $news->excerpt }}
                        </p>
                    @endif

                    <!-- Read More -->
                    <a href="{{ route('news.show', $news) }}" 
                       class="inline-flex items-center text-blue-600 font-medium text-sm md:text-base hover:text-blue-700 transition-colors">
                        Read More
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>
        @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full mb-6">
                    <i class="fas fa-newspaper text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No News Yet</h3>
                <p class="text-gray-600 mb-6">Check back later for updates and announcements</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($allNews->hasPages())
        <div class="flex justify-center">
            <div class="inline-flex rounded-lg shadow-sm">
                @if($allNews->onFirstPage())
                    <span class="px-4 py-2 text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-2"></i> Previous
                    </span>
                @else
                    <a href="{{ $allNews->previousPageUrl() }}" 
                       class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50">
                        <i class="fas fa-chevron-left mr-2"></i> Previous
                    </a>
                @endif

                @foreach(range(1, $allNews->lastPage()) as $page)
                    @if($page == $allNews->currentPage())
                        <span class="px-4 py-2 text-white bg-blue-600 border border-blue-600">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $allNews->url($page) }}" 
                           class="px-4 py-2 text-blue-600 bg-white border border-gray-300 hover:bg-gray-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if($allNews->hasMorePages())
                    <a href="{{ $allNews->nextPageUrl() }}" 
                       class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50">
                        Next <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                @else
                    <span class="px-4 py-2 text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                        Next <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection