<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Onpointluxury</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { DEFAULT: '#c9a84c', dark: '#b8943d' },
                        navy: { DEFAULT: '#1a1a2e', sidebar: '#16213e' }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            color: #d1d5db;
            font-size: 0.875rem;
            transition: all 0.15s;
            text-decoration: none;
        }
        .sidebar-link:hover { background: rgba(255,255,255,0.1); color: #fff; }
        .sidebar-link.active { background: rgba(234,179,8,0.2); color: #fbbf24; font-weight: 500; }
        .sidebar-section {
            font-size: 0.65rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 1rem;
            margin-top: 1.25rem;
            margin-bottom: 0.5rem;
        }
        .card { background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.07); border: 1px solid #f3f4f6; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen" x-data="{ sidebarOpen: false }">

<!-- Sidebar Overlay Mobile -->
<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
     class="fixed inset-0 bg-black/50 z-20 lg:hidden"></div>

<!-- Sidebar -->
<aside class="fixed left-0 top-0 bottom-0 w-64 z-30 overflow-y-auto transition-transform duration-300"
       style="background:#1a1a2e;"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    <!-- Logo -->
    <div class="p-5 border-b border-white/10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#c9a84c;">
                <span class="text-black font-bold text-xs">OPL</span>
            </div>
            <div>
                <div class="text-white font-bold text-sm">Onpointluxury</div>
                <div class="text-gray-400 text-xs">Admin Panel</div>
            </div>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="p-3 pb-12">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line w-4 text-center"></i> Dashboard
        </a>

        <!-- Properties -->
        <div class="sidebar-section">Properties</div>
        <a href="{{ route('admin.properties.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
            <i class="fas fa-building w-4 text-center"></i> Properties
        </a>
        <a href="{{ route('admin.properties.index') }}?view=rooms"
           class="sidebar-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
            <i class="fas fa-door-open w-4 text-center"></i> Rooms & Units
        </a>

        <!-- Reservations -->
        <div class="sidebar-section">Reservations</div>
        <a href="{{ route('admin.bookings.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
            <i class="fas fa-calendar-check w-4 text-center"></i> Bookings
        </a>
        <a href="{{ route('admin.payments.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card w-4 text-center"></i> Payments
        </a>

        <!-- Users -->
        <div class="sidebar-section">Users</div>
        <a href="{{ route('admin.users.index') }}?role=admin"
           class="sidebar-link {{ request()->routeIs('admin.users.*') && request('role')=='admin' ? 'active' : '' }}">
            <i class="fas fa-user-shield w-4 text-center"></i> Admins
        </a>
        <a href="{{ route('admin.users.index') }}?role=manager"
           class="sidebar-link {{ request()->routeIs('admin.users.*') && request('role')=='manager' ? 'active' : '' }}">
            <i class="fas fa-user-tie w-4 text-center"></i> Managers
        </a>
        <a href="{{ route('admin.users.index') }}?role=client"
           class="sidebar-link {{ request()->routeIs('admin.users.*') && request('role')=='client' ? 'active' : '' }}">
            <i class="fas fa-users w-4 text-center"></i> Clients
        </a>

        <!-- Content -->
        <div class="sidebar-section">Content</div>
        <a href="{{ route('admin.hero-slides.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
            <i class="fas fa-sliders-h w-4 text-center"></i> Hero Slides
        </a>
        <a href="{{ route('admin.pages.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt w-4 text-center"></i> Pages
        </a>
        <a href="{{ route('admin.blog.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
            <i class="fas fa-blog w-4 text-center"></i> Blog
        </a>
        <a href="{{ route('admin.faqs.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle w-4 text-center"></i> FAQs
        </a>
        <a href="{{ route('admin.testimonials.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
            <i class="fas fa-star w-4 text-center"></i> Testimonials
        </a>
        <a href="{{ route('admin.menus.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
            <i class="fas fa-bars w-4 text-center"></i> Menus
        </a>
        <a href="{{ route('admin.reviews.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
            <i class="fas fa-star-half-alt w-4 text-center"></i> Reviews
        </a>
        <a href="{{ route('admin.messages.index') }}"
           class="sidebar-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
            <i class="fas fa-envelope w-4 text-center"></i> Messages
        </a>

        <!-- Settings -->
        <div class="sidebar-section">Settings</div>
        <a href="{{ route('admin.settings.general') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.general*') ? 'active' : '' }}">
            <i class="fas fa-cog w-4 text-center"></i> General
        </a>
        <a href="{{ route('admin.settings.homepage') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.homepage*') ? 'active' : '' }}">
            <i class="fas fa-home w-4 text-center"></i> Homepage
        </a>
        <a href="{{ route('admin.settings.smtp') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.smtp*') ? 'active' : '' }}">
            <i class="fas fa-envelope-open-text w-4 text-center"></i> SMTP Email
        </a>
        <a href="{{ route('admin.settings.paystack') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.paystack*') ? 'active' : '' }}">
            <i class="fas fa-money-bill w-4 text-center"></i> Paystack
        </a>
        <a href="{{ route('admin.settings.booking') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.booking*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt w-4 text-center"></i> Booking
        </a>
        <a href="{{ route('admin.settings.whatsapp') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.whatsapp*') ? 'active' : '' }}">
            <i class="fab fa-whatsapp w-4 text-center"></i> WhatsApp
        </a>
        <a href="{{ route('admin.settings.scripts') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.scripts*') ? 'active' : '' }}">
            <i class="fas fa-code w-4 text-center"></i> Scripts
        </a>
        <a href="{{ route('admin.settings.seo') }}"
           class="sidebar-link {{ request()->routeIs('admin.settings.seo*') ? 'active' : '' }}">
            <i class="fas fa-search w-4 text-center"></i> SEO
        </a>

        <!-- View Site -->
        <div class="mt-4 pt-4 border-t border-white/10">
            <a href="{{ route('home') }}" target="_blank" class="sidebar-link">
                <i class="fas fa-external-link-alt w-4 text-center"></i> View Website
            </a>
        </div>
    </nav>
</aside>

<!-- Main Content -->
<div class="lg:ml-64 min-h-screen flex flex-col">
    <!-- Top Header -->
    <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" target="_blank"
               class="text-gray-500 hover:text-gray-700 text-sm hidden sm:flex items-center gap-1.5">
                <i class="fas fa-external-link-alt text-xs"></i>
                <span>Website</span>
            </a>
            <!-- User Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-black font-bold text-xs"
                         style="background:#c9a84c;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="hidden sm:block font-medium">{{ auth()->user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                </button>
                <div x-show="open" x-cloak @click.away="open = false"
                     class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <a href="{{ route('admin.users.edit', auth()->user()) }}"
                       class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-user-edit text-gray-400 w-4"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                            <i class="fas fa-sign-out-alt w-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="px-6 pt-4 space-y-3">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition
             x-init="setTimeout(() => show = false, 5000)"
             class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center justify-between">
            <span class="flex items-center gap-2 text-sm">
                <i class="fas fa-check-circle text-green-500"></i>
                {{ session('success') }}
            </span>
            <button @click="show = false" class="text-green-500 hover:text-green-700 ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition
             x-init="setTimeout(() => show = false, 8000)"
             class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center justify-between">
            <span class="flex items-center gap-2 text-sm">
                <i class="fas fa-exclamation-circle text-red-500"></i>
                {{ session('error') }}
            </span>
            <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
        @if(session('info'))
        <div x-data="{ show: true }" x-show="show" x-transition
             x-init="setTimeout(() => show = false, 6000)"
             class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-xl flex items-center justify-between">
            <span class="flex items-center gap-2 text-sm">
                <i class="fas fa-info-circle text-blue-500"></i>
                {{ session('info') }}
            </span>
            <button @click="show = false" class="text-blue-500 hover:text-blue-700 ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        @endif
        @if($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition
             class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl">
            <div class="flex items-start justify-between">
                <div>
                    <p class="flex items-center gap-2 text-sm font-medium mb-1">
                        <i class="fas fa-exclamation-triangle text-red-500"></i>
                        Please fix the following errors:
                    </p>
                    <ul class="list-disc list-inside text-sm space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- Page Content -->
    <main class="p-6 flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="px-6 py-4 border-t border-gray-200 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} Onpointluxury Admin Panel
    </footer>
</div>

@stack('scripts')
</body>
</html>
