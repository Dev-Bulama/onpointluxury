@extends('layouts.admin')
@section('title','General Settings') @section('page-title','General Settings')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.general.update') }}" enctype="multipart/form-data">
@csrf
<div class="space-y-4">
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
<input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
<input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
<input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
<input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
<input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="2348012345678" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
<select name="currency" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="NGN" {{ ($settings['currency']??'NGN')=='NGN'?'selected':'' }}>NGN — Nigerian Naira</option>
<option value="USD" {{ ($settings['currency']??'')=='USD'?'selected':'' }}>USD — US Dollar</option>
</select></div>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
<textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $settings['address'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Google Map Embed Code</label>
<textarea name="google_map_embed" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['google_map_embed'] ?? '' }}</textarea></div>
<div class="grid sm:grid-cols-2 gap-4">
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
    @if(!empty($settings['logo']))
        @php $logoUrl = str_starts_with($settings['logo'],'http') ? $settings['logo'] : asset('storage/'.$settings['logo']); @endphp
        <img src="{{ $logoUrl }}" alt="Current logo" class="mb-2 max-h-16 object-contain bg-gray-50 border border-gray-200 rounded p-1">
    @endif
    <input type="file" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
    <p class="text-xs text-gray-400 mt-1">PNG or SVG with transparent background recommended.</p>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
    <input type="file" name="favicon" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
</div>
</div>
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Logo Size</label>
    <select name="logo_size" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <option value="h-8"  {{ ($settings['logo_size'] ?? 'h-10') == 'h-8'  ? 'selected' : '' }}>Small (32px)</option>
        <option value="h-10" {{ ($settings['logo_size'] ?? 'h-10') == 'h-10' ? 'selected' : '' }}>Medium (40px) — Default</option>
        <option value="h-12" {{ ($settings['logo_size'] ?? 'h-10') == 'h-12' ? 'selected' : '' }}>Large (48px)</option>
        <option value="h-14" {{ ($settings['logo_size'] ?? 'h-10') == 'h-14' ? 'selected' : '' }}>Extra Large (56px)</option>
        <option value="h-16" {{ ($settings['logo_size'] ?? 'h-10') == 'h-16' ? 'selected' : '' }}>2X Large (64px)</option>
    </select>
    <p class="text-xs text-gray-400 mt-1">Controls the logo height in the navigation bar and footer.</p>
</div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save Settings</button>
</div>
</form>
</div>

{{-- Hero Slides Manager --}}
@php
$heroSlides = json_decode($settings['hero_slides'] ?? '[]', true) ?: [];
@endphp
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mt-6" x-data="heroSlides({{ json_encode($heroSlides) }})">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="font-semibold text-gray-800">Hero Slideshow Images</h3>
            <p class="text-xs text-gray-400 mt-0.5">These images auto-slide on the homepage hero section.</p>
        </div>
        <button type="button" @click="addSlide()" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700">
            + Add Slide
        </button>
    </div>

    {{-- Slide list --}}
    <div class="space-y-3 mb-4">
        <template x-for="(slide, i) in slides" :key="i">
            <div class="flex gap-3 items-start p-3 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex-shrink-0 w-20 h-14 rounded overflow-hidden bg-gray-200">
                    <img :src="slide.url" class="w-full h-full object-cover"
                         x-show="slide.url"
                         onerror="this.style.display='none'">
                </div>
                <div class="flex-1 space-y-2">
                    <input type="text"
                           x-model="slide.url"
                           placeholder="https://... (image URL)"
                           class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:ring-2 focus:ring-blue-500">
                    <input type="text"
                           x-model="slide.caption"
                           placeholder="Caption (optional)"
                           class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm">
                </div>
                <button type="button" @click="removeSlide(i)"
                        class="text-red-400 hover:text-red-600 text-lg font-bold flex-shrink-0 mt-1">×</button>
            </div>
        </template>
        <p x-show="slides.length === 0" class="text-sm text-gray-400 text-center py-4">
            No slides added. Click "+ Add Slide" to add hero background images.
        </p>
    </div>

    <form method="POST" action="{{ route('admin.settings.general.update') }}">
        @csrf
        <input type="hidden" name="hero_slides" :value="JSON.stringify(slides)">
        <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-green-700">
            Save Hero Slides
        </button>
    </form>
</div>
</div>

<script>
function heroSlides(initial) {
    return {
        slides: initial.length ? initial : [],
        addSlide() {
            this.slides.push({ url: '', caption: '' });
        },
        removeSlide(i) {
            this.slides.splice(i, 1);
        }
    }
}
</script>
@endsection
