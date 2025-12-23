@extends('front.layouts.app')

@section('title', 'Home')

@section('content')

{{-- Dynamic Banner Slider --}}
@if(isset($banners) && $banners->count() > 0)
<div x-data="{
        current: 0,
        total: {{ $banners->count() }},
        next() { this.current = (this.current + 1) % this.total; },
        prev() { this.current = (this.current - 1 + this.total) % this.total; },
        init() { setInterval(() => { this.next(); }, 5000); }
    }" class="relative overflow-hidden h-screen w-full">

    @foreach($banners as $index => $banner)
        <section class="absolute inset-0 transition-opacity duration-1000 bg-center bg-cover"
                 style="background-image: url('{{ asset('images/'.$banner->image) }}')"
                 :class="current === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
            
            {{-- Overlay --}}
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>

            {{-- Slide content with animations --}}
            <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 md:px-8 text-white">

                <h1 x-show="current === {{ $index }}" 
                    x-transition:enter="transition transform duration-1000" 
                    x-transition:enter-start="opacity-0 translate-y-10" 
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition transform duration-500"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-10"
                    class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold banner-heading mb-4">
                    {!! $banner->title !!}
                </h1>

                @if($banner->subtitle)
                    <p x-show="current === {{ $index }}" 
                       x-transition:enter="transition transform duration-1000 delay-200" 
                       x-transition:enter-start="opacity-0 translate-y-10" 
                       x-transition:enter-end="opacity-100 translate-y-0"
                       x-transition:leave="transition transform duration-500"
                       x-transition:leave-start="opacity-100 translate-y-0"
                       x-transition:leave-end="opacity-0 translate-y-10"
                       class="text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl mb-4">
                        {!! $banner->subtitle !!}
                    </p>
                @endif

                @if($banner->button_text)
                    <a x-show="current === {{ $index }}"
                       x-transition:enter="transition transform duration-1000 delay-400"
                       x-transition:enter-start="opacity-0 translate-y-10"
                       x-transition:enter-end="opacity-100 translate-y-0"
                       x-transition:leave="transition transform duration-500"
                       x-transition:leave-start="opacity-100 translate-y-0"
                       x-transition:leave-end="opacity-0 translate-y-10"
                       href="{{ $banner->button_url }}" 
                       class="bg-orange-500 hover:bg-orange-600 px-4 sm:px-6 md:px-8 py-2 sm:py-3 md:py-4 rounded-lg font-semibold transition text-sm sm:text-base md:text-lg">
                        {{ $banner->button_text }}
                    </a>
                @endif

            </div>

        </section>
    @endforeach

    {{-- Arrow Navigation --}}
    <button @click="prev()" class="absolute left-3 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70">&#10094;</button>
    <button @click="next()" class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-70">&#10095;</button>

    {{-- Slider dots --}}
    <div class="absolute bottom-5 left-1/2 transform -translate-x-1/2 flex space-x-3">
        <template x-for="i in total" :key="i">
            <button @click="current = i - 1"
                    :class="{'bg-orange-500': current === i - 1, 'bg-gray-300': current !== i - 1}"
                    class="w-3 h-3 sm:w-4 sm:h-4 rounded-full"></button>
        </template>
    </div>

</div>
<script src="//unpkg.com/alpinejs" defer></script>
@endif

{{-- Rest of your homepage content here --}}
{{-- Add other sections below the banner --}}

@endsection