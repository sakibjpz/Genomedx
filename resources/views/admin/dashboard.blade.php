@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    {{-- Total Menus --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 font-semibold">Menus</h3>
        <p class="text-2xl font-bold mt-2">{{ $menusCount ?? 0 }}</p>
    </div>

    {{-- Total Social Links --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 font-semibold">Social Links</h3>
        <p class="text-2xl font-bold mt-2">{{ $socialLinksCount ?? 0 }}</p>
    </div>

    {{-- Total Flags --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 font-semibold">Flags</h3>
        <p class="text-2xl font-bold mt-2">{{ $flagsCount ?? 0 }}</p>
    </div>

    {{-- Total Banners --}}
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-gray-500 font-semibold">Banners</h3>
        <p class="text-2xl font-bold mt-2">{{ $bannersCount ?? 0 }}</p>
    </div>

</div>
@endsection
