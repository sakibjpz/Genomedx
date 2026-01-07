@extends('front.layouts.inner')

@section('title', 'News & Events - GenomeDX')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 md:py-12">
    <!-- Page Header -->
    <div class="text-center mb-6 sm:mb-8 md:mb-12">
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-3 sm:mb-4">
            News & Events
        </h1>
        <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto px-4">
            Stay updated with our latest achievements, events, and announcements
        </p>
    </div>

    <!-- News Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-6 sm:mb-8 md:mb-12">
        @forelse($allNews as $news)
            <article class="group relative bg-white rounded-lg sm:rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden sm:transform sm:hover:-translate-y-1">
                <!-- Image Container -->
                <div class="relative h-44 sm:h-48 md:h-56 overflow-hidden">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                             loading="lazy">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-50 to-gray-100 flex items-center justify-center">
                            <i class="fas fa-newspaper text-gray-300 text-4xl sm:text-5xl"></i>
                        </div>
                    @endif
                    
                    <!-- Category Badge -->
                    <div class="absolute top-3 sm:top-4 left-3 sm:left-4">
                        <span class="px-2 sm:px-3 py-1 text-xs font-semibold text-white rounded-full shadow-md {{ $news->categoryColor }}">
                            {{ $news->categoryLabel }}
                        </span>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-4 sm:p-5 md:p-6">
                    <time class="text-xs sm:text-sm text-gray-500 mb-2 block">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ $news->published_date->format('d M, Y') }}
                    </time>
                    
                    <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-2 sm:mb-3 group-hover:text-blue-600 transition-colors line-clamp-2">
                        <a href="{{ route('news.show', $news) }}" class="hover:no-underline">
                            {{ $news->title }}
                        </a>
                    </h3>
                    
                    @if($news->excerpt)
                        <p class="text-gray-600 mb-3 sm:mb-4 line-clamp-3 text-sm sm:text-base leading-relaxed">
                            {{ $news->excerpt }}
                        </p>
                    @endif

                    <!-- Read More -->
                    <a href="{{ route('news.show', $news) }}" 
                       class="inline-flex items-center text-blue-600 font-medium text-sm sm:text-base hover:text-blue-700 transition-colors touch-manipulation">
                        Read More
                        <i class="fas fa-arrow-right ml-2 text-xs sm:text-sm transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </article>
        @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-8 sm:py-12 px-4">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-blue-100 rounded-full mb-4 sm:mb-6">
                    <i class="fas fa-newspaper text-blue-600 text-2xl sm:text-3xl"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-2">No News Yet</h3>
                <p class="text-sm sm:text-base text-gray-600 mb-6">Check back later for updates and announcements</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($allNews->hasPages())
        <!-- Desktop Pagination -->
        <div class="hidden md:flex justify-center">
            <div class="inline-flex rounded-lg shadow-sm overflow-x-auto">
                @if($allNews->onFirstPage())
                    <span class="px-4 py-2 text-base text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed whitespace-nowrap">
                        <i class="fas fa-chevron-left mr-2"></i> Previous
                    </span>
                @else
                    <a href="{{ $allNews->previousPageUrl() }}" 
                       class="px-4 py-2 text-base text-blue-600 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 transition whitespace-nowrap">
                        <i class="fas fa-chevron-left mr-2"></i> Previous
                    </a>
                @endif

                @foreach(range(1, $allNews->lastPage()) as $page)
                    @if($page == $allNews->currentPage())
                        <span class="px-4 py-2 text-base text-white bg-blue-600 border border-blue-600">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $allNews->url($page) }}" 
                           class="px-4 py-2 text-base text-blue-600 bg-white border border-gray-300 hover:bg-gray-50 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                @if($allNews->hasMorePages())
                    <a href="{{ $allNews->nextPageUrl() }}" 
                       class="px-4 py-2 text-base text-blue-600 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 transition whitespace-nowrap">
                        Next <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                @else
                    <span class="px-4 py-2 text-base text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed whitespace-nowrap">
                        Next <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                @endif
            </div>
        </div>

        <!-- Mobile Pagination -->
        <div class="md:hidden">
            <div class="flex justify-center items-center gap-2 mb-3">
                @if($allNews->onFirstPage())
                    <span class="px-4 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed shadow-sm">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $allNews->previousPageUrl() }}" 
                       class="px-4 py-2 text-sm text-blue-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition touch-manipulation shadow-sm active:scale-95">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                <span class="px-4 py-2 text-sm text-gray-700 bg-gray-50 border border-gray-300 rounded-lg font-medium shadow-sm">
                    Page {{ $allNews->currentPage() }} of {{ $allNews->lastPage() }}
                </span>

                @if($allNews->hasMorePages())
                    <a href="{{ $allNews->nextPageUrl() }}" 
                       class="px-4 py-2 text-sm text-blue-600 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition touch-manipulation shadow-sm active:scale-95">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="px-4 py-2 text-sm text-gray-400 bg-white border border-gray-300 rounded-lg cursor-not-allowed shadow-sm">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </div>
            
            <!-- Page Number Selector for Mobile -->
            @if($allNews->lastPage() > 1)
            <div class="flex justify-center">
                <div class="inline-flex gap-1 bg-white rounded-lg shadow-sm border border-gray-300 p-1">
                    @foreach(range(1, min(5, $allNews->lastPage())) as $page)
                        @if($page == $allNews->currentPage())
                            <span class="px-3 py-1 text-sm text-white bg-blue-600 rounded font-medium">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $allNews->url($page) }}" 
                               class="px-3 py-1 text-sm text-blue-600 hover:bg-gray-100 rounded transition touch-manipulation active:scale-95">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                    
                    @if($allNews->lastPage() > 5)
                        <span class="px-2 py-1 text-sm text-gray-400">...</span>
                        <a href="{{ $allNews->url($allNews->lastPage()) }}" 
                           class="px-3 py-1 text-sm text-blue-600 hover:bg-gray-100 rounded transition touch-manipulation active:scale-95">
                            {{ $allNews->lastPage() }}
                        </a>
                    @endif
                </div>
            </div>
            @endif
        </div>
    @endif
</div>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Line clamping */
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

    /* Touch manipulation for better mobile experience */
    .touch-manipulation {
        touch-action: manipulation;
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Optimize images */
    img {
        image-rendering: -webkit-optimize-contrast;
    }

    /* Mobile hover fix */
    @media (hover: none) {
        .group:hover .group-hover\:scale-105 {
            transform: scale(1);
        }
        
        .group:hover .group-hover\:translate-x-1 {
            transform: translateX(0);
        }
    }

    /* Card shadow enhancement for mobile */
    @media (max-width: 640px) {
        article {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        article:active {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: scale(0.98);
        }
    }
</style>
@endsection