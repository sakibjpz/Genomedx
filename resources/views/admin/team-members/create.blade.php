@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Add Team Member</h1>
        <a href="{{ route('admin.team-members.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            ← Back to List
        </a>
    </div>

    <div class="bg-white rounded shadow p-6 max-w-4xl">
        <form action="{{ route('admin.team-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full border rounded p-2" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Position *</label>
                        <input type="text" name="position" value="{{ old('position') }}" 
                               class="w-full border rounded p-2" required>
                        @error('position')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Regions *</label>
                        <textarea name="regions" rows="3" class="w-full border rounded p-2" required>{{ old('regions') }}</textarea>
                        <p class="text-gray-500 text-xs mt-1">Example: Africa | CIS | West EU | Greece | Cyprus</p>
                        @error('regions')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" 
                               class="w-full border rounded p-2" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" 
                               class="w-full border rounded p-2" required>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Profile Image</label>
                        <input type="file" name="image" accept="image/*" 
                               class="w-full border rounded p-2">
                        <p class="text-gray-500 text-xs mt-1">Recommended: 300x300px, square image</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Order</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" 
                               class="w-full border rounded p-2">
                        @error('order')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="status" value="1" 
                               {{ old('status', true) ? 'checked' : '' }}
                               class="mr-2">
                        <label>Active</label>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t flex justify-end space-x-4">
                <a href="{{ route('admin.team-members.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Save Team Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection