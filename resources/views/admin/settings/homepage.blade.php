@extends('layouts.admin')
@section('title','Homepage Settings') @section('page-title','Homepage Settings')
@section('content')
@php
$s = $settings; // shorthand
$get = fn($key, $default='') => $s[$key] ?? $default;
@endphp

<form method="POST" action="{{ route('admin.settings.homepage.update') }}" class="space-y-6 max-w-4xl">
@csrf

{{-- HERO --}}
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
    <h3 class="font-semibold text-gray-800 text-base mb-4 pb-2 border-b flex items-center gap-2">
        <i class="fas fa-image text-amber-500"></i> Hero Section
    </h3>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Badge Text <span class="text-gray-400 font-normal">(small label above heading)</span></label>
            <input type="text" name="hero_badge" value="{{ $get('hero_badge', "Nigeria's #1 Luxury Booking Platform") }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Main Heading</label>
            <input type="text" name="hero_title" value="{{ $get('hero_title', 'Find Your Perfect Luxury Stay in Nigeria') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <p class="text-xs text-gray-400 mt-1">Use | to split into two lines. Words after the pipe will be highlighted in amber.</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle Paragraph</label>
            <textarea name="hero_subtitle" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $get('hero_subtitle', 'Premium apartments, hotel suites, and serviced residences in Lagos, Abuja & Port Harcourt. Book securely, stay luxuriously.') }}</textarea>
        </div>
    </div>
</div>

{{-- PROPERTY TYPES --}}
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4 pb-2 border-b">
        <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
            <i class="fas fa-th-large text-blue-500"></i> Browse by Type Section
        </h3>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="section_types_show" value="0">
            <input type="checkbox" name="section_types_show" value="1" {{ $get('section_types_show','1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
            <span class="text-sm text-gray-600">Show on homepage</span>
        </label>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
            <input type="text" name="section_types_title" value="{{ $get('section_types_title','Browse by Type') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subheading</label>
            <input type="text" name="section_types_subtitle" value="{{ $get('section_types_subtitle','Find exactly the kind of stay you\'re looking for') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
    </div>
</div>

{{-- FEATURED PROPERTIES --}}
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4 pb-2 border-b">
        <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
            <i class="fas fa-star text-amber-500"></i> Featured Properties Section
        </h3>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="section_featured_show" value="0">
            <input type="checkbox" name="section_featured_show" value="1" {{ $get('section_featured_show','1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
            <span class="text-sm text-gray-600">Show on homepage</span>
        </label>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-gray-400 font-normal">(small text above heading)</span></label>
            <input type="text" name="section_featured_label" value="{{ $get('section_featured_label','Hand-Picked') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
            <input type="text" name="section_featured_title" value="{{ $get('section_featured_title','Featured Properties') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
    </div>
</div>

{{-- LATEST PROPERTIES --}}
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4 pb-2 border-b">
        <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
            <i class="fas fa-building text-slate-600"></i> Latest Properties Section
        </h3>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="section_latest_show" value="0">
            <input type="checkbox" name="section_latest_show" value="1" {{ $get('section_latest_show','1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
            <span class="text-sm text-gray-600">Show on homepage</span>
        </label>
    </div>
    <div class="grid sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
            <input type="text" name="section_latest_label" value="{{ $get('section_latest_label','Available Now') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
            <input type="text" name="section_latest_title" value="{{ $get('section_latest_title','Latest Properties') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
    </div>
</div>

{{-- WHY CHOOSE US --}}
@php
$defaultFeatures = [
    ['icon'=>'fas fa-shield-alt','title'=>'Verified Properties','desc'=>'Every property is personally inspected and verified to meet our international quality standards.'],
    ['icon'=>'fas fa-lock','title'=>'Secure Payments','desc'=>'All transactions are processed through Paystack, Nigeria\'s most trusted payment gateway.'],
    ['icon'=>'fab fa-whatsapp','title'=>'WhatsApp Support','desc'=>'24/7 direct support via WhatsApp. Real humans, instant responses, no bots.'],
    ['icon'=>'fas fa-star','title'=>'Best Price Guarantee','desc'=>'Find a lower price elsewhere? We\'ll match it. No questions asked.'],
];
$features = json_decode($get('section_why_features', '[]'), true) ?: $defaultFeatures;
@endphp
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100" x-data="whyFeatures({{ json_encode($features) }})">
    <div class="flex items-center justify-between mb-4 pb-2 border-b">
        <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i> Why Choose Us Section
        </h3>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="section_why_show" value="0">
            <input type="checkbox" name="section_why_show" value="1" {{ $get('section_why_show','1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
            <span class="text-sm text-gray-600">Show on homepage</span>
        </label>
    </div>
    <div class="grid sm:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
            <input type="text" name="section_why_title" value="{{ $get('section_why_title','The Onpointluxury Difference') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-gray-400 font-normal">(small text above)</span></label>
            <input type="text" name="section_why_subtitle" value="{{ $get('section_why_subtitle','Why Choose Us') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
    </div>

    <p class="text-xs font-medium text-gray-500 uppercase tracking-wide mb-3">Feature Cards</p>
    <div class="space-y-3" id="why-features-list">
        <template x-for="(feat, i) in features" :key="i">
            <div class="flex gap-3 items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex-1 grid sm:grid-cols-3 gap-2">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Icon Class <a href="https://fontawesome.com/icons" target="_blank" class="text-blue-500">(FA)</a></label>
                        <input type="text" x-model="feat.icon" placeholder="fas fa-star"
                               class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Title</label>
                        <input type="text" x-model="feat.title"
                               class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Description</label>
                        <input type="text" x-model="feat.desc"
                               class="w-full border border-gray-300 rounded px-2 py-1.5 text-xs">
                    </div>
                </div>
                <button type="button" @click="features.splice(i,1)" class="text-red-400 hover:text-red-600 font-bold text-lg mt-1">×</button>
            </div>
        </template>
    </div>
    <button type="button" @click="features.push({icon:'fas fa-check',title:'',desc:''})"
            class="mt-3 text-sm text-blue-600 hover:text-blue-800 font-medium">+ Add Feature Card</button>
    <input type="hidden" name="section_why_features" :value="JSON.stringify(features)">
</div>

{{-- CTA SECTION --}}
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
    <div class="flex items-center justify-between mb-4 pb-2 border-b">
        <h3 class="font-semibold text-gray-800 text-base flex items-center gap-2">
            <i class="fas fa-bullhorn text-amber-500"></i> Call-to-Action Section
        </h3>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="hidden" name="section_cta_show" value="0">
            <input type="checkbox" name="section_cta_show" value="1" {{ $get('section_cta_show','1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
            <span class="text-sm text-gray-600">Show on homepage</span>
        </label>
    </div>
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Heading</label>
            <input type="text" name="section_cta_title" value="{{ $get('section_cta_title','Ready to Book Your Luxury Stay?') }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
            <textarea name="section_cta_subtitle" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $get('section_cta_subtitle','Browse our curated collection and book securely online in minutes. Or chat with us directly on WhatsApp.') }}</textarea>
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Button 1 Text</label>
                <input type="text" name="section_cta_btn1_text" value="{{ $get('section_cta_btn1_text','Browse Properties') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Button 2 Text (WhatsApp)</label>
                <input type="text" name="section_cta_btn2_text" value="{{ $get('section_cta_btn2_text','WhatsApp Us') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
        </div>
    </div>
</div>

<div class="flex gap-3">
    <button type="submit" class="bg-blue-600 text-white px-8 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
        <i class="fas fa-save mr-1"></i> Save Homepage Settings
    </button>
    <a href="{{ route('home') }}" target="_blank" class="bg-gray-100 text-gray-700 px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-200 flex items-center gap-2">
        <i class="fas fa-external-link-alt"></i> Preview Homepage
    </a>
</div>
</form>

<script>
function whyFeatures(initial) {
    return { features: initial }
}
</script>
@endsection
