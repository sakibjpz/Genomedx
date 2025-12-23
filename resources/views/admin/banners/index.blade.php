@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Banners</h1>
        <a href="{{ route('admin.banners.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Banner</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Title</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Button</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($banners as $banner)
                <tr>
                    <td class="border px-4 py-2">{!! $banner->title !!}</td>
                    <td class="border px-4 py-2 text-center">
                        <img src="{{ asset('images/'.$banner->image) }}" alt="Banner" class="w-32 h-16 object-cover">
                    </td>
                    <td class="border px-4 py-2">
                        @if($banner->button_text)
                            <a href="{{ $banner->button_url }}" class="bg-orange-500 text-white px-2 py-1 rounded">{{ $banner->button_text }}</a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>

                        {{-- Delete button --}}
                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">
                                Delete
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
