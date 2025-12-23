@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">All Products by Group</h1>

    @forelse($groups as $group)
        <div class="mb-6 bg-white shadow rounded p-4">
            <h2 class="text-xl font-semibold mb-2">{{ $group->name }}</h2>

            @if($group->products->count() > 0)
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
                        @foreach($group->products->sortBy('position') as $product)
                            <tr class="border-t">
                                <td class="p-2">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-10 w-10 object-contain">
                                    @endif
                                </td>
                                <td class="p-2">{{ $product->name }}</td>
                                <td class="p-2">{{ $product->badge ?? '-' }}</td>
                                <td class="p-2 text-center">{{ $product->status ? 'Active' : 'Inactive' }}</td>
                                <td class="p-2 text-center">{{ $product->position }}</td>
                                <td class="p-2 text-center space-x-2">
                                    <a href="{{ route('admin.product-groups.products.edit', [$group->id, $product->id]) }}"
                                       class="text-blue-600 hover:underline">Edit</a>

                                    {{-- <a href="{{ route('admin.products.details.edit', $product->id) }}"
                                       class="text-green-600 hover:underline">Edit Details</a> --}}

                                    <form action="{{ route('admin.product-groups.products.destroy', [$group->id, $product->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 mt-2">No products in this group.</p>
            @endif
        </div>
    @empty
        <p class="text-gray-500">No product groups found.</p>
    @endforelse

</div>
@endsection
