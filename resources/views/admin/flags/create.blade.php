@extends('admin.layouts.app')


@section('title', 'Add Flag')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Add New Flag</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.flags.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="name" class="block font-semibold mb-1">Flag Name</label>
            <input type="text" name="name" id="name" class="w-full border p-2 rounded" value="{{ old('name') }}" required>
        </div>

        <div class="mb-4">
            <label for="image" class="block font-semibold mb-1">Flag Image</label>
            <input type="file" name="image" id="image" class="w-full border p-2 rounded" required>
            <small class="text-gray-500">Allowed: jpg, jpeg, png, svg</small>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
        <a href="{{ route('admin.flags.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
