@extends('layouts.app')
@section('title', \App\Models\Setting::get('meta_title', 'Onpointluxury — Premium Apartment & Hotel Bookings in Nigeria'))

@push('head')
{{-- Preload first hero image for LCP --}}
@if($heroSlides->isNotEmpty())
<link rel="preload" as="image" href="{{ $heroSlides->first()->desktop_image_url }}" fetchpriority="high">
@endif
<style>
/* ── Hero slider ─────────────────────────────────────── */
.opl-hero {
    position: relative;
    height: 85svh;
    min-height: 600px;
    overflow: hidden;
    background: #0f172a; /* slate-950 — visible if image fails */
}
@media (min-width: 1024px) {
    .opl-hero { height: 80vh; min-height: 720px; max-height: 860px; }
}

/* Slide image */
.opl-slide { position: absolute; inset: 0; will-change: opacity; }
.opl-slide img {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: none;
}
.opl-slide.is-active img { animation: opl-kb 14s ease-in-out infinite; }
@keyframes opl-kb {
    0%   { transform: scale(1.0) translate(0%, 0%); }
    50%  { transform: scale(1.07) translate(-0.6%, -0.4%); }
    100% { transform: scale(1.0) translate(0%, 0%); }
}

/* Gradient overlay */
.opl-slide-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        to bottom,
        rgba(15,23,42,0.30) 0%,
        rgba(15,23,42,0.25) 35%,
        rgba(15,23,42,0.55) 65%,
        rgba(15,23,42,0.82) 100%
    );
}
@media (max-width: 767px) {
    .opl-slide-overlay {
        background: linear-gradient(
            to bottom,
            rgba(15,23,42,0.25) 0%,
            rgba(15,23,42,0.30) 30%,
            rgba(15,23,42,0.70) 60%,
            rgba(15,23,42,0.92) 100%
        );
    }
}

/* Slide fade transition */
.opl-slide { opacity: 0; transition: opacity 0.9s ease; }
.opl-slide.is-active { opacity: 1; z-index: 1; }
.opl-slide.is-leaving { opacity: 0; z-index: 0; }

/* Content stagger */
.opl-content { opacity: 0; }
.opl-content.is-visible .opl-badge  { animation: opl-up 0.55s ease both 0.05s; }
.opl-content.is-visible .opl-hl     { animation: opl-up 0.55s ease both 0.18s; }
.opl-content.is-visible .opl-desc   { animation: opl-up 0.55s ease both 0.32s; }
.opl-content.is-visible .opl-ctas   { animation: opl-up 0.55s ease both 0.46s; }
.opl-content.is-visible { opacity: 1; }
@keyframes opl-up {
    from { opacity: 0; transform: translateY(22px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Progress bar */
.opl-progress {
    position: absolute; bottom: 0; left: 0;
    height: 3px; background: #f59e0b; /* amber-500 */
    z-index: 20; width: 0%;
}
.opl-progress.running { animation: opl-prog linear; }
@keyframes opl-prog { from { width: 0% } to { width: 100% } }

/* Arrow buttons */
.opl-arrow {
    position: absolute; top: 50%; z-index: 20;
    transform: translateY(-50%);
    width: 48px; height: 48px; border-radius: 50%;
    background: rgba(255,255,255,0.12);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff; font-size: 1.1rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s, transform 0.2s;
    opacity: 0;
}
.opl-hero:hover .opl-arrow,
.opl-hero:focus-within .opl-arrow { opacity: 1; }
.opl-arrow:hover { background: rgba(245,158,11,0.6); transform: translateY(-50%) scale(1.05); }
.opl-arrow-prev { left: 16px; }
.opl-arrow-next { right: 16px; }
@media (max-width: 767px) {
    .opl-arrow { width: 40px; height: 40px; opacity: 0.7; }
}

/* Dots */
.opl-dot {
    width: 8px; height: 8px; border-radius: 9999px;
    background: rgba(255,255,255,0.4); border: none; cursor: pointer;
    transition: width 0.3s ease, background 0.3s ease;
}
.opl-dot.active { width: 24px; background: #f59e0b; }

/* reduced motion */
@media (prefers-reduced-motion: reduce) {
    .opl-slide.is-active img { animation: none !important; }
    .opl-content.is-visible .opl-badge,
    .opl-content.is-visible .opl-hl,
    .opl-content.is-visible .opl-desc,
    .opl-content.is-visible .opl-ctas { animation: none !important; opacity: 1; }
    .opl-progress.running { animation: none !important; width: 100%; }
    .opl-slide { transition-duration: 0.01ms !important; }
}

/* Trust strip */
.opl-trust-item { display: flex; align-items: center; gap: 10px; }
</style>
@endpush

@section('content')
@php
use App\Models\Setting;

$waNumber = Setting::get('whatsapp_number', '2348012345678');

// Default slides when DB is empty
$defaultSlides = [
    (object)[
        'id' => 0, 'badge' => 'PREMIUM LIVING, PERFECTLY BOOKED',
        'headline' => 'Explore. Discover. Live.',
        'description' => 'Experience beautiful fully serviced apartments designed for comfort, privacy and unforgettable stays.',
        'cta1_text' => 'Explore Properties', 'cta1_url' => route('properties.index'),
        'cta2_text' => 'Chat on WhatsApp',   'cta2_url' => 'https://wa.me/'.$waNumber,
        'desktop_image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1600&q=80',
        'mobile_image_url'  => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=80',
        'alt_text' => 'Luxury apartment interior with modern furnishings',
        'focal_position' => 'center',
    ],
    (object)[
        'id' => 0, 'badge' => 'YOUR PERFECT ESCAPE AWAITS',
        'headline' => 'Luxury That Feels Like Home',
        'description' => 'Discover carefully selected apartments where elegant design meets everyday comfort.',
        'cta1_text' => 'View Apartments', 'cta1_url' => route('properties.index'),
        'cta2_text' => 'Chat on WhatsApp', 'cta2_url' => 'https://wa.me/'.$waNumber,
        'desktop_image_url' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=80',
        'mobile_image_url'  => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
        'alt_text' => 'Elegant hotel suite bedroom with city view',
        'focal_position' => 'center',
    ],
    (object)[
        'id' => 0, 'badge' => 'STAY DIFFERENTLY',
        'headline' => 'Exceptional Spaces. Memorable Moments.',
        'description' => 'From relaxing getaways to business stays, find a space created around your lifestyle.',
        'cta1_text' => 'Find a Stay', 'cta1_url' => route('properties.index'),
        'cta2_text' => 'See Featured',  'cta2_url' => route('properties.index', ['sort' => 'featured']),
        'desktop_image_url' => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1600&q=80',
        'mobile_image_url'  => 'https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=800&q=80',
        'alt_text' => 'Spacious serviced apartment living area with natural light',
        'focal_position' => 'center',
    ],
];

$slides = $heroSlides->isEmpty() ? collect($defaultSlides) : $heroSlides;

// Homepage section settings
$showTypes    = Setting::get('section_types_show',    '1') == '1';
$showFeatured = Setting::get('section_featured_show', '1') == '1';
$showWhy      = Setting::get('section_why_show',      '1') == '1';
$showLatest   = Setting::get('section_latest_show',   '1') == '1';
$showCta      = Setting::get('section_cta_show',      '1') == '1';
$typesTitle   = Setting::get('section_types_title',   'Browse by Type');
$typesSub     = Setting::get('section_types_subtitle', "Find exactly the kind of stay you're looking for");
$featLabel    = Setting::get('section_featured_label', 'Hand-Picked');
$featTitle    = Setting::get('section_featured_title', 'Featured Properties');
$latestLabel  = Setting::get('section_latest_label',  'Available Now');
$latestTitle  = Setting::get('section_latest_title',  'Latest Properties');
$whyTitle     = Setting::get('section_why_title',     'The Onpointluxury Difference');
$whySub       = Setting::get('section_why_subtitle',  'Why Choose Us');
$ctaTitle     = Setting::get('section_cta_title',     'Ready to Book Your Luxury Stay?');
$ctaSub       = Setting::get('section_cta_subtitle',  'Browse our curated collection and book securely online in minutes.');
$ctaBtn1      = Setting::get('section_cta_btn1_text', 'Browse Properties');
$ctaBtn2      = Setting::get('section_cta_btn2_text', 'WhatsApp Us');
$defaultFeatures = [
    ['icon'=>'fas fa-shield-alt','title'=>'Verified Properties','desc'=>'Every property is personally inspected to meet our quality standards.'],
    ['icon'=>'fas fa-lock','title'=>'Secure Payments','desc'=>"Powered by Paystack — Nigeria's most trusted payment gateway."],
    ['icon'=>'fab fa-whatsapp','title'=>'24/7 WhatsApp Support','desc'=>'Real humans, instant responses. Chat with us anytime.'],
    ['icon'=>'fas fa-star','title'=>'Best Price Guarantee','desc'=>"Find a lower price elsewhere? We'll match it, no questions asked."],
];
$whyFeatures = json_decode(Setting::get('section_why_features', '[]'), true) ?: $defaultFeatures;
@endphp

{{-- ═══════════════════════════════════════ HERO ═══════════════════════════════════════ --}}
<section class="opl-hero" id="hero"
         aria-label="Homepage hero slideshow"
         x-data="oplHero()"
         x-init="init()"
         @mouseenter="pause()"
         @mouseleave="resume()"
         @focusin="pause()"
         @focusout="resume()"
         @touchstart.passive="onTouchStart($event)"
         @touchend.passive="onTouchEnd($event)"
         @keydown.left.prevent="prev()"
         @keydown.right.prevent="next()"
         tabindex="-1">

    {{-- ── Slide images ── --}}
    @foreach($slides as $i => $slide)
    @php
        $desktopImg = $slide->desktop_image_url ?? 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1600&q=80';
        $mobileImg  = $slide->mobile_image_url  ?? $desktopImg;
        $altText    = $slide->alt_text ?? ($slide->headline ?? 'Onpointluxury property');
        $focal      = $slide->focal_position ?? 'center';
        $focalClass = 'object-' . $focal;
    @endphp
    <div class="opl-slide {{ $i === 0 ? 'is-active' : '' }}" data-index="{{ $i }}" aria-hidden="{{ $i !== 0 ? 'true' : 'false' }}">
        {{-- Mobile image (portrait) --}}
        <picture>
            <source media="(max-width: 767px)" srcset="{{ $mobileImg }}">
            <img src="{{ $desktopImg }}"
                 alt="{{ $altText }}"
                 class="w-full h-full object-cover {{ $focalClass }}"
                 @if($i === 0) fetchpriority="high" loading="eager" @else loading="lazy" @endif
                 width="1600" height="900"
                 onerror="this.onerror=null;this.style.display='none'">
        </picture>
        <div class="opl-slide-overlay" aria-hidden="true"></div>
    </div>
    @endforeach

    {{-- ── Slide content (staggered text per slide) ── --}}
    <div class="absolute inset-0 z-10 flex flex-col justify-end pb-28 md:pb-36 lg:pb-44 pointer-events-none" aria-live="polite" aria-atomic="true">
        <div class="max-w-7xl mx-auto px-5 sm:px-6 lg:px-8 w-full">
            @foreach($slides as $i => $slide)
            <div class="opl-content {{ $i === 0 ? 'is-visible' : '' }} max-w-xl lg:max-w-2xl"
                 data-content="{{ $i }}"
                 style="{{ $i !== 0 ? 'display:none;' : '' }}">

                {{-- Badge --}}
                @if(!empty($slide->badge))
                <div class="opl-badge inline-flex items-center gap-2 mb-4 md:mb-5">
                    <span class="w-5 h-px bg-amber-400"></span>
                    <span class="text-amber-300 text-xs sm:text-sm font-semibold uppercase tracking-widest">{{ $slide->badge }}</span>
                </div>
                @endif

                {{-- Headline --}}
                <h1 class="opl-hl text-white font-black leading-tight mb-3 md:mb-4
                            text-3xl sm:text-4xl md:text-5xl lg:text-6xl">
                    @php
                        $parts = explode('|', $slide->headline ?? '', 2);
                    @endphp
                    @if(count($parts) === 2)
                        {{ $parts[0] }}<span class="text-amber-400">{{ $parts[1] }}</span>
                    @else
                        {{ $slide->headline }}
                    @endif
                </h1>

                {{-- Description --}}
                @if(!empty($slide->description))
                <p class="opl-desc text-gray-200 text-sm sm:text-base md:text-lg leading-relaxed mb-6 md:mb-8 max-w-lg">
                    {{ $slide->description }}
                </p>
                @endif

                {{-- CTAs --}}
                <div class="opl-ctas pointer-events-auto flex flex-wrap gap-3 sm:gap-4">
                    <a href="{{ $slide->cta1_url ?? route('properties.index') }}"
                       class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white font-bold
                              px-6 py-3.5 sm:px-8 rounded-xl text-sm sm:text-base transition-all duration-200
                              shadow-lg shadow-amber-500/30 hover:shadow-amber-400/40 hover:-translate-y-0.5 min-h-[44px]">
                        {{ $slide->cta1_text ?? 'Explore Properties' }}
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                    @if(!empty($slide->cta2_text))
                    <a href="{{ $slide->cta2_url ?? route('properties.index') }}"
                       class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-semibold
                              px-6 py-3.5 sm:px-8 rounded-xl text-sm sm:text-base transition-all duration-200
                              border border-white/30 hover:border-white/50 backdrop-blur-sm min-h-[44px]">
                        {{ $slide->cta2_text }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ── Arrow controls ── --}}
    @if($slides->count() > 1)
    <button class="opl-arrow opl-arrow-prev"
            @click="prev()" aria-label="Previous slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button class="opl-arrow opl-arrow-next"
            @click="next()" aria-label="Next slide">
        <i class="fas fa-chevron-right"></i>
    </button>
    @endif

    {{-- ── Dots + progress ── --}}
    <div class="absolute bottom-6 left-0 right-0 z-20 flex flex-col items-center gap-3 pointer-events-none">
        @if($slides->count() > 1)
        <div class="flex items-center gap-2 pointer-events-auto" role="tablist" aria-label="Slide navigation">
            @foreach($slides as $i => $slide)
            <button class="opl-dot {{ $i === 0 ? 'active' : '' }}"
                    data-dot="{{ $i }}"
                    @click="go({{ $i }})"
                    role="tab"
                    :aria-selected="{{ $i }} === current"
                    aria-label="Go to slide {{ $i + 1 }}">
            </button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Progress bar --}}
    <div class="opl-progress running" id="opl-progress-bar"
         style="animation-duration: 6000ms"></div>

</section>

{{-- ═══════════════════════════ SEARCH FORM (below hero on all screens) ═══════════════════════════ --}}
<div class="relative z-30 -mt-0 lg:-mt-14">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-5 lg:p-6">
            <form action="{{ route('properties.index') }}" method="GET" id="hero-search-form">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 lg:gap-4">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label for="hs-location" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Location</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3 top-1/2 -translate-y-1/2 text-amber-400 text-sm pointer-events-none"></i>
                            <input type="text" id="hs-location" name="location"
                                   placeholder="Lagos, Abuja, Port Harcourt..."
                                   value="{{ request('location') }}"
                                   autocomplete="off"
                                   class="w-full pl-9 pr-3 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label for="hs-checkin" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Check-in</label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-amber-400 text-sm pointer-events-none"></i>
                            <input type="date" id="hs-checkin" name="check_in"
                                   min="{{ date('Y-m-d') }}"
                                   value="{{ request('check_in') }}"
                                   class="w-full pl-9 pr-2 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label for="hs-checkout" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Check-out</label>
                        <div class="relative">
                            <i class="fas fa-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-amber-400 text-sm pointer-events-none"></i>
                            <input type="date" id="hs-checkout" name="check_out"
                                   value="{{ request('check_out') }}"
                                   class="w-full pl-9 pr-2 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent transition">
                        </div>
                    </div>
                    <div>
                        <label for="hs-guests" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Guests</label>
                        <div class="relative">
                            <i class="fas fa-users absolute left-3 top-1/2 -translate-y-1/2 text-amber-400 text-sm pointer-events-none"></i>
                            <select id="hs-guests" name="guests"
                                    class="w-full pl-9 pr-3 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent transition appearance-none">
                                @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ request('guests', 1) == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i === 1 ? 'Guest' : 'Guests' }}
                                </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 px-5 rounded-xl
                                       transition-all duration-200 flex items-center justify-center gap-2 text-sm
                                       shadow-md shadow-amber-500/30 hover:-translate-y-0.5 min-h-[44px]">
                            <i class="fas fa-search"></i> Search Stays
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ═══════════════════════════ TRUST STRIP ═══════════════════════════ --}}
<div class="bg-slate-900 border-t border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach([
                ['icon'=>'fas fa-shield-check','label'=>'Verified Properties','color'=>'text-amber-400'],
                ['icon'=>'fas fa-lock','label'=>'Secure Booking','color'=>'text-green-400'],
                ['icon'=>'fab fa-whatsapp','label'=>'24/7 WhatsApp Support','color'=>'text-green-400'],
                ['icon'=>'fas fa-award','label'=>'Best Price Guarantee','color'=>'text-amber-400'],
            ] as $trust)
            <div class="flex items-center gap-3">
                <i class="{{ $trust['icon'] }} {{ $trust['color'] }} text-lg flex-shrink-0"></i>
                <span class="text-gray-300 text-xs sm:text-sm font-medium">{{ $trust['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ═══════════════════════════ PROPERTY TYPES ═══════════════════════════ --}}
@if($showTypes && $propertyTypes->isNotEmpty())
<section class="py-14 lg:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $typesTitle }}</h2>
            <p class="text-gray-500 mt-2 text-sm sm:text-base">{{ $typesSub }}</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($propertyTypes->take(10) as $type)
            <a href="{{ route('properties.index', ['type' => $type->slug]) }}"
               class="bg-white rounded-2xl p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all duration-300 border border-gray-100 group">
                <div class="text-3xl mb-2">{{ $type->icon ?? '🏠' }}</div>
                <p class="font-semibold text-sm text-slate-800 group-hover:text-amber-500 transition-colors">{{ $type->name }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $type->properties_count }} {{ Str::plural('listing', $type->properties_count) }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════ FEATURED PROPERTIES ═══════════════════════════ --}}
@if($showFeatured && $featuredProperties->isNotEmpty())
<section class="py-14 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10 flex-wrap gap-3">
            <div>
                <p class="text-amber-500 font-semibold text-xs sm:text-sm uppercase tracking-widest mb-1">{{ $featLabel }}</p>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $featTitle }}</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="text-sm font-medium text-slate-500 hover:text-amber-500 flex items-center gap-1.5 transition-colors">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($featuredProperties as $property)
            @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════ HOW IT WORKS ═══════════════════════════ --}}
<section class="py-14 lg:py-20 bg-gray-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-amber-500 font-semibold text-xs sm:text-sm uppercase tracking-widest mb-2">Simple Process</p>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900">How Booking Works</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            @foreach([
                ['step'=>'01','icon'=>'fas fa-search','title'=>'Discover','desc'=>'Browse our curated selection of premium serviced apartments and hotel suites.'],
                ['step'=>'02','icon'=>'fas fa-calendar-alt','title'=>'Select Your Dates','desc'=>'Choose your check-in and check-out dates and number of guests.'],
                ['step'=>'03','icon'=>'fas fa-lock','title'=>'Book Securely','desc'=>'Pay safely via Paystack or confirm via WhatsApp with our team.'],
                ['step'=>'04','icon'=>'fas fa-star','title'=>'Enjoy Your Stay','desc'=>'Arrive to a fully prepared, premium space — ready just for you.'],
            ] as $step)
            <div class="relative text-center">
                <div class="w-14 h-14 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-amber-500/30">
                    <i class="{{ $step['icon'] }} text-white text-xl"></i>
                </div>
                <span class="absolute top-0 right-0 lg:right-auto lg:left-1/2 lg:-translate-x-1/2 -translate-y-1 text-xs font-black text-amber-200 bg-amber-500 rounded-full w-5 h-5 flex items-center justify-center">{{ $step['step'] }}</span>
                <h3 class="font-bold text-slate-900 mb-2">{{ $step['title'] }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════ WHY CHOOSE US ═══════════════════════════ --}}
@if($showWhy)
<section class="py-14 lg:py-20 bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 lg:mb-14">
            <p class="text-amber-400 font-semibold text-xs sm:text-sm uppercase tracking-widest mb-2">{{ $whySub }}</p>
            <h2 class="text-2xl sm:text-3xl font-black text-white">{{ $whyTitle }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($whyFeatures as $feat)
            <div class="text-center">
                <div class="w-14 h-14 bg-amber-500/15 border border-amber-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $feat['icon'] }} text-amber-400 text-xl"></i>
                </div>
                <h3 class="font-bold text-white mb-2 text-sm sm:text-base">{{ $feat['title'] }}</h3>
                <p class="text-sm text-gray-400 leading-relaxed">{{ $feat['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════ LATEST PROPERTIES ═══════════════════════════ --}}
@if($showLatest && $allProperties->isNotEmpty())
<section class="py-14 lg:py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10 flex-wrap gap-3">
            <div>
                <p class="text-amber-500 font-semibold text-xs sm:text-sm uppercase tracking-widest mb-1">{{ $latestLabel }}</p>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900">{{ $latestTitle }}</h2>
            </div>
            <a href="{{ route('properties.index') }}" class="text-sm font-medium text-slate-500 hover:text-amber-500 flex items-center gap-1.5 transition-colors">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($allProperties->take(6) as $property)
            @include('partials.property-card', ['property' => $property])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════ CTA BANNER ═══════════════════════════ --}}
@if($showCta)
<section class="py-16 lg:py-20 relative overflow-hidden bg-amber-500">
    <div class="absolute inset-0 opacity-10" style="background-image:url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800&q=60'); background-size:cover; background-position:center;"></div>
    <div class="relative max-w-3xl mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-4">{{ $ctaTitle }}</h2>
        <p class="text-amber-100 mb-8 text-sm sm:text-base leading-relaxed">{{ $ctaSub }}</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('properties.index') }}"
               class="bg-white text-amber-600 font-bold px-8 py-3.5 rounded-xl hover:bg-amber-50 transition-colors shadow-lg min-h-[44px] inline-flex items-center">
                {{ $ctaBtn1 }}
            </a>
            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener"
               class="bg-green-600 text-white font-bold px-8 py-3.5 rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2 shadow-lg min-h-[44px]">
                <i class="fab fa-whatsapp text-lg"></i> {{ $ctaBtn2 }}
            </a>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
function oplHero() {
    return {
        total: {{ $slides->count() }},
        current: 0,
        timer: null,
        paused: false,
        touchStartX: 0,
        autoplayMs: 6000,

        init() {
            if (this.total < 2) return;
            this.startTimer();
            document.addEventListener('visibilitychange', () => {
                document.hidden ? this.pause() : (this.paused || this.startTimer());
            });
        },

        startTimer() {
            this.clearTimer();
            // Reset progress bar
            const bar = document.getElementById('opl-progress-bar');
            if (bar) {
                bar.classList.remove('running');
                void bar.offsetWidth; // reflow
                bar.style.animationDuration = this.autoplayMs + 'ms';
                bar.classList.add('running');
            }
            this.timer = setTimeout(() => this.next(), this.autoplayMs);
        },

        clearTimer() {
            if (this.timer) { clearTimeout(this.timer); this.timer = null; }
            const bar = document.getElementById('opl-progress-bar');
            if (bar) bar.classList.remove('running');
        },

        pause() { this.clearTimer(); },

        resume() {
            if (!this.paused && this.total > 1) this.startTimer();
        },

        go(idx) {
            if (idx === this.current) return;
            const prev = this.current;
            this.current = ((idx % this.total) + this.total) % this.total;
            this._updateDOM(prev, this.current);
            this.clearTimer();
            if (!this.paused) this.startTimer();
        },

        prev() { this.go(this.current - 1); },
        next() { this.go(this.current + 1); },

        _updateDOM(prev, current) {
            // Slides
            document.querySelectorAll('.opl-slide').forEach((el, i) => {
                el.classList.toggle('is-active', i === current);
                el.classList.toggle('is-leaving', i === prev);
                el.setAttribute('aria-hidden', i !== current ? 'true' : 'false');
                setTimeout(() => el.classList.remove('is-leaving'), 1000);
            });
            // Content
            document.querySelectorAll('.opl-content').forEach((el, i) => {
                const isActive = i === current;
                el.style.display = isActive ? '' : 'none';
                el.classList.toggle('is-visible', isActive);
            });
            // Dots
            document.querySelectorAll('.opl-dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === current);
            });
        },

        onTouchStart(e) { this.touchStartX = e.changedTouches[0].screenX; },
        onTouchEnd(e) {
            const dx = e.changedTouches[0].screenX - this.touchStartX;
            if (Math.abs(dx) > 44) { dx < 0 ? this.next() : this.prev(); }
        },
    };
}

// Search: prevent checkout < checkin
document.getElementById('hs-checkin')?.addEventListener('change', function() {
    const out = document.getElementById('hs-checkout');
    if (out) { out.min = this.value; if (out.value && out.value < this.value) out.value = ''; }
});
</script>
@endpush
