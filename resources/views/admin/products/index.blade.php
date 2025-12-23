@extends('admin.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-4">
        Products in: {{ $productGroup->name }}
    </h1>

    {{-- Add Product Form --}}
    <div class="bg-white shadow rounded p-4 mb-6">
        <form method="POST"
              action="{{ route('admin.product-groups.products.store', $productGroup) }}"
              enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Product Name --}}
                <div>
                    <label class="block font-medium">Product Name</label>
                    <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Product Image (Icon) --}}
                <div>
                    <label class="block font-medium">Product Image (Icon)</label>
                    <input type="file" name="image" class="w-full border rounded px-3 py-2" required>
                </div>

                {{-- Badge (Optional) --}}
                <div>
                    <label class="block font-medium">Badge (Optional)</label>
                    <input type="text" name="badge" class="w-full border rounded px-3 py-2" placeholder="e.g., NEW, BEST SELLER">
                </div>

                {{-- Position --}}
                <div>
                    <label class="block font-medium">Position</label>
                    <input type="number" name="position" class="w-full border rounded px-3 py-2" value="0">
                </div>

                {{-- Status --}}
                <div class="flex items-center mt-2">
                    <input type="checkbox" name="status" value="1" class="mr-2" checked>
                    <label>Active</label>
                </div>

            </div>

            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Add Product
            </button>
        </form>
    </div>

    {{-- Product List --}}
    <div class="bg-white shadow rounded p-4">
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Image</th>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Badge</th>
                    <th class="p-2 text-center">Status</th>
                    <th class="p-2 text-center">Position</th>
                    <th class="p-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products->sortBy('position') as $product)
                    <tr class="border-t">
                        <td class="p-2">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-contain">
                            @endif
                        </td>
                        <td class="p-2">{{ $product->name }}</td>
                        <td class="p-2">{{ $product->badge ?? '-' }}</td>
                        <td class="p-2 text-center">
                            {{ $product->status ? 'Active' : 'Inactive' }}
                        </td>
                        <td class="p-2 text-center">
                            {{ $product->position }}
                        </td>
                        <td class="p-2 text-center space-x-2">
                            {{-- Edit Product --}}
                            <a href="{{ route('admin.product-groups.products.edit', [$productGroup->id, $product->id]) }}"
                               class="text-blue-600 hover:underline">Edit</a>

                            {{-- Edit Product Details --}}
                            <a href="{{ route('admin.products.details.edit', $product->id) }}"
   class="text-green-600 hover:underline">Edit Details</a>

                            {{-- Delete Product --}}
                            <form action="{{ route('admin.product-groups.products.destroy', [$productGroup->id, $product->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-4 text-center text-gray-500">
                            No products yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
