@extends('admin.layouts.app')

@section('title', 'Edit Menu')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Edit Menu</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Parent Menu --}}
        <div class="mb-6 border p-4 rounded">
            <h2 class="text-lg font-semibold mb-2">Parent Menu</h2>

            {{-- Menu Name --}}
            <div class="mb-2">
                <label class="block font-medium text-gray-700">Menu Name</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="w-full border rounded px-3 py-2">
            </div>

            {{-- Order --}}
            <div class="mb-2">
                <label class="block font-medium text-gray-700">Order</label>
                <input type="number" name="order" value="{{ old('order', $menu->order) }}" class="w-full border rounded px-3 py-2">
            </div>

            {{-- Status --}}
            <div class="mb-2">
                <label class="block font-medium text-gray-700">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2">
                    <option value="1" {{ old('status', $menu->status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $menu->status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        {{-- Submenus --}}
        @if($menu->children->count() > 0)
            @foreach($menu->children as $child)
                <div class="mb-4 ml-8 border-l-4 border-gray-300 pl-4 p-2 rounded">
                    <h3 class="font-medium mb-2">Submenu of "{{ $menu->name }}"</h3>

                    {{-- Submenu Name --}}
                    <div class="mb-2">
                        <label class="block font-medium text-gray-700">Submenu Name</label>
                        <input type="text" name="children[{{ $child->id }}][name]" value="{{ old('children.'.$child->id.'.name', $child->name) }}" class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Order --}}
                    <div class="mb-2">
                        <label class="block font-medium text-gray-700">Order</label>
                        <input type="number" name="children[{{ $child->id }}][order]" value="{{ old('children.'.$child->id.'.order', $child->order) }}" class="w-full border rounded px-3 py-2">
                    </div>

                    {{-- Status --}}
                    <div class="mb-2">
                        <label class="block font-medium text-gray-700">Status</label>
                        <select name="children[{{ $child->id }}][status]" class="w-full border rounded px-3 py-2">
                            <option value="1" {{ old('children.'.$child->id.'.status', $child->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('children.'.$child->id.'.status', $child->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            @endforeach
        @endif

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-4">Update Menu</button>
        <a href="{{ route('admin.menus.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
