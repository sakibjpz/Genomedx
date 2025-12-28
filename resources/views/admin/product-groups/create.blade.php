@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Create Product Group</h1>
    
    <form action="{{ route('admin.product-groups.store') }}" method="POST" id="productGroupForm">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Company *</label>
            <select name="company_id" class="border rounded px-3 py-2 w-full" required>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Name *</label>
            <input type="text" name="name" id="name" class="border rounded px-3 py-2 w-full" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Slug *</label>
            <input type="text" name="slug" id="slug" class="border rounded px-3 py-2 w-full bg-gray-50" readonly required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Color</label>
            <select name="color" class="border rounded px-3 py-2 w-full">
                <option value="blue-500">Blue</option>
                <option value="green-500">Green</option>
                <option value="red-500">Red</option>
                <option value="orange-500">Orange</option>
                <option value="purple-600">Purple</option>
            </select>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Position</label>
            <input type="number" name="position" class="border rounded px-3 py-2 w-full" value="1">
        </div>
        
        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="status" value="1" checked class="rounded">
                <span class="ml-2">Active</span>
            </label>
        </div>
        
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Create Product Group
        </button>
    </form>
</div>

<script>
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^\w\s]/g, '') // Remove special chars
        .replace(/\s+/g, '-')    // Replace spaces with hyphens
        .trim();
    document.getElementById('slug').value = slug;
});
</script>
@endsection