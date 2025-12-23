@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">
        Add Product to "{{ $productGroup->name }}"
    </h1>

    {{-- Display validation errors --}}
    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow">
       <form method="POST" action="{{ route('admin.product-groups.products.store', $productGroup->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Product Name --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded p-2" required>
                </div>

                {{-- Product Image (icon) --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Product Image (Icon)</label>
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.svg" class="w-full border rounded p-2" required>
                </div>

                {{-- Badge (optional text) --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Badge (Optional)</label>
                    <input type="text" name="badge" value="{{ old('badge') }}" class="w-full border rounded p-2" placeholder="e.g., NEW, BEST SELLER">
                </div>

                {{-- Position --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Position</label>
                    <input type="number" name="position" value="{{ old('position', 0) }}" class="w-full border rounded p-2">
                </div>

                {{-- Status --}}
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="status" value="1" class="mr-2" checked>
                    <label>Active</label>
                </div>

            </div>

            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Add Product
            </button>
        </form>
    </div>

</div>
@endsection
