@extends('admin.layouts.app')


@section('title', 'Social Links')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Social Links</h1>
        <a href="{{ route('admin.social-links.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Social Link</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Icon</th>
                <th class="border px-4 py-2">URL</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($socialLinks as $link)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $link->icon }}</td>
                    <td class="border px-4 py-2">{{ $link->url }}</td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.social-links.edit', $link->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.social-links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
