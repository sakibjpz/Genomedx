<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Sidebar */
        .admin-sidebar {
            width: 250px;
            background: #1f2937;
            min-height: 100vh;
            color: #fff;
            position: sticky;
            top: 0;
            align-self: flex-start;
        }
        .admin-sidebar a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .admin-sidebar a:hover {
            background: #374151;
        }
        .admin-sidebar .active {
            background: #3b82f6;
        }
        .admin-sidebar .active:hover {
            background: #2563eb;
        }
        .sidebar-header {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 20px;
            border-bottom: 1px solid #374151;
            text-align: center;
        }

        /* Top Header */
        .admin-header {
            height: 60px;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 20px;
        }

        /* Content */
        .admin-content {
            padding: 20px;
            flex: 1;
            background: #f3f4f6;
            min-height: calc(100vh - 60px);
        }

        /* Layout */
        .admin-layout {
            display: flex;
        }

        .logout-btn {
            background: #ef4444;
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover {
            background: #dc2626;
        }

        /* Menu Items with Icons */
        .menu-item {
            display: flex;
            align-items: center;
        }
        .menu-item i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        /* Badge for pending queries */
        .pending-badge {
            background: #ef4444;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 9999px;
            margin-left: auto;
        }

        /* Sub-menu styling */
        .sub-menu {
            padding-left: 40px;
        }
        .sub-menu a {
            padding: 8px 20px;
            font-size: 14px;
            color: #d1d5db;
        }
        .sub-menu a:hover {
            color: white;
            background: #4b5563;
        }
    </style>
</head>
<body>

<div class="admin-layout">
<aside class="admin-sidebar">
    <div class="sidebar-header">Admin Panel</div>
    <nav class="mt-4">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>

        {{-- Contact Queries --}}
        <a href="{{ route('admin.contact-queries.index') }}" 
           class="menu-item {{ request()->is('admin/contact-queries*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Contact Queries
            @php
                $pendingCount = \App\Models\ContactQuery::where('status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span class="pending-badge">{{ $pendingCount }}</span>
            @endif
        </a>

        {{-- Team Performance --}}
<a href="{{ route('admin.team-performance.index') }}" 
   class="menu-item {{ request()->is('admin/team-performance*') ? 'active' : '' }}">
    <i class="fas fa-chart-line"></i> Team Performance
</a>

{{-- Query Types Management --}}
<a href="{{ route('admin.query-types.index') }}" 
   class="menu-item {{ request()->is('admin/query-types*') ? 'active' : '' }}">
    <i class="fas fa-list-alt"></i> Query Types
</a>

        {{-- Menus --}}
        <a href="{{ route('admin.menus.index') }}" class="menu-item {{ request()->is('admin/menus*') ? 'active' : '' }}">
            <i class="fas fa-bars"></i> Menus
        </a>

        {{-- Companies Management --}}
<a href="{{ route('admin.companies.index') }}" 
   class="menu-item {{ request()->is('admin/companies*') ? 'active' : '' }}">
    <i class="fas fa-building"></i> Companies
</a>


        {{-- Social Links --}}
        <a href="{{ route('admin.social-links.index') }}" class="menu-item {{ request()->is('admin/social-links*') ? 'active' : '' }}">
            <i class="fas fa-share-alt"></i> Social Links
        </a>

        {{-- Flags --}}
        <a href="{{ route('admin.flags.index') }}" class="menu-item {{ request()->is('admin/flags*') ? 'active' : '' }}">
            <i class="fas fa-flag"></i> Flags
        </a>

        {{-- Banners --}}
        <a href="{{ route('admin.banners.index') }}" class="menu-item {{ request()->is('admin/banners*') ? 'active' : '' }}">
            <i class="fas fa-image"></i> Banners
        </a>

        {{-- Products Section --}}
        <div class="mt-6 mb-2 px-4 text-sm text-gray-400 uppercase tracking-wider">
            <i class="fas fa-box mr-2"></i> Products
        </div>

        {{-- Product Groups --}}
        <a href="{{ route('admin.product-groups.index') }}" 
           class="menu-item {{ request()->is('admin/product-groups') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Product Groups
        </a>

        {{-- All Products by Group --}}
        <div class="sub-menu">
            <a href="{{ route('admin.products.by-group') }}"
               class="{{ request()->routeIs('admin.products.by-group') ? 'text-blue-300' : '' }}">
                All Products by Group
            </a>
        </div>

        {{-- Settings --}}
<li class="mb-2">
    <a href="{{ route('admin.settings.index') }}" 
       class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.settings.*') ? 'bg-gray-200' : '' }}">
        <i class="fas fa-cog mr-3"></i>
        Frontend Settings
    </a>
</li>

{{-- News --}}
<li class="mb-2">
    <a href="{{ route('admin.news.index') }}" 
       class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded {{ request()->routeIs('admin.news.*') ? 'bg-gray-200' : '' }}">
        <i class="fas fa-newspaper mr-3"></i>
        News Management
    </a>
</li>

    </nav>
</aside>

    {{-- Main content area --}}
    <div class="flex-1 flex flex-col">

        {{-- Top Header --}}
        <header class="admin-header">
            <span class="mr-4 text-gray-700">
                <i class="fas fa-user-circle mr-2"></i>{{ auth()->user()->name ?? 'Admin' }}
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </header>

        {{-- Content --}}
        <main class="admin-content">
            @yield('content')
        </main>

    </div>

</div>

</body>
</html>