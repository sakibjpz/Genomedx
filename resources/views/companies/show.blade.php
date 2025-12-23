@extends('admin.layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800">{{ $company->name }}</h1>
    <p class="text-gray-600 mt-2">Company page loaded successfully!</p>
</div>
@endsection