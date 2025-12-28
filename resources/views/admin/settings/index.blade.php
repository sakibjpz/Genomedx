@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Frontend Settings</h1>
    
    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg border border-green-300">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-3 text-green-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif
    
    {{-- Error Message --}}
    @if(session('error'))
        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg border border-red-300">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')
        
        <div class="bg-white p-6 rounded-lg shadow-md mb-6 border border-gray-200">
            <h2 class="text-lg font-semibold mb-4 text-gray-800">Product Groups Display</h2>
            
            <div class="mb-4">
                <label class="block text-sm font-medium mb-2 text-gray-700">
                    Show product groups from:
                </label>
                <select name="frontend_company_id" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Companies (Show everything)</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" 
                            {{ $selectedCompanyId == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-600 mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Select a company to show only their product groups, or leave empty to show all.
                </p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                <i class="fas fa-save mr-2"></i>
                Save Settings
            </button>
            
            <a href="{{ url('/') }}" target="_blank" 
               class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center">
                <i class="fas fa-eye mr-2"></i>
                View Frontend
            </a>
        </div>
    </form>
    
    {{-- Current Setting Display --}}
    <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <h3 class="text-md font-semibold mb-2 text-blue-800">
            <i class="fas fa-info-circle mr-2"></i>Current Setting
        </h3>
        <p class="text-gray-700">
            @if($selectedCompanyId)
                Currently showing product groups from: 
                <span class="font-semibold text-blue-600">
                    {{ \App\Models\Company::find($selectedCompanyId)->name ?? 'Selected Company' }}
                </span>
            @else
                Currently showing product groups from: 
                <span class="font-semibold text-blue-600">All Companies</span>
            @endif
        </p>
    </div>
</div>
@endsection