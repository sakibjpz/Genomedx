@extends('admin.layouts.app')

@section('title', 'Add Social Link')

@section('content')
<div class="container mx-auto p-4">

    <h1 class="text-2xl font-bold mb-4">Add New Social Link</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-2 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.social-links.store') }}" method="POST">
        @csrf

        {{-- Icon Picker --}}
        <div class="mb-4">
            <label class="block font-semibold mb-2">Select Icon</label>
            
            <div class="flex flex-wrap gap-2 mb-2">
                @php
                    $icons = [
                        'fab fa-facebook-f' => 'Facebook',
                        'fab fa-twitter' => 'Twitter',
                        'fab fa-linkedin-in' => 'LinkedIn',
                        'fab fa-youtube' => 'YouTube',
                        'fab fa-instagram' => 'Instagram',
                    ];
                @endphp

                @foreach($icons as $class => $name)
                    <button type="button"
                            class="icon-btn border p-2 rounded text-gray-600 hover:text-blue-600"
                            data-icon="{{ $class }}">
                        <i class="{{ $class }} fa-lg"></i>
                    </button>
                @endforeach
            </div>

            <input type="hidden" name="icon" id="icon" value="{{ old('icon') }}">
            <small class="text-gray-500">Click an icon to select it</small>
        </div>

        <div class="mb-4">
    <label for="platform" class="block font-semibold mb-1">Platform</label>
    <select name="platform" id="platform" class="w-full border p-2 rounded" required>
        <option value="">-- Select Platform --</option>
        <option value="Facebook" {{ old('platform') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
        <option value="Twitter" {{ old('platform') == 'Twitter' ? 'selected' : '' }}>Twitter</option>
        <option value="LinkedIn" {{ old('platform') == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
        <option value="YouTube" {{ old('platform') == 'YouTube' ? 'selected' : '' }}>YouTube</option>
        <option value="Instagram" {{ old('platform') == 'Instagram' ? 'selected' : '' }}>Instagram</option>
    </select>
</div>


        {{-- URL --}}
        <div class="mb-4">
            <label for="url" class="block font-semibold mb-1">URL</label>
            <input type="url" name="url" id="url" class="w-full border p-2 rounded" value="{{ old('url') }}" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create</button>
        <a href="{{ route('admin.social-links.index') }}" class="ml-2 px-4 py-2 rounded border">Cancel</a>
    </form>

</div>

{{-- Icon Picker Script --}}
<script>
    const buttons = document.querySelectorAll('.icon-btn');
    const iconInput = document.getElementById('icon');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active classes from all buttons
            buttons.forEach(b => b.classList.remove('bg-blue-100', 'border-blue-500'));
            
            // Add active class to clicked button
            btn.classList.add('bg-blue-100', 'border-blue-500');

            // Set hidden input value
            iconInput.value = btn.getAttribute('data-icon');
        });

        // Pre-select if old value exists
        if(iconInput.value === btn.getAttribute('data-icon')) {
            btn.classList.add('bg-blue-100', 'border-blue-500');
        }
    });
</script>
@endsection
