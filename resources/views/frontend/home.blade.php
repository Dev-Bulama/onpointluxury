@extends('layouts.app')
@section('title', 'Onpointluxury — Premium Apartment & Hotel Bookings in Nigeria')

@section('content')
@php
use App\Models\Setting;

// Hero
$heroSlides = json_decode(Setting::get('hero_slides', '[]'), true);
if (empty($heroSlides)) {
    $heroSlides = [
        ['url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1600', 'caption' => ''],
        ['url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600', 'caption' => ''],
        ['url' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1600', 'caption' => ''],
    ];
}
$heroBadge    = Setting::get('hero_badge', "Nigeria's #1 Luxury Booking Platform");
$heroTitleRaw = Setting::get('hero_title', 'Find Your Perfect Luxury Stay in Nigeria');
$heroSubtitle = Setting::get('hero_subtitle', 'Premium apartments, hotel suites, and serviced residences in Lagos, Abuja & Port Harcourt. Book securely, stay luxuriously.');

// Hero title: split on | for amber highlight
$heroParts = explode('|', $heroTitleRaw, 2);

// Section toggles
$showTypes    = Setting::get('section_types_show', '1') == '1';
$showFeatured = Setting::get('section_featured_show', '1') == '1';
$showWhy      = Setting::get('section_why_show', '1') == '1';
$showLatest   = Setting::get('section_latest_show', '1') == '1';
$showCta      = Setting::get('section_cta_show', '1') == '1';

// Section texts
$typesTitle    = Setting::get('section_types_title', 'Browse by Type');
$typesSub      = Setting::get('section_types_subtitle', "Find exactly the kind of stay you're looking for");
$featLabel     = Setting::get('section_featured_label', 'Hand-Picked');
$featTitle     = Setting::get('section_featured_title', 'Featured Properties');
$latestLabel   = Setting::get('section_latest_label', 'Available Now');
$latestTitle   = Setting::get('section_latest_title', 'Latest Properties');
$whyTitle      = Setting::get('section_why_title', 'The Onpointluxury Difference');
$whySub        = Setting::get('section_why_subtitle', 'Why Choose Us');
$ctaTitle      = Setting::get('section_cta_title', 'Ready to Book Your Luxury Stay?');
$ctaSub        = Setting::get('section_cta_subtitle', 'Browse our curated collection and book securely online in minutes. Or chat with us directly on WhatsApp.');
$ctaBtn1       = Setting::get('section_cta_btn1_text', 'Browse Properties');
$ctaBtn2       = Setting::get('section_cta_btn2_text', 'WhatsApp Us');

$defaultFeatures = [
    ['icon'=>'fas fa-shield-alt','title'=>'Verified Properties','desc'=>'Every property is personally inspected and verified to meet our international quality standards.'],
    ['icon'=>'fas fa-lock','title'=>'Secure Payments','desc'=>"All transactions are processed through Paystack, Nigeria's most trusted payment gateway."],
    ['icon'=>'fab fa-whatsapp','title'=>'WhatsApp Support','desc'=>'24/7 direct support via WhatsApp. Real humans, instant responses, no bots.'],
    ['icon'=>'fas fa-star','title'=>'Best Price Guarantee','desc'=>"Find a lower price elsewhere? We'll match it. No questions asked."],
];
$whyFeatures = json_decode(Setting::get('section_why_features', '[]'), true) ?: $defaultFeatures;
@endphp

<!-- HERO SECTION -->
<section class="relative bg-slate-900 min-h-[88vh] flex items-center overflow-hidden"
    x-data="{
        idx: 0,
        slides: {{ json_encode(array_column($heroSlides, 'url')) }},
        timer: null,
        init() { this.timer = setInterval(() => { this.idx = (this.idx + 1) % this.slides.length; }, 5000); }
    }"
    x-init="init()">

    {{-- Slide backgrounds --}}
    <template x-for="(src, i) in slides" :key="i">
        <div :class="{'opacity-30': idx===i, 'opacity-0': idx!==i}"
             class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000"
             :style="`background-image:url('${src}')`"></div>
    </template>

    {{-- Slide dots --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20" x-show="slides.length > 1">
        <template x-for="(s, i) in slides" :key="i">
            <button @click="idx=i; clearInterval(timer); init()"
                    :class="idx===i ? 'bg-amber-400 w-6' : 'bg-white/50 w-2'"
                    class="h-2 rounded-full transition-all duration-300"></button>
        </template>
    </div>

    <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-900/80 z-10"></div>
    <div class="relative z-20 max-w-7xl mx-auto px-4 py-24 w-full">
        <div class="max-w-3xl mb-10">
            <div class="inline-flex items-center gap-2 bg-amber-500/20 border border-amber-500/40 text-amber-300 text-sm px-4 py-2 rounded-full mb-6">
                <i class="fas fa-star text-amber-400"></i> {{ $heroBadge }}
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4">
                @if(count($heroParts) === 2)
                    {{ $heroParts[0] }}<span class="text-amber-400">{{ $heroParts[1] }}</span>
                @else
                    {{ $heroTitleRaw }}
                @endif
            </h1>
            <p class="text-lg text-gray-300 leading-relaxed">{{ $heroSubtitle }}</p>
        </div>

        <!-- Search Card -->
        <div class="bg-white rounded-2xl p-5 shadow-2xl w-full max-w-5xl mx-auto">
            <form action="{{ route('properties.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Location</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3 top-3 text-amber-400 text-sm pointer-events-none"></i>
                            <input type="text" name="location" placeholder="Lagos, Abuja..." value="{{ request('location') }}"
                                   class="w-full pl-8 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Check-in</label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-3 top-3 text-amber-400 text-sm pointer-events-none"></i>
                            <input type="date" name="check_in" min="{{ date('Y-m-d') }}"
                                   value="{{ request('check_in') }}"
                                   class="w-full pl-8 pr-2 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Check-out</label>
                        <div class="relative">
                            <i class="fas fa-calendar-check absolute left-3 top-3 text-amber-400 text-sm pointer-events-none"></i>
                            <input type="date" name="check_out"
                                   value="{{ request('check_out') }}"
                                   class="w-full pl-8 pr-2 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Guests</label>
                        <div class="relative">
                            <i class="fas fa-users absolute left-3 top-3 text-amber-400 text-sm pointer-events-none"></i>
                            <select name="guests" class="w-full pl-8 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                                @for($i=1;$i<=10;$i++)
                                <option value="{{ $i }}" {{ request('guests', 1) == $i ? 'selected' : '' }}>{{ $i }} Guest{{ $i>1?'s':'' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="flex items-end sm:col-span-2 lg:col-span-1">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-4 rounded-xl transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="flex flex-wrap gap-6 mt-8">
            <div class="text-center"><p class="text-2xl font-black text-white">{{ $stats['properties'] }}+</p><p class="text-xs text-gray-400">Properties</p></div>
            <div class="w-px bg-white/20 hidden sm:block"></div>
            <div class="text-center"><p class="text-2xl font-black text-white">{{ $stats['bookings'] }}+</p><p class="text-xs text-gray-400">Bookings Done</p></div>
            <div class="w-px bg-white/20 hidden sm:block"></div>
            <div class="text-center"><p class="text-2xl font-black text-white">{{ $stats['clients'] }}+</p><p class="text-xs text-gray-400">Happy Clients</p></div>
            <div class="w-px bg-white/20 hidden sm:block"></div>
            <div class="text-center"><p class="text-2xl font-black text-white">{{ $stats['cities'] }}+</p><p class="text-xs text-gray-400">Cities</p></div>
        </div>
    </div>
</section>

<!-- PROPERTY TYPES -->
@if($showTypes)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-slate-900">{{ $typesTitle }}</h2>
            <p class="text-gray-500 mt-2">{{ $typesSub }}</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($propertyTypes->take(10) as $type)
            <a href="{{ route('properties.index', ['type' => $type->slug]) }}"
               class="bg-white rounded-2xl p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 group">
                <div class="text-3xl mb-2">{{ $type->icon ?? '🏠' }}</div>
                <p class="font-semibold text-sm text-slate-800 group-hover:text-amber-500">{{ $type->name }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $type->properties_count }} listings</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- FEATURED PROPERTIES -->
@if($showFeatured && $featuredProperties->count())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-amber-500 font-semibold text-sm uppercase tracking-wider mb-1">{{ $featLabel }}</p>
                <h2 class="text-3xl font-black text-slate-900">{{ $featTitle }}</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="text-sm font-medium text-slate-600 hover:text-amber-500 flex items-center gap-1">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($featuredProperties as $property)
            @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- WHY CHOOSE US -->
@if($showWhy)
<section class="py-20 bg-slate-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14">
            <p class="text-amber-400 font-semibold text-sm uppercase tracking-wider mb-2">{{ $whySub }}</p>
            <h2 class="text-3xl font-black text-white">{{ $whyTitle }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($whyFeatures as $feature)
            <div class="text-center">
                <div class="w-14 h-14 bg-amber-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $feature['icon'] }} text-amber-400 text-2xl"></i>
                </div>
                <h3 class="font-bold text-white mb-2">{{ $feature['title'] }}</h3>
                <p class="text-sm text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- LATEST PROPERTIES -->
@if($showLatest)
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-amber-500 font-semibold text-sm uppercase tracking-wider mb-1">{{ $latestLabel }}</p>
                <h2 class="text-3xl font-black text-slate-900">{{ $latestTitle }}</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="text-sm font-medium text-slate-600 hover:text-amber-500 flex items-center gap-1">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allProperties->take(6) as $property)
            @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA SECTION -->
@if($showCta)
<section class="py-20 bg-amber-500">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white mb-4">{{ $ctaTitle }}</h2>
        <p class="text-amber-100 mb-8">{{ $ctaSub }}</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('properties.index') }}" class="bg-white text-amber-600 font-bold px-8 py-3 rounded-xl hover:bg-amber-50 transition-colors">
                {{ $ctaBtn1 }}
            </a>
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','2348012345678') }}" target="_blank"
               class="bg-green-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2">
                <i class="fab fa-whatsapp text-lg"></i> {{ $ctaBtn2 }}
            </a>
        </div>
    </div>
</section>
@endif

@endsection
