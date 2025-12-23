@extends('admin.layouts.app')


@section('title', 'Add Banner')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Add New Banner</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="title" class="block font-semibold mb-1">Banner Title</label>
            <textarea name="title" id="title" class="w-full border p-2 rounded" rows="3" required>{{ old('title') }}</textarea>
        </div>
        <div class="mb-4">
    <label for="subtitle" class="block font-semibold mb-1">Banner Subtitle</label>
    <textarea name="subtitle" id="subtitle" class="w-full border p-2 rounded" rows="2">{{ old('subtitle') }}</textarea>
</div>


        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Banner Image</label>
            <input type="file" name="image" id="image" class="w-full border p-2 rounded" required>
            <small class="text-gray-500">Allowed: jpg, jpeg, png, svg</small>
        </div>

        <div class="mb-4">
            <label for="button_text" class="block font-semibold mb-1">Button Text</label>
            <input type="text" name="button_text" id="button_text" class="w-full border p-2 rounded" value="{{ old('button_text') }}">
        </div>

        <div class="mb-4">
            <label for="button_url" class="block font-semibold mb-1">Button URL</label>
            <input type="url" name="button_url" id="button_url" class="w-full border p-2 rounded" value="{{ old('button_url') }}">
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
        <a href="{{ route('admin.banners.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
