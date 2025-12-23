@extends('front.layouts.inner')

@section('content')

<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4">

        <h1 class="text-4xl font-bold text-center text-gray-800 mb-12">
            All products from the group
        </h1>

        <div class="space-y-4 mb-16">

            @foreach ($products as $product)
                @if($product->status) {{-- show only active products --}}
                <a href="{{ route('products.show', ['product' => $product->slug]) }}"
                   class="flex items-center justify-between bg-white px-6 py-5 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">

                    <div class="flex items-center gap-4">

                        <!-- Product Name -->
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ $product->name }}
                        </h2>

                        <!-- Badge (optional) -->
                        @if($product->badge)
                            <span class="flex-shrink-0 inline-flex items-center justify-center bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded uppercase">
                                {{ $product->badge }}
                            </span>
                        @endif

                        <!-- CE/IVD Marks (if applicable) -->
                        @if($product->certifications)
                            <div class="flex gap-2 text-xs text-gray-600">
                                @foreach(explode(',', $product->certifications) as $cert)
                                    <span class="border border-gray-400 px-2 py-0.5 rounded">{{ trim($cert) }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Product Icon/Image -->
                    <div class="w-16 h-16 flex items-center justify-center flex-shrink-0">
                        <div class="w-14 h-14 rounded-full border-2 border-red-500 flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C12 2 6 8 6 13C6 16.31 8.69 19 12 19C15.31 19 18 16.31 18 13C18 8 12 2 12 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                            </svg>
                        </div>
                    </div>

                </a>
                @endif
            @endforeach

        </div>

    </div>
</section>

@endsection
