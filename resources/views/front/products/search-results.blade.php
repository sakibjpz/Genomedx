@extends('front.layouts.inner')

@section('content')
<h2 class="text-2xl font-bold mb-4">Search results for: "{{ $query }}"</h2>

@if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="border p-4 rounded">
                <h3 class="font-bold">{{ $product->name }}</h3>
                {{-- Add more product info as needed --}}
            </div>
        @endforeach
    </div>
@else
    <p>No products found.</p>
@endif
@endsection
