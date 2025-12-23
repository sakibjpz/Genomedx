@extends('admin.layouts.app')


@section('title', 'Edit Flag')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Edit Flag</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.flags.update', $flag->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Flag Name</label>
            <input type="text" name="name" id="name" class="w-full border p-2 rounded" value="{{ old('name', $flag->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Flag Image</label>
            <input type="file" name="image" id="image" class="w-full border p-2 rounded">
            @if($flag->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/flags/'.$flag->image) }}" alt="{{ $flag->name }}" class="w-20 h-12 object-cover">
                </div>
            @endif
            <small class="text-gray-500">Leave blank to keep current image</small>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('admin.flags.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
