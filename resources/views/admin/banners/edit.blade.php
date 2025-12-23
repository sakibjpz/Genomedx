@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Edit Banner</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-4">
            <label for="title" class="block font-semibold mb-1">Banner Title</label>
            <textarea name="title" id="title" class="w-full border p-2 rounded" rows="3" required>{{ old('title', $banner->title) }}</textarea>
        </div>

        {{-- Subtitle --}}
        <div class="mb-4">
            <label for="subtitle" class="block font-semibold mb-1">Banner Subtitle</label>
            <textarea name="subtitle" id="subtitle" class="w-full border p-2 rounded" rows="2">{{ old('subtitle', $banner->subtitle) }}</textarea>
        </div>

        {{-- Image --}}
        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Banner Image</label>
            <input type="file" name="image" id="image" class="w-full border p-2 rounded">
            @if($banner->image)
                <div class="mt-2">
                    <img src="{{ asset('images/'.$banner->image) }}" alt="Banner" class="w-48 h-24 object-cover rounded border">
                </div>
            @endif
            <small class="text-gray-500">Leave blank to keep current image. Allowed: jpg, jpeg, png, svg</small>
        </div>

        {{-- Button Text --}}
        <div class="mb-4">
            <label for="button_text" class="block font-semibold mb-1">Button Text</label>
            <input type="text" name="button_text" id="button_text" class="w-full border p-2 rounded" value="{{ old('button_text', $banner->button_text) }}">
        </div>

        {{-- Button URL --}}
        <div class="mb-4">
            <label for="button_url" class="block font-semibold mb-1">Button URL</label>
            <input type="url" name="button_url" id="button_url" class="w-full border p-2 rounded" value="{{ old('button_url', $banner->button_url) }}">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('admin.banners.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
