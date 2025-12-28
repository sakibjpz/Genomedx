@extends('front.layouts.inner')


@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Search Header --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-2">
                Search Results for "{{ $query }}"
            </h1>
            <p class="text-gray-600">
                Found {{ $products->count() }} product(s)
            </p>
        </div>

        {{-- Results --}}
        @if($products->count() > 0)
            <div class="space-y-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow overflow-hidden">
                        <div class="p-6">
                            {{-- Product Info --}}
                            <div class="flex items-start space-x-4">
                                @if($product->image || $product->image_path)
                                    @php
                                        $path = $product->image ?? $product->image_path;
                                        $isAsset = str_contains($path, 'assets/');
                                    @endphp
                                    <div class="flex-shrink-0 w-24 h-24">
                                        <img src="{{ $isAsset ? asset($path) : asset('storage/' . $path) }}" 
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-contain">
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <h3 class="font-bold text-xl text-gray-800 mb-2">
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="hover:text-blue-600">
                                            {{ $product->name }}
                                        </a>
                                    </h3>
                                    
                                    @if($product->productGroup)
                                        <div class="mb-3">
                                            <span class="inline-block bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded font-medium">
                                                {{ $product->productGroup->name }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($product->short_description)
                                        <p class="text-gray-600">
                                            {{ $product->short_description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Related Products from Same Group --}}
                            @if($product->productGroup)
                                @php
                                    $relatedProducts = $product->productGroup->products()
                                        ->where('id', '!=', $product->id)
                                        ->where('status', 1)
                                        ->limit(4)
                                        ->get();
                                @endphp
                                
                                @if($relatedProducts->count() > 0)
                                    <div class="mt-8 pt-6 border-t">
                                        <h4 class="font-bold text-gray-700 mb-4">
                                            Other products in {{ $product->productGroup->name }}
                                        </h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                            @foreach($relatedProducts as $related)
                                                <a href="{{ route('products.show', $related) }}"
                                                   class="border border-gray-200 rounded p-3 hover:bg-gray-50 transition">
                                                    <div class="font-medium text-gray-800 text-sm">
                                                        {{ $related->name }}
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <div class="text-5xl mb-4 text-gray-400">🔍</div>
                <h3 class="text-xl font-bold text-gray-700 mb-2">No products found</h3>
                <p class="text-gray-600 mb-6">Try different search terms</p>
                <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    ← Back to Home
                </a>
            </div>
        @endif

    </div>
</div>
@endsection