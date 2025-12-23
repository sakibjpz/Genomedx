@extends('admin.layouts.app')

@section('title', 'Menus')

@section('content')
<div class="container mx-auto p-4">

    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-bold">Menus</h1>
        <a href="{{ route('admin.menus.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Menu</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">Order</th>
                <th class="border px-4 py-2">Menu & Submenu</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="menu-list">
            @foreach($menus as $menu)
                <tr data-id="{{ $menu->id }}">
                    <td class="border px-4 py-2">{{ $menu->order }}</td>
                    <td class="border px-4 py-2">
                        <span class="font-semibold">{{ $menu->name }}</span>

                        {{-- Show submenus --}}
                        @if($menu->children->count() > 0)
                            <ul class="ml-6 mt-1 list-disc">
                                @foreach($menu->children as $child)
                                    <li>{{ $child->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td class="border px-4 py-2 flex space-x-2">
                        <a href="{{ route('admin.menus.edit', $menu->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
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

{{-- Optional: Add drag-and-drop reorder script later --}}

@endsection
