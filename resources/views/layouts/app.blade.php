<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', \App\Models\Setting::get('meta_title', 'Onpointluxury — Premium Apartment & Hotel Bookings'))</title>
    <meta name="description" content="@yield('meta_description', \App\Models\Setting::get('meta_description', 'Book luxury apartments and hotel suites across Nigeria.'))">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        gold: { DEFAULT: '#c9a84c', light: '#e4c876', dark: '#a8873a' },
                        navy: { DEFAULT: '#1a1a2e', light: '#16213e' }
                    },
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .btn-gold { @apply bg-amber-500 hover:bg-amber-600 text-white font-semibold transition-all duration-200; }
        .btn-navy { @apply bg-slate-900 hover:bg-slate-800 text-white font-semibold transition-all duration-200; }
        .property-card:hover .property-img { transform: scale(1.05); }
        .property-img { transition: transform 0.4s ease; }
        html { scroll-behavior: smooth; }
    </style>
    {!! \App\Models\Setting::get('header_scripts') !!}
</head>
<body class="font-sans bg-white text-gray-900" x-data="{ mobileMenu: false }">

<!-- Top Bar -->
<div class="bg-slate-900 text-gray-300 text-xs py-2 hidden md:block">
    <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
        <div class="flex items-center gap-4">
            <span><i class="fas fa-phone mr-1"></i>{{ \App\Models\Setting::get('contact_phone', '+234 800 ONPOINT') }}</span>
            <span><i class="fas fa-envelope mr-1"></i>{{ \App\Models\Setting::get('contact_email', 'hello@onpointluxury.com') }}</span>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isManager() ? route('manager.dashboard') : route('client.dashboard')) }}" class="hover:text-amber-400">
                    <i class="fas fa-user mr-1"></i>{{ auth()->user()->name }}
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">@csrf<button class="hover:text-amber-400">Logout</button></form>
            @else
                <a href="{{ route('login') }}" class="hover:text-amber-400">Login</a>
                <a href="{{ route('register') }}" class="hover:text-amber-400">Register</a>
            @endauth
        </div>
    </div>
</div>

<!-- Main Navigation -->
<nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                @if(\App\Models\Setting::get('logo'))
                    <img src="{{ asset('storage/'.\App\Models\Setting::get('logo')) }}" alt="Logo" class="h-10">
                @else
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-black text-sm">OPL</span>
                        </div>
                        <span class="font-black text-xl text-slate-900 tracking-tight">Onpoint<span class="text-amber-500">luxury</span></span>
                    </div>
                @endif
            </a>

            <!-- Desktop Menu -->
            <div class="hidden lg:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 hover:text-amber-500 transition-colors {{ request()->routeIs('home') ? 'text-amber-500' : '' }}">Home</a>
                <a href="{{ route('properties.index') }}" class="text-sm font-medium text-gray-700 hover:text-amber-500 transition-colors {{ request()->routeIs('properties.*') ? 'text-amber-500' : '' }}">Properties</a>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-sm font-medium text-gray-700 hover:text-amber-500 transition-colors flex items-center gap-1">
                        Types <i class="fas fa-chevron-down text-xs"></i>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false" class="absolute top-full left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        @foreach(\App\Models\PropertyType::where('is_active',true)->take(6)->get() as $type)
                        <a href="{{ route('properties.index', ['type' => $type->slug]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-600">{{ $type->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('blog.index') }}" class="text-sm font-medium text-gray-700 hover:text-amber-500 transition-colors">Blog</a>
                <a href="{{ route('faq') }}" class="text-sm font-medium text-gray-700 hover:text-amber-500 transition-colors">FAQ</a>
                <a href="{{ route('contact') }}" class="text-sm font-medium text-gray-700 hover:text-amber-500 transition-colors">Contact</a>
            </div>

            <!-- CTA Buttons -->
            <div class="hidden lg:flex items-center gap-3">
                @php $wa = \App\Models\Setting::get('whatsapp_number', '2348012345678'); @endphp
                <a href="https://wa.me/{{ $wa }}" target="_blank" class="flex items-center gap-1.5 text-sm text-green-600 font-medium hover:text-green-700">
                    <i class="fab fa-whatsapp text-lg"></i> WhatsApp
                </a>
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('client.dashboard') }}" class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-800">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-amber-500">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-amber-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-amber-600">Get Started</a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-gray-700 p-2">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenu" x-cloak class="lg:hidden border-t border-gray-100 bg-white py-4 px-4 space-y-3">
        <a href="{{ route('home') }}" class="block text-sm font-medium text-gray-700 py-2">Home</a>
        <a href="{{ route('properties.index') }}" class="block text-sm font-medium text-gray-700 py-2">Properties</a>
        <a href="{{ route('blog.index') }}" class="block text-sm font-medium text-gray-700 py-2">Blog</a>
        <a href="{{ route('faq') }}" class="block text-sm font-medium text-gray-700 py-2">FAQ</a>
        <a href="{{ route('contact') }}" class="block text-sm font-medium text-gray-700 py-2">Contact</a>
        <div class="pt-3 flex gap-3">
            @auth
                <a href="{{ route('client.dashboard') }}" class="flex-1 text-center bg-slate-900 text-white py-2 rounded-lg text-sm">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="flex-1 text-center border border-gray-300 py-2 rounded-lg text-sm">Login</a>
                <a href="{{ route('register') }}" class="flex-1 text-center bg-amber-500 text-white py-2 rounded-lg text-sm">Register</a>
            @endauth
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success') || session('error') || session('info'))
<div class="max-w-7xl mx-auto px-4 pt-4">
    @if(session('success'))
    <div x-data="{show:true}" x-show="show" class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex justify-between items-center">
        <span><i class="fas fa-check-circle mr-2 text-green-500"></i>{{ session('success') }}</span>
        <button @click="show=false"><i class="fas fa-times"></i></button>
    </div>
    @endif
    @if(session('error'))
    <div x-data="{show:true}" x-show="show" class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex justify-between items-center">
        <span><i class="fas fa-exclamation-circle mr-2 text-red-500"></i>{{ session('error') }}</span>
        <button @click="show=false"><i class="fas fa-times"></i></button>
    </div>
    @endif
</div>
@endif

@yield('content')

<!-- Footer -->
<footer class="bg-slate-900 text-gray-300 mt-20">
    <div class="max-w-7xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <!-- Brand -->
            <div class="lg:col-span-1">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-amber-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-black text-sm">OPL</span>
                    </div>
                    <span class="font-black text-xl text-white">Onpoint<span class="text-amber-400">luxury</span></span>
                </div>
                <p class="text-sm text-gray-400 leading-relaxed mb-4">{{ \App\Models\Setting::get('site_tagline', 'Premium Apartment & Hotel Bookings in Nigeria.') }}</p>
                <div class="flex gap-3">
                    <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','2348012345678') }}" class="w-9 h-9 bg-green-600 rounded-lg flex items-center justify-center hover:bg-green-500 transition-colors"><i class="fab fa-whatsapp text-white"></i></a>
                    <a href="#" class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-500 transition-colors"><i class="fab fa-facebook-f text-white"></i></a>
                    <a href="#" class="w-9 h-9 bg-pink-600 rounded-lg flex items-center justify-center hover:bg-pink-500 transition-colors"><i class="fab fa-instagram text-white"></i></a>
                    <a href="#" class="w-9 h-9 bg-sky-500 rounded-lg flex items-center justify-center hover:bg-sky-400 transition-colors"><i class="fab fa-twitter text-white"></i></a>
                </div>
            </div>
            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('properties.index') }}" class="hover:text-amber-400 transition-colors">Browse Properties</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-amber-400 transition-colors">Blog & News</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-amber-400 transition-colors">FAQ</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-amber-400 transition-colors">Contact Us</a></li>
                    <li><a href="/about" class="hover:text-amber-400 transition-colors">About Us</a></li>
                </ul>
            </div>
            <!-- Legal -->
            <div>
                <h4 class="text-white font-semibold mb-4">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="/terms" class="hover:text-amber-400 transition-colors">Terms & Conditions</a></li>
                    <li><a href="/privacy" class="hover:text-amber-400 transition-colors">Privacy Policy</a></li>
                    <li><a href="/refund-policy" class="hover:text-amber-400 transition-colors">Refund Policy</a></li>
                </ul>
            </div>
            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-4">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-start gap-2"><i class="fas fa-map-marker-alt mt-1 text-amber-400"></i><span>{{ \App\Models\Setting::get('address','Victoria Island, Lagos, Nigeria') }}</span></li>
                    <li class="flex items-center gap-2"><i class="fas fa-phone text-amber-400"></i><a href="tel:{{ \App\Models\Setting::get('contact_phone') }}" class="hover:text-amber-400">{{ \App\Models\Setting::get('contact_phone') }}</a></li>
                    <li class="flex items-center gap-2"><i class="fas fa-envelope text-amber-400"></i><a href="mailto:{{ \App\Models\Setting::get('contact_email') }}" class="hover:text-amber-400">{{ \App\Models\Setting::get('contact_email') }}</a></li>
                    <li class="flex items-center gap-2"><i class="fab fa-whatsapp text-green-400 text-lg"></i>
                        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','2348012345678') }}" class="hover:text-green-400">WhatsApp Us</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 pt-6 flex flex-col md:flex-row justify-between items-center gap-3">
            <p class="text-sm text-gray-500">&copy; {{ date('Y') }} {{ \App\Models\Setting::get('site_name','Onpointluxury') }}. All rights reserved.</p>
            <p class="text-sm text-gray-600">Premium Living Experiences Across Nigeria</p>
        </div>
    </div>
</footer>

{!! \App\Models\Setting::get('footer_scripts') !!}
@stack('scripts')

{{-- Mobile Bottom Navigation --}}
<nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 md:hidden safe-area-bottom">
    <div class="flex items-center justify-around h-16">
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-0.5 px-3 py-2 {{ request()->routeIs('home') ? 'text-amber-500' : 'text-gray-500' }}">
            <i class="fas fa-home text-lg"></i>
            <span class="text-xs font-medium">Home</span>
        </a>
        <a href="{{ route('properties.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-2 {{ request()->routeIs('properties.index') ? 'text-amber-500' : 'text-gray-500' }}">
            <i class="fas fa-search text-lg"></i>
            <span class="text-xs font-medium">Search</span>
        </a>
        <a href="{{ route('properties.index') }}" class="flex flex-col items-center gap-0.5 px-3 py-2 {{ request()->routeIs('properties.*') && !request()->routeIs('properties.index') ? 'text-amber-500' : 'text-gray-500' }}">
            <i class="fas fa-building text-lg"></i>
            <span class="text-xs font-medium">Properties</span>
        </a>
        @auth
        <a href="{{ auth()->user()->isAdmin() || auth()->user()->isManager() ? route('admin.bookings.index') : route('client.bookings') }}"
           class="flex flex-col items-center gap-0.5 px-3 py-2 {{ request()->routeIs('client.bookings*') || request()->routeIs('admin.bookings*') ? 'text-amber-500' : 'text-gray-500' }}">
            <i class="fas fa-calendar-check text-lg"></i>
            <span class="text-xs font-medium">Bookings</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="flex flex-col items-center gap-0.5 px-3 py-2 text-gray-500">
            <i class="fas fa-calendar-check text-lg"></i>
            <span class="text-xs font-medium">Bookings</span>
        </a>
        @endauth
        <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','2348012345678') }}" target="_blank"
           class="flex flex-col items-center gap-0.5 px-3 py-2 text-green-600">
            <i class="fab fa-whatsapp text-lg"></i>
            <span class="text-xs font-medium">WhatsApp</span>
        </a>
    </div>
</nav>
<style>
    @supports (padding-bottom: env(safe-area-inset-bottom)) {
        .safe-area-bottom { padding-bottom: env(safe-area-inset-bottom); }
    }
    @media (max-width: 767px) { body { padding-bottom: 4rem; } }
</style>
</body>
</html>
