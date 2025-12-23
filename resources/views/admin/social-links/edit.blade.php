@extends('admin.layouts.app')


@section('title', 'Edit Social Link')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Edit Social Link</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('social-links.update', $socialLink->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="icon" class="block font-semibold mb-1">Icon</label>
            <input type="text" name="icon" id="icon" class="w-full border p-2 rounded" value="{{ old('icon', $socialLink->icon) }}" required>
            <small class="text-gray-500">E.g., f, in, ▶</small>
        </div>

        <div class="mb-4">
            <label for="url" class="block font-semibold mb-1">URL</label>
            <input type="url" name="url" id="url" class="w-full border p-2 rounded" value="{{ old('url', $socialLink->url) }}" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('social-links.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
