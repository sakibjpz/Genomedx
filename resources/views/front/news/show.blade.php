@extends('front.layouts.inner')

@section('title', $news->title . ' - GenomeDX')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-700 font-medium text-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Main Article -->
            <article class="lg:col-span-2">
                <!-- Title -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 leading-tight">
                    {{ $news->title }}
                </h1>

                <!-- Date -->
                <time class="inline-block text-sm text-gray-600 mb-6">
                    {{ $news->published_date->format('d/m/Y') }}
                </time>

                <!-- News Image -->
                <div class="relative mb-8 rounded-lg overflow-hidden shadow-md">
                    @if($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}"
                             class="w-full h-auto object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-purple-200 via-blue-200 to-purple-300 flex items-center justify-center">
                            <i class="fas fa-newspaper text-gray-400 text-8xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Excerpt -->
                @if($news->excerpt)
                    <div class="mb-6">
                        <p class="text-lg md:text-xl text-gray-800 font-medium leading-relaxed">
                            {{ $news->excerpt }}
                        </p>
                    </div>
                @endif

                <!-- Content -->
                @if($news->content)
                    <div class="text-gray-700 text-base md:text-lg leading-relaxed space-y-4 mb-8">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <i class="fas fa-file-alt text-4xl mb-4"></i>
                        <p>Full content coming soon...</p>
                    </div>
                @endif

                <!-- Share Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Share this article:</h3>
                    <div class="flex space-x-3">
                        <a href="#" 
                           onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(window.location.href), 'facebook-share', 'width=580,height=296'); return false;"
                           class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center hover:bg-blue-700 transition shadow-md">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        {{-- <a href="#" 
                           onclick="window.open('https://twitter.com/intent/tweet?text='+encodeURIComponent('{{ $news->title }}')+'&url='+encodeURIComponent(window.location.href), 'twitter-share', 'width=550,height=235'); return false;"
                           class="w-10 h-10 bg-blue-400 text-white rounded-full flex items-center justify-center hover:bg-blue-500 transition shadow-md">
                            <i class="fab fa-twitter text-sm"></i>
                        </a> --}}
                        <a href="#" 
                           onclick="window.open('https://www.linkedin.com/shareArticle?mini=true&url='+encodeURIComponent(window.location.href)+'&title='+encodeURIComponent('{{ $news->title }}'), 'linkedin-share', 'width=600,height=400'); return false;"
                           class="w-10 h-10 bg-blue-700 text-white rounded-full flex items-center justify-center hover:bg-blue-800 transition shadow-md">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="mailto:?subject={{ urlencode($news->title) }}&body={{ urlencode('Check out this article: ' . url()->current()) }}" 
                           class="w-10 h-10 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition shadow-md">
                            <i class="fas fa-envelope text-sm"></i>
                        </a>
                    </div>
                </div>
            </article>

            <!-- Right Column - Related News Sidebar -->
            @if($relatedNews->count() > 0)
                <aside class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 sticky top-8">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-6 pb-3 border-b border-gray-200">
                            Related News
                        </h2>
                        
                        <div class="space-y-6">
                            @foreach($relatedNews as $related)
                                <article class="group">
                                    @if($related->image)
                                        <a href="{{ route('news.show', $related) }}" class="block mb-3 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $related->image) }}" 
                                                 alt="{{ $related->title }}"
                                                 class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
                                        </a>
                                    @endif
                                    
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $related->categoryColor }} mb-2">
                                        {{ $related->categoryLabel }}
                                    </span>
                                    
                                    <h3 class="text-base font-bold text-gray-900 mb-2 leading-snug">
                                        <a href="{{ route('news.show', $related) }}" 
                                           class="hover:text-blue-600 transition line-clamp-2">
                                            {{ $related->title }}
                                        </a>
                                    </h3>
                                    
                                    <time class="text-xs text-gray-500 block">
                                        <i class="fas fa-calendar-alt mr-1"></i>
                                        {{ $related->published_date->format('d/m/Y') }}
                                    </time>

                                    @if(!$loop->last)
                                        <div class="mt-6 pt-6 border-t border-gray-100"></div>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                </aside>
            @endif
        </div>

        <!-- Related News Mobile/Desktop Grid (Below Article) -->
        @if($relatedNews->count() > 3)
            <div class="mt-16">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">More Related News</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($relatedNews->skip(3) as $related)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            @if($related->image)
                                <a href="{{ route('news.show', $related) }}">
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->title }}"
                                         class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                </a>
                            @endif
                            
                            <div class="p-5">
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-white rounded-full {{ $related->categoryColor }} mb-3">
                                    {{ $related->categoryLabel }}
                                </span>
                                
                                <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug">
                                    <a href="{{ route('news.show', $related) }}" 
                                       class="hover:text-blue-600 transition line-clamp-2">
                                        {{ $related->title }}
                                    </a>
                                </h3>
                                
                                <time class="text-sm text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    {{ $related->published_date->format('M d, Y') }}
                                </time>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection