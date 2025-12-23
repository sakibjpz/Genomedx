@extends('admin.layouts.app')


@section('title', 'Flags')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Flags</h1>
        <a href="{{ route('admin.flags.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Flag</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Image</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($flags as $flag)
                <tr>
                    <td class="border px-4 py-2">{{ $flag->name }}</td>
                    <td class="border px-4 py-2 text-center">
                        <img src="{{ asset('storage/flags/'.$flag->image) }}" alt="{{ $flag->name }}" class="w-10 h-6 object-cover inline-block">
                    </td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.flags.edit', $flag->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.flags.destroy', $flag->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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
