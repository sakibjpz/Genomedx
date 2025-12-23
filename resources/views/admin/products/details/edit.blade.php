@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">
        Edit Details: {{ $product->name }}
    </h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST"
          action="{{ route('admin.products.details.update', $product->id) }}"
          enctype="multipart/form-data"
          class="bg-white shadow rounded p-6">

        @csrf
        @method('PUT')

        {{-- Description --}}
        {{-- <div class="mb-4">
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2" rows="4">{{ old('description', $detail->description) }}</textarea>
        </div> --}}

        {{-- Specifications --}}
        {{-- <div class="mb-4">
            <label class="block font-medium mb-1">Specifications (one per line)</label>
            <textarea name="specifications" class="w-full border rounded px-3 py-2" rows="4">@if($detail->specifications){{ implode("\n", json_decode($detail->specifications, true)) }}@endif</textarea>
        </div> --}}

        {{-- Order Table (JSON) --}}
<div class="mb-4">
    <label class="block font-medium mb-1">Order Table (JSON - one row per line in format: Name|REF|Technology|Packaging)</label>
    <textarea name="order_table" class="w-full border rounded px-3 py-2" rows="6" placeholder="Hepatitis GPack|HEP/GPACK/100|real-time PCR|1 pc
Bloodborne GPack|BB/GPACK/100|real-time PCR|1 pc
GeneProof HBV Kit|16V/X5EX/X25|real-time PCR|25 reactions / 100 reactions">{{ old('order_table', $detail->order_table ? implode("\n", array_map(function($row) { return implode('|', $row); }, json_decode($detail->order_table, true))) : '') }}</textarea>
    <p class="mt-1 text-sm text-gray-500">
        Format: Product Name|REF|Technology|Packaging (one per line)<br>
        Example: Hepatitis GPack|HEP/GPACK/100|real-time PCR|1 pc
    </p>
</div>

        {{-- Brochure --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Brochure (PDF)</label>
            <input type="file" name="brochure" class="w-full border rounded px-3 py-2">
            @if($detail->brochure)
                <p class="mt-1 text-sm text-gray-500">
                    Current: <a href="{{ asset('storage/' . $detail->brochure) }}" target="_blank" class="text-blue-600 hover:underline">View Brochure</a>
                </p>
            @endif
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Image</label>
            <input type="file" name="image" class="w-full border rounded px-3 py-2">
            @if($detail->image)
                <p class="mt-1">
                    <img src="{{ asset('storage/' . $detail->image) }}" alt="Image" class="h-20 w-20 object-contain border">
                </p>
            @endif
        </div>

        {{-- Second Image --}}
<div class="mb-4">
    <label class="block font-medium mb-1">Second Image (Optional - appears after features)</label>
    <input type="file" name="second_image" class="w-full border rounded px-3 py-2">
    @if($detail->second_image)
        <p class="mt-1">
            <img src="{{ asset('storage/' . $detail->second_image) }}" alt="Second Image" class="h-20 w-20 object-contain border">
        </p>
    @endif
</div>

        {{-- SEO Fields --}}
        {{-- <div class="mb-4">
            <label class="block font-medium mb-1">Meta Title</label>
            <input type="text" name="meta_title" class="w-full border rounded px-3 py-2" value="{{ old('meta_title', $detail->meta_title) }}">
        </div> --}}

        {{-- <div class="mb-4">
            <label class="block font-medium mb-1">Meta Description</label>
            <textarea name="meta_description" class="w-full border rounded px-3 py-2" rows="3">{{ old('meta_description', $detail->meta_description) }}</textarea>
        </div> --}}

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Update Details
        </button>
    </form>

</div>
@endsection
