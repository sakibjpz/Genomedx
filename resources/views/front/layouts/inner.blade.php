
@php
    // Ensure $companies is always available for mega menu
    if (!isset($companies)) {
        $companies = \App\Models\Company::where('is_active', true)
            ->withCount('activeProductGroups')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover">
    <title>@yield('title', 'Genenomedx')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/custom.css', 'resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="relative">

  {{-- Full Header --}}
  <header class="w-full" x-data="{ mobileMenuOpen: false }">

        {{-- Top Row --}}
        <div class="w-full flex items-center justify-between px-4 md:px-12 py-3 md:py-5 bg-white">

          {{-- Left: Logo --}}
<div class="flex items-center space-x-3">
    <div class="gp-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Genomedx logo" 
                 style="width: auto; height: 50px; max-width: none !important;">
        </a>
    </div>
</div>

            {{-- Desktop: Icons & Links - Show on lg screens and above --}}
            <div class="hidden lg:flex items-center space-x-4 xl:space-x-6">

                {{-- <a href="#" class="text-orange-500 font-medium header-small-text hidden xl:inline">e-Document finder</a> --}}

                {{-- Social Icons --}}
                <div class="flex items-center space-x-3">
                    @foreach($socialLinks as $social)
                        <a href="{{ $social->url }}"
                           target="_blank"
                           class="w-8 h-8 xl:w-9 xl:h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm xl:text-base header-small-text">
                            <i class="{{ $social->icon }}"></i>
                        </a>
                    @endforeach
                </div>

                <div class="flex items-center text-blue-600 font-medium header-small-text">
                    <a href="{{ route('login') }}">Login</a>
                    <span class="mx-1 text-gray-500">/</span>
                    <a href="{{ route('register') }}">Register</a>
                </div>

                <div class="flex items-center header-small-text">
                    @foreach($flags as $index => $flag)
                        <img src="{{ asset('storage/flags/'.$flag->image) }}" class="w-6 xl:w-7 mx-1">
                        @if($index < count($flags) - 1)
                            <span>/</span>
                        @endif
                    @endforeach
                </div>

                {{-- Search --}}
                <form action="{{ route('products.search') }}" method="GET" class="flex items-center space-x-2 header-small-text">
                    <input type="text" name="query" placeholder="Search..." class="border rounded px-2 py-1 text-sm w-32 xl:w-40" required>
                    <button type="submit" class="w-8 h-8 xl:w-9 xl:h-9 flex items-center justify-center bg-blue-600 text-white rounded">
                        🔍
                    </button>
                </form>

            </div>

            {{-- Mobile Menu Toggle - Only show on screens smaller than lg (1024px) --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="lg:hidden text-blue-700 text-2xl p-2 focus:outline-none z-50">
                <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'"></i>
            </button>

        </div>

       {{-- Desktop Navigation Row - Show on lg screens and above --}}
        <div class="hidden lg:block w-full bg-white shadow py-3 relative z-40">
            <nav class="flex flex-nowrap justify-center gap-6 xl:gap-8 text-blue-700 font-semibold text-base xl:text-lg overflow-x-auto px-4">
                {{-- ADD THIS: Home Menu --}}
        <div class="relative">
            <a href="{{ url('/') }}" 
               class="hover:text-blue-900 whitespace-nowrap py-2 block">
               Home
            </a>
        </div>
                @foreach($menus->where('parent_id', null)->sortBy('order') as $menu)
                    @if($menu->name === 'Products')
                        {{-- PRODUCTS MEGA MENU WITH COMPANIES --}}
                        <div class="static products-mega-menu" x-data="{ 
                            open: false,
                            selectedCompany: null
                        }">
                            
                            {{-- Products Button --}}
                            <button class="hover:text-blue-900 font-semibold whitespace-nowrap py-2 relative z-50"
                                @click="open = !open" 
                                @mouseenter="open = true"
                                @keydown.escape.window="open = false; selectedCompany = null;">
                                Products
                            </button>

                            {{-- Mega Menu Dropdown --}}
                            <div x-show="open" 
                                x-transition
                                x-cloak
                                @mouseenter="open = true"
                                @mouseleave="open = false"
                                class="mega-dropdown absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[800px] max-w-[90vw] bg-white border rounded-b-lg shadow-2xl z-50 overflow-hidden"
                                style="margin-top: 2px !important;">
                                
                                <div class="flex min-h-[400px]">
                                    
                                    {{-- Left Column: Companies List --}}
                                    <div class="w-[40%] border-r bg-gray-50 p-6 overflow-y-auto" style="max-height: 70vh;">
                                        <h3 class="text-xl font-bold text-gray-800 mb-6">Select Company</h3>
                                        
                                        <div class="space-y-2">
                                            @foreach($companies as $company)
                                                <button 
                                                    @click="selectedCompany = {{ $company->id }}"
                                                    @mouseenter="selectedCompany = {{ $company->id }}"
                                                    :class="{
                                                        'bg-blue-600 text-white': selectedCompany == {{ $company->id }},
                                                        'hover:bg-blue-100': selectedCompany != {{ $company->id }}
                                                    }"
                                                    class="w-full text-left p-4 rounded-lg transition-all duration-200 flex items-center justify-between">
                                                    
                                                  <div class="flex items-center gap-3">
    {{-- Company Logo --}}
    <img
        src="{{ $company->image
            ? asset('storage/' . $company->image)
            : asset('assets/images/company-placeholder.png') }}"
        alt="{{ $company->name }}"
        class="w-10 h-10 flex-shrink-0 object-contain rounded bg-white transition-transform duration-200 group-hover:scale-105"
    >

    {{-- Company Info --}}
    <div class="flex-1">
        <div class="font-semibold text-gray-800">
            {{ $company->name }}
        </div>
        <div class="text-sm text-gray-600 mt-1">
            {{ $company->active_product_groups_count }} product groups
        </div>
    </div>
</div>
                                                    
                                                    <i class="fas fa-chevron-right text-sm"></i>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    {{-- Right Column: Product Groups of Selected Company --}}
                                    <div class="w-2/3 p-6 overflow-y-auto" style="max-height: 70vh;">
                                        <template x-if="selectedCompany">
                                            <div>
                                                @foreach($companies as $company)
                                                    <div x-show="selectedCompany == {{ $company->id }}">
                                                        <div class="flex items-center justify-between mb-6">
                                                            <h3 class="text-2xl font-bold text-gray-800">
                                                                {{ $company->name }} Products
                                                            </h3>
                                                            <a href="{{ route('companies.show', $company) }}" 
                                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                                View All →
                                                            </a>
                                                        </div>
                                                        
                                                        @if($company->activeProductGroups->count() > 0)
                                                            <div class="grid grid-cols-1 gap-3">
                                                                @foreach($company->activeProductGroups as $group)
                                                                    <a href="{{ route('products.index', $group->slug) }}"
                                                                       class="flex items-center justify-between hover:text-blue-600 transition-all duration-200 group hover:bg-blue-50 p-4 rounded-lg">
                                                                        
                                                                        <div class="flex-grow min-w-0 mr-8">
                                                                            <div class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 whitespace-nowrap overflow-hidden text-ellipsis">
                                                                                {{ $group->name }}
                                                                            </div>
                                                                            <div class="text-sm text-gray-600 mt-1">
                                                                                {{ $group->products_count }} products
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        @if($group->image || $group->icon || $group->image_path)
                                                                            @php
                                                                                $path = $group->image ?? $group->icon ?? $group->image_path;
                                                                                $isAsset = str_contains($path, 'assets/');
                                                                            @endphp
                                                                            <div class="w-12 h-12 flex-shrink-0">
                                                                                <img src="{{ $isAsset ? asset($path) : asset('storage/' . $path) }}" 
                                                                                     alt="{{ $group->name }}"
                                                                                     class="w-full h-full object-contain">
                                                                            </div>
                                                                        @endif
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <div class="text-center py-12 text-gray-500">
                                                                <div class="text-4xl mb-3">📦</div>
                                                                <div class="text-lg">No product groups available</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </template>
                                        
                                        {{-- Default view when no company selected --}}
                                        <template x-if="!selectedCompany">
                                            <div class="h-full flex flex-col items-center justify-center text-gray-500">
                                                <div class="text-5xl mb-4">🏢</div>
                                                <h3 class="text-2xl font-bold mb-2">Select a Company</h3>
                                                <p class="text-gray-600">Choose a company from the left to view their products</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- OTHER PARENT MENUS --}}
                        <div class="relative" x-data="{ open: false }">
                            <a href="{{ $menu->url ?? '#' }}" 
                               class="hover:text-blue-900 whitespace-nowrap py-2 block">
                               {{ $menu->name }}
                            </a>

                            @if($menu->children->count() > 0)
                                <div x-show="open" x-transition
                                     class="absolute left-0 top-full mt-2 w-56 bg-white border rounded-lg shadow-lg z-50 py-2">
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url ?? '#' }}" 
                                           class="block px-5 py-3 text-gray-700 hover:text-blue-600 hover:bg-gray-50 whitespace-nowrap">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </nav>
        </div>

       {{-- Mobile Menu - Show on screens smaller than lg (1024px) --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform translate-x-full"
             x-transition:enter-end="opacity-100 transform translate-x-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-x-0"
             x-transition:leave-end="opacity-0 transform translate-x-full"
             @click.away="mobileMenuOpen = false"
             class="lg:hidden fixed inset-0 bg-white z-40 overflow-y-auto pt-20"
             style="display: none;">
            
            <div class="px-6 py-6 space-y-6">
                
                {{-- Search Mobile --}}
                <form action="{{ route('products.search') }}" method="GET" class="flex items-center space-x-2 pb-4 border-b">
                    <input type="text" name="query" placeholder="Search product..." class="border rounded px-3 py-2 flex-1" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                        🔍
                    </button>
                </form>

                {{-- Navigation Links --}}
                <nav class="space-y-4">
                     {{-- ADD THIS: Home Menu for Mobile --}}
            <a href="{{ url('/') }}" 
               class="block text-blue-700 font-semibold text-lg py-2">
               Home
            </a>
                    @foreach($menus->where('parent_id', null)->sortBy('order') as $menu)
                        
                       @if($menu->name === 'Products')
    <div x-data="{ productsOpen: false }">
        <button @click="productsOpen = !productsOpen" 
                class="w-full flex items-center justify-between text-blue-700 font-semibold text-lg py-2">
            Products
            <i class="fas fa-chevron-down transition-transform" :class="productsOpen && 'rotate-180'"></i>
        </button>
        
        <div x-show="productsOpen" x-collapse class="mt-2 space-y-4">
            {{-- Companies List for Mobile --}}
            @foreach($companies as $company)
                <div x-data="{ companyOpen: false }" class="border rounded-lg overflow-hidden">
                    {{-- Company Header with Logo --}}
                    <button @click="companyOpen = !companyOpen" 
                            class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100">
                        <div class="flex items-center gap-3">
                            {{-- Company Logo --}}
                            <img
                                src="{{ $company->image
                                    ? asset('storage/' . $company->image)
                                    : asset('assets/images/company-placeholder.png') }}"
                                alt="{{ $company->name }}"
                                class="w-10 h-10 object-contain rounded bg-white"
                            >
                            {{-- Company Name --}}
                            <div class="text-left">
                                <div class="font-semibold text-gray-800">
                                    {{ $company->name }}
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $company->active_product_groups_count }} product groups
                                </div>
                            </div>
                        </div>
                        <i class="fas fa-chevron-down transition-transform" :class="companyOpen && 'rotate-180'"></i>
                    </button>
                    
                    {{-- Company's Product Groups --}}
                    <div x-show="companyOpen" x-collapse class="bg-white border-t">
                        <div class="p-4">
                            @if($company->activeProductGroups->count() > 0)
                                <div class="space-y-3">
                                    @foreach($company->activeProductGroups as $group)
                                        <a href="{{ route('products.index', $group->slug) }}"
                                           class="flex items-center justify-between py-3 px-2 hover:bg-blue-50 rounded-lg group">
                                            <div class="flex-grow">
                                                <div class="font-medium text-gray-800 group-hover:text-blue-600">
                                                    {{ $group->name }}
                                                </div>
                                                <div class="text-sm text-gray-600 mt-1">
                                                    {{ $group->products_count }} products
                                                </div>
                                            </div>
                                            @if($group->image || $group->icon || $group->image_path)
                                                @php
                                                    $path = $group->image ?? $group->icon ?? $group->image_path;
                                                    $isAsset = str_contains($path, 'assets/');
                                                @endphp
                                                <div class="w-10 h-10 flex-shrink-0 ml-3">
                                                    <img src="{{ $isAsset ? asset($path) : asset('storage/' . $path) }}" 
                                                         alt="{{ $group->name }}"
                                                         class="w-full h-full object-contain">
                                                </div>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4 text-gray-500">
                                    <div class="text-3xl mb-2">📦</div>
                                    <div>No product groups available</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
                            <div x-data="{ submenuOpen: false }">
                                @if($menu->children->count() > 0)
                                    <button @click="submenuOpen = !submenuOpen" 
                                            class="w-full flex items-center justify-between text-blue-700 font-semibold text-lg py-2">
                                        {{ $menu->name }}
                                        <i class="fas fa-chevron-down transition-transform" :class="submenuOpen && 'rotate-180'"></i>
                                    </button>
                                    
                                    <div x-show="submenuOpen" x-collapse class="pl-4 mt-2 space-y-2">
                                        @foreach($menu->children as $child)
                                            <a href="{{ $child->url ?? '#' }}" 
                                               class="block py-2 text-gray-700 hover:text-blue-600">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <a href="{{ $menu->url ?? '#' }}" 
                                       class="block text-blue-700 font-semibold text-lg py-2">
                                        {{ $menu->name }}
                                    </a>
                                @endif
                            </div>
                        @endif
                        
                    @endforeach
                </nav>

                {{-- Mobile Actions --}}
                <div class="pt-4 border-t space-y-4">
                    {{-- <a href="#" class="block text-orange-500 font-medium py-2">e-Document finder</a> --}}
                    
                    {{-- <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-blue-600 font-medium">Login</a>
                        <span class="text-gray-500">/</span>
                        <a href="{{ route('register') }}" class="text-blue-600 font-medium">Register</a>
                    </div> --}}

                    {{-- Social Icons Mobile --}}
                    <div class="flex items-center space-x-3">
                        @foreach($socialLinks as $social)
                            <a href="{{ $social->url }}"
                               target="_blank"
                               class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl">
                                <i class="{{ $social->icon }}"></i>
                            </a>
                        @endforeach
                    </div>

                    {{-- Flags Mobile --}}
                    {{-- <div class="flex items-center space-x-2">
                        @foreach($flags as $index => $flag)
                            <img src="{{ asset('storage/flags/'.$flag->image) }}" class="w-8">
                            @if($index < count($flags) - 1)
                                <span>/</span>
                            @endif
                        @endforeach
                    </div> --}}
                </div>

            </div>
        </div>

    </header>

    {{-- Main Content with Proper Spacing --}}
    <main class="header-spacer pt-4">
        @yield('content')
    </main>

  
    {{-- Footer (simple) --}}
  <footer class="bg-gray-900 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Company Information -->
            <div class="space-y-4">
                <div>
                    <h3 class="text-xl font-bold text-white mb-3">
                        GenomeDX Corporation
                    </h3>
                    <address class="not-italic text-gray-300 text-sm leading-relaxed">
                        205/1 (1st Floor)<br>
                        Dr.Kudrat-E-Khuda Road<br>
                        Dhaka-1205, Bangladesh
                    </address>
                </div>
                
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8l8 5 8-5v10zm-8-7L4 6h16l-8 5z"/>
                        </svg>
                        <a href="mailto:genomedxcorporation@gmail.com" class="text-sm text-gray-300 hover:text-white transition">
                            genomedxcorporation@gmail.com
                        </a>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 15.5c-1.2 0-2.3-.3-3.3-.8-.1-.1-.3-.1-.4 0l-2.5 1.5c-2.1-1.2-3.8-2.9-5-5l1.5-2.5c.1-.1.1-.3 0-.4-.5-1-.8-2.1-.8-3.3C9 4 10 3 11.2 3h1.5c1.1 0 2 .9 2 2 0 2.6.9 5 2.5 6.9.4.5.8 1 1.2 1.5.4.5.7 1 .9 1.5.3.8-.2 1.6-1 1.6h-1.5z"/>
                        </svg>
                        <a href="tel:+88029664349" class="text-sm text-gray-300 hover:text-white transition">
                            +880 2966 4349
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white mb-3">Quick Links</h4>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-sm text-gray-300 hover:text-white transition">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-gray-300 hover:text-white transition">
                            Our Services
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-gray-300 hover:text-white transition">
                            Contact Us
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-gray-300 hover:text-white transition">
                            Privacy Policy
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-gray-300 hover:text-white transition">
                            Terms of Service
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Contact & Social -->
            <div class="space-y-4">
                <h4 class="text-lg font-semibold text-white mb-3">Get in Touch</h4>
                <p class="text-sm text-gray-300 mb-4">
                    Have questions about our genomic services? Contact our team for expert consultation.
                </p>
                
                <div class="flex space-x-3">
                    <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    
                    <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                    
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" 
                       class="w-8 h-8 bg-gray-800 rounded-full flex items-center justify-center hover:bg-red-600 transition">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-8 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-sm text-gray-400 mb-4 md:mb-0">
                    © 2024 GenomeDX Corporation. All rights reserved.
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="https://www.genomedxbd.com" target="_blank" rel="noopener noreferrer" 
                       class="text-sm text-gray-300 hover:text-white transition">
                        www.genomedxbd.com
                    </a>
                    <span class="text-gray-600">|</span>
                    <span class="text-xs text-gray-500">
                        GPS: 41.82183, -0.77329
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
