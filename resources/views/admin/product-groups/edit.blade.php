@extends('admin.layouts.app')



@section('content')
<div class="container mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Edit Product Group</h1>

    {{-- Success/Error Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white p-6 rounded shadow mb-8">
       <form method="POST" action="{{ route('admin.product-groups.update', $productGroup->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $productGroup->name) }}" class="w-full border rounded p-2" required>
                </div>

                {{-- Color --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Color</label>
                    <select name="color" class="w-full border rounded p-2">
                        @php
                            $colors = [
                                'red-500' => 'Red',
                                'green-500' => 'Green',
                                'blue-500' => 'Blue',
                                'orange-500' => 'Orange',
                                'purple-600' => 'Purple',
                                'cyan-500' => 'Cyan',
                                'lime-500' => 'Lime',
                                'amber-700' => 'Amber',
                                'gray-400' => 'Gray',
                            ];
                        @endphp
                        @foreach($colors as $key => $label)
                            <option value="{{ $key }}" {{ $productGroup->color == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Icon --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Icon</label>
                    <input type="file" name="icon" accept=".svg,.png" class="w-full border rounded p-2">
                    @if($productGroup->icon)
                        <img src="{{ asset('storage/'.$productGroup->icon) }}" alt="Icon" class="w-12 h-12 mt-2">
                    @endif
                </div>

                {{-- Position --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Position</label>
                    <input type="number" name="position" value="{{ old('position', $productGroup->position) }}" class="w-full border rounded p-2">
                </div>

                {{-- Company --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Company</label>
                    <select name="company_id" class="w-full border rounded p-2">
                        <option value="">-- No Company --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" 
                                {{ old('company_id', $productGroup->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="status" value="1" class="mr-2" {{ $productGroup->status ? 'checked' : '' }}>
                    <label>Active</label>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="flex space-x-3 mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Update Group
                </button>
                <a href="{{ route('admin.product-groups.index') }}" 
                   class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>
@endsection