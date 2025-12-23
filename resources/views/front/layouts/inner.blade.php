<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GeneProof Clone')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


  <style>
    /* ==========================================================================
       1. GLOBAL & BASE STYLES
       ========================================================================== */
    [x-cloak] { display: none !important; }

    body {
        font-family: 'Poppins', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    /* Standard Utilities */
    .border-3 { border-width: 3px; }

    /* ==========================================================================
       2. HEADER & NAVIGATION
       ========================================================================== */
    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .gp-logo img {
        width: 200px;
        height: auto;
    }

    .header-small-text {
        font-size: 15px;
    }

    /* Mega Menu Internal Scroll Fix */
    .mega-menu-scroll {
        max-height: calc(100vh - 200px);
        overscroll-behavior: contain;
        overflow-y: auto;
    }

    /* Header Responsive Breakpoints */
    @media (max-width: 1024px) {
        .gp-logo img { width: 160px; }
        .header-small-text { font-size: 10px; }
    }

    @media (max-width: 640px) {
        .gp-logo img { width: 120px; }
        .header-small-text { font-size: 8px; }
    }

    /* ==========================================================================
       3. MAIN CONTENT & HERO BANNER
       ========================================================================== */
    main {
        padding-top: 140px; /* Adjusted for double-row sticky header */
    }

    .gp-hero {
        height: 550px;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        text-align: center;
    }

    .gp-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.40);
    }

    .gp-hero-content {
        position: relative;
        z-index: 2;
        padding: 20px;
        opacity: 0;
        transform: translateY(20px);
        transition: all 1s ease-in-out;
    }

    .gp-hero-content.show {
        opacity: 1;
        transform: translateY(0);
    }

    .gp-hero h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    /* Animations */
    .gp-hero-content.show .banner-heading {
        animation: fadeSlideIn 1s ease forwards;
    }

    @keyframes fadeSlideIn {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Buttons */
    .gp-btn {
        display: inline-block;
        background: #ff5722;
        padding: 12px 24px;
        border-radius: 6px;
        color: #fff;
        font-weight: bold;
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .gp-btn:hover {
        transform: scale(1.1);
        background: #ff784e;
    }

    /* ==========================================================================
       4. SECTION SPECIFIC STYLES
       ========================================================================== */

    /* Molecular Diagnostics */
    .molecular-diagnostics-section * { -webkit-tap-highlight-color: transparent; }
    
    @media (max-width: 640px) {
        .molecular-diagnostics-section h1,
        .molecular-diagnostics-section h2 { line-height: 1.2; }
    }
    
    @media (max-width: 768px) {
        .molecular-diagnostics-section .cta-button {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    }

    /* Why Choose Section */
    .why-choose-section * { -webkit-tap-highlight-color: transparent; }
    .why-choose-section a { transition: all 0.3s ease; }
    .why-choose-section .rounded-full { transition: all 0.3s ease; }
    
    .why-choose-section .text-center:hover .rounded-full {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
    }

    @media (max-width: 768px) {
        .why-choose-section .distributor-cta-button {
            min-height: 60px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
    }

    /* Products Section */
    .geneproof-products-section * { -webkit-tap-highlight-color: transparent; }
    .product-card { transition: all 0.3s ease; }
    .product-card:hover { transform: translateY(-5px); }

    /* ==========================================================================
       5. FOOTER STYLES
       ========================================================================== */
    .geneproof-footer-section * { -webkit-tap-highlight-color: transparent; }
    .social-icon { transition: all 0.3s ease; }
    .social-icon:hover { box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); }
    .geneproof-footer-section a { transition: all 0.3s ease; }

    @media (max-width: 640px) {
        .geneproof-footer-section a[href^="tel"] {
            font-size: 2rem;
            word-break: break-all;
        }
    }

    @media (max-width: 768px) {
        .geneproof-footer-section, 
        .geneproof-footer-section .md\:text-right {
            text-align: center;
        }
    }
</style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body>

  {{-- Full Header --}}
  <header class="w-full">

        {{-- Top Row --}}
        <div class="w-full flex items-center justify-between px-12 py-5 bg-white">

            {{-- Left: Logo --}}
<div class="flex items-start space-x-3">
    <div class="gp-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Genomedx logo">
        </a>
    </div>
</div>

            {{-- Right: Icons & Links --}}
            <div class="flex items-center space-x-6">

                <a href="#" class="text-orange-500 font-medium header-small-text">e-Document finder</a>

             {{-- Social Icons --}}
<div class="flex items-center space-x-3">
    @foreach($socialLinks as $social)
        <a href="{{ $social->url }}"
           target="_blank"
           class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl header-small-text">
            <i class="{{ $social->icon }}"></i>
        </a>
    @endforeach
</div>


                <a href="{{ route('login') }}" class="text-blue-600 font-medium header-small-text mr-4">Login</a>
                <a href="{{ route('register') }}" class="text-blue-600 font-medium header-small-text">Register</a>

              <div class="flex items-center header-small-text">
    @foreach($flags as $index => $flag)
        <img src="{{ asset('storage/flags/'.$flag->image) }}" class="w-7 mx-1">
        @if($index < count($flags) - 1)
            <span>/</span>
        @endif
    @endforeach
</div>


            {{-- Search --}}
<form action="{{ route('products.search') }}" method="GET" class="flex items-center space-x-2 header-small-text">
    <input type="text" name="query" placeholder="Search product..." class="border rounded px-2 py-1" required>
    <button type="submit" class="w-9 h-9 flex items-center justify-center text-white text-xl ">
        🔍
    </button>
</form>


            </div>

        </div>
{{-- Bottom Navigation Row --}}
<div class="w-full bg-white shadow py-3 relative z-40"> {{-- relative & z-index are key here --}}
    <nav class="flex flex-nowrap justify-center gap-8 text-blue-700 font-semibold text-lg overflow-x-auto">
        @foreach($menus->where('parent_id', null)->sortBy('order') as $menu)
            {{-- PRODUCTS MEGA MENU --}}
            @if($menu->name === 'Products')
                @php
                    $productGroups = \App\Models\ProductGroup::withCount('products')
                        ->orderBy('position')
                        ->get();
                @endphp
                
                <div class="static" x-data="{ open: false }" 
                     @mouseenter="open = true" 
                     @mouseleave="open = false">
                    
                    {{-- Products Button --}}
                 <button class="hover:text-blue-900 font-semibold whitespace-nowrap"
        @click="open = !open" 
        @keydown.escape.window="open = false">
    Products
</button>

                    {{-- Mega Menu Dropdown --}}
                    {{-- Added: x-cloak, @wheel.stop, and better positioning --}}
                    <div x-show="open" x-transition x-cloak 
     class="absolute left-1/2 -translate-x-1/2 top-full mt-0 w-[1800px] max-w-[98vw] sm:max-w-full bg-white border rounded-b-lg shadow-2xl z-50 overflow-hidden">

                        {{-- INNER CONTAINER: This is where we fix the height --}}
                        {{-- max-h-[calc(100vh-180px)] ensures it fits on your screen even with a sticky header --}}
                        <div class="p-12 overflow-y-auto" 
                             style="max-height: calc(100vh - 180px); overscroll-behavior: contain;">
                            
                            {{-- Header --}}
                            <div class="mb-10">
                                <h3 class="text-3xl font-bold text-gray-800 whitespace-nowrap">All Product Groups</h3>
                            </div>
                            
                            @if($productGroups->count() > 0)
                                {{-- Your exact 3-column grid --}}
                                <div class="grid grid-cols-3 gap-x-32 gap-y-10">
                                    @foreach($productGroups as $group)
                                        <a href="{{ route('products.index', $group) }}"
                                           class="flex items-center justify-between hover:text-blue-600 transition-all duration-200 group hover:bg-blue-50 p-4 rounded-lg">
                                            
                                            <div class="flex-grow min-w-0 mr-8">
                                                <div class="text-xl font-semibold text-gray-800 group-hover:text-blue-600 whitespace-nowrap overflow-hidden text-ellipsis">
                                                    {{ $group->name }}
                                                </div>
                                            </div>
                                            
                                            @if($group->image || $group->icon || $group->image_path)
                                                <div class="w-12 h-12 flex-shrink-0">
                                                    @php
                                                        $path = $group->image ?? $group->icon ?? $group->image_path;
                                                        $isAsset = str_contains($path, 'assets/');
                                                    @endphp
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
                    </div>
                </div>

            {{-- OTHER PARENT MENUS --}}
         
@else
    <div class="relative" x-data="{ open: false }">
    <a href="{{ $menu->url ?? '#' }}" 
   class="hover:text-blue-900 whitespace-nowrap">
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
    </header>


    {{-- Main --}}
    <main>
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
