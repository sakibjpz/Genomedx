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


           <div class="flex items-center text-blue-600 font-medium header-small-text">
    <a href="{{ route('login') }}">Login</a>
    <span class="mx-1 text-gray-500">/</span>
    <a href="{{ route('register') }}">Register</a>
</div>




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
    <button type="submit" class="w-9 h-9 flex items-center justify-center text-white text-xl">
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

    {{-- Molecular Diagnostics Section --}}
<section class="molecular-diagnostics-section bg-gray-50 py-8 sm:py-12 md:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-8 sm:mb-10 md:mb-12">
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-4 sm:mb-5 md:mb-6 px-2">
                Molecular diagnostics for your routine
            </h1>
            <p class="text-base sm:text-lg text-gray-600 max-w-4xl mx-auto mb-3 sm:mb-4 px-4">
                GeneProof is the biotechnological company providing customers with technologically advanced solutions in the field of molecular <em>in vitro</em> diagnostics of serious infections and genetic diseases.
            </p>
        </div>

        <!-- Company Info -->
        <div class="text-center mb-6 sm:mb-8 px-4">
            <p class="text-sm sm:text-base text-gray-700 mb-3 sm:mb-4">
                The company was founded in 2005 in the Czech Republic, a member of the European Union.
            </p>
            <p class="text-sm sm:text-base text-gray-700">
                In 2022, GeneProof merged with American Laboratory Products Company to create global market leader in the diagnostic product market. GeneProof, partnered with ALPCO, is now a leading Global Diagnostics Company.
            </p>
        </div>

        <!-- CTA Banner -->
        <div class="relative rounded-lg overflow-hidden shadow-xl" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);">
            <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.1\"%3E%3Crect x=\"10\" y=\"10\" width=\"15\" height=\"60\" rx=\"2\"/%3E%3Crect x=\"30\" y=\"20\" width=\"15\" height=\"50\" rx=\"2\"/%3E%3Crect x=\"50\" y=\"15\" width=\"15\" height=\"55\" rx=\"2\"/%3E%3Crect x=\"70\" y=\"25\" width=\"15\" height=\"45\" rx=\"2\"/%3E%3C/g%3E%3C/svg%3E'); background-size: 150px 150px; background-repeat: repeat;"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between py-10 sm:py-12 md:py-14 lg:py-16 px-4 sm:px-6 md:px-10 lg:px-16">
                <div class="text-white mb-6 sm:mb-8 md:mb-0 text-center md:text-left">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-1 sm:mb-2">Wide portfolio</h2>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold">of PCR kits</h2>
                </div>
                
                <a href="#" class="cta-button bg-orange-600 hover:bg-orange-700 active:bg-orange-800 text-white font-bold text-base sm:text-lg px-6 sm:px-8 md:px-10 py-3 sm:py-4 rounded transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 whitespace-nowrap">
                    GO TO PRODUCTS
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Why to Choose GeneProof Section -->
<section class="why-choose-section bg-white py-12 sm:py-16 md:py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="text-center mb-12 sm:mb-16">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-700">
                Why to choose GeneProof?
            </h2>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-10 md:gap-12 mb-12 sm:mb-16 md:mb-20">
            <!-- Feature 1: Highest Quality -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-blue-500 flex items-center justify-center">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-4">
                    Highest Quality of Products
                </h3>
                <p class="text-gray-600 mb-4 px-2 sm:px-4">
                    Best possible sensitivity and specificity,<br>
                    Easy-to-Use concept
                </p>
                <a href="#" class="text-gray-700 hover:text-blue-600 font-semibold border-b-2 border-gray-700 hover:border-blue-600 transition duration-300 inline-block">
                    Read more
                </a>
            </div>

            <!-- Feature 2: Customer Support -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-blue-500 flex items-center justify-center">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-4">
                    Customer Support
                </h3>
                <p class="text-gray-600 mb-4 px-2 sm:px-4">
                    Experts on the line, professional consultation
                </p>
                <a href="#" class="text-gray-700 hover:text-blue-600 font-semibold border-b-2 border-gray-700 hover:border-blue-600 transition duration-300 inline-block">
                    Read more
                </a>
            </div>

            <!-- Feature 3: IVD Regulatory Compliance -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-blue-500 flex items-center justify-center">
                        <svg class="w-12 h-12 sm:w-14 sm:h-14 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-gray-700 mb-4">
                    IVD Regulatory Compliance
                </h3>
                <p class="text-gray-600 mb-4 px-2 sm:px-4">
                    All products CE IVD certified, GeneProof<br>
                    complies with IVDR
                </p>
                <a href="#" class="text-gray-700 hover:text-blue-600 font-semibold border-b-2 border-gray-700 hover:border-blue-600 transition duration-300 inline-block">
                    Read more
                </a>
            </div>
        </div>

        <!-- Worldwide Distributors Banner -->
        <div class="relative rounded-lg overflow-hidden shadow-xl" style="background: linear-gradient(135deg, #2B7DB8 0%, #1E5A8E 100%);">
            <!-- World Map Background -->
            <div class="absolute inset-0 opacity-30" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 1000 400\"%3E%3Cpath fill=\"%23ffffff\" d=\"M100,100 Q150,80 200,100 T300,100 Q350,120 400,100 T500,100 M600,150 Q650,130 700,150 T800,150 M200,200 Q250,180 300,200 T400,200 M100,250 Q150,230 200,250 T300,250 M700,200 Q750,180 800,200 T900,200 M500,280 Q550,260 600,280 T700,280\"%3E%3C/path%3E%3C/svg%3E'); background-size: cover; background-position: center;"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between py-12 sm:py-14 md:py-16 lg:py-20 px-4 sm:px-6 md:px-10 lg:px-16">
                <div class="text-white mb-8 md:mb-0 text-center md:text-left">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-1 sm:mb-2">Worldwide</h2>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-1 sm:mb-2">network of</h2>
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold">distributors</h2>
                </div>
                
                <a href="#" class="distributor-cta-button bg-orange-600 hover:bg-orange-700 active:bg-orange-800 text-white font-bold text-base sm:text-lg md:text-xl px-8 sm:px-10 md:px-12 py-4 sm:py-5 rounded transition duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                    FIND YOUR LOCAL<br>DISTRIBUTOR
                </a>
            </div>
        </div>
    </div>
</section>





<section class="py-20 bg-white">
    <div class="container mx-auto">

        <!-- Section Title -->
        <h2 class="text-4xl font-bold text-center mb-12">News</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Card 1 -->
            <div class="relative group cursor-pointer">
                <!-- Background Image -->
                <img src="/images/news1.jpg" class="w-full h-64 object-cover rounded-lg">

                <!-- Overlay -->
                <div class="absolute inset-0 bg-black bg-opacity-40 rounded-lg"></div>

                <!-- Content -->
                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                    
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded mb-2">News</span>

                    <h3 class="text-white font-bold text-xl group-hover:underline">
                        Join us at MEDICA 2025 in Düsseldorf!
                    </h3>

                    <p class="text-gray-200 mt-2">17. 9. 2025</p>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="relative group cursor-pointer">
                <img src="/images/news2.jpg" class="w-full h-64 object-cover rounded-lg">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-30 rounded-lg"></div>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded mb-2">News</span>

                    <h3 class="text-white font-bold text-xl group-hover:underline">
                        croGENE Real-Time PCR System
                    </h3>

                    <p class="text-gray-200 mt-2">11. 9. 2025</p>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="relative group cursor-pointer">
                <img src="/images/news3.jpg" class="w-full h-64 object-cover rounded-lg">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-5 rounded-lg"></div>

                <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded mb-2">News</span>

                    <h3 class="text-white font-bold text-xl group-hover:underline">
                        Testing for the Most Common Thrombotic Mutations
                    </h3>

                    <p class="text-gray-200 mt-2">4. 10. 2024</p>
                </div>
            </div>

        </div>
    </div>
</section>




<!-- Dynamic Product Groups Section -->
<section class="geneproof-products-section bg-gray-100 py-12 sm:py-16 md:py-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Title -->
        <div class="text-center mb-10 sm:mb-12 md:mb-16">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-700">
                GenomeDX Products
            </h2>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 md:gap-6 max-w-7xl mx-auto">

            @foreach($groups as $group)
                <a href="{{ route('products.index', $group->slug) }}" 
                   class="product-card bg-white rounded-lg shadow-md hover:shadow-xl transition duration-300 p-6 sm:p-8 flex items-center space-x-4 sm:space-x-6 group">

                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full border-3 flex items-center justify-center 
                                    group-hover:scale-110 transition duration-300"
                             style="border-color: {{ $group->colorHex() }};">
                            @if($group->icon)
                                <img src="{{ asset('storage/'.$group->icon) }}" alt="{{ $group->name }}" class="w-8 h-8 sm:w-10 sm:h-10">
                            @else
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/>
                                </svg>
                            @endif
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold" 
                            style="color: {{ $group->colorHex() }}">
                            {{ $group->name }}
                        </h3>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</section>



<!-- GenomeDX Professional Footer -->
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
