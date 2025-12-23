@extends('admin.layouts.app')

@section('title', 'Add Menu')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Add New Menu</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf

        {{-- Menu Name --}}
        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700">Menu Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Parent Menu (for submenu) --}}
        <div class="mb-4">
            <label for="parent_id" class="block font-medium text-gray-700">Parent Menu (optional)</label>
            <select name="parent_id" id="parent_id" class="w-full border rounded px-3 py-2">
                <option value="">-- Top-level Menu --</option>
                @foreach($menus->where('parent_id', null) as $menu)
                    <option value="{{ $menu->id }}" {{ old('parent_id') == $menu->id ? 'selected' : '' }}>
                        {{ $menu->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Order --}}
        <div class="mb-4">
            <label for="order" class="block font-medium text-gray-700">Order</label>
            <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label for="status" class="block font-medium text-gray-700">Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                <option value="1" {{ old('status',1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Menu</button>
        <a href="{{ route('admin.menus.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>
@endsection
