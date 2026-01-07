@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Edit Team Member</h1>
        <a href="{{ route('admin.team-members.index') }}" 
           class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
            ← Back to List
        </a>
    </div>

    <div class="bg-white rounded shadow p-6 max-w-4xl">
        <form action="{{ route('admin.team-members.update', $teamMember) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Name *</label>
                        <input type="text" name="name" value="{{ old('name', $teamMember->name) }}" 
                               class="w-full border rounded p-2" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Position *</label>
                        <input type="text" name="position" value="{{ old('position', $teamMember->position) }}" 
                               class="w-full border rounded p-2" required>
                        @error('position')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Regions *</label>
                        <textarea name="regions" rows="3" class="w-full border rounded p-2" required>{{ old('regions', $teamMember->regions) }}</textarea>
                        @error('regions')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $teamMember->email) }}" 
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
                        <input type="text" name="phone" value="{{ old('phone', $teamMember->phone) }}" 
                               class="w-full border rounded p-2" required>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Profile Image</label>
                        @if($teamMember->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $teamMember->image) }}" 
                                     alt="{{ $teamMember->name }}" 
                                     class="w-20 h-20 rounded-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" 
                               class="w-full border rounded p-2">
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Order</label>
                        <input type="number" name="order" value="{{ old('order', $teamMember->order) }}" 
                               class="w-full border rounded p-2">
                        @error('order')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="status" value="1" 
                               {{ old('status', $teamMember->status) ? 'checked' : '' }}
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
                    Update Team Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection