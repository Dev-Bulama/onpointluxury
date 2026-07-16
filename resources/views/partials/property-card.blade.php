@php
    $fallback = 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80';
    $mainImg  = $property->featured_image_url ?? $fallback;

    // Build slides array: featured first, then gallery
    $slides = collect([$mainImg]);
    if ($property->relationLoaded('images') && $property->images->count()) {
        foreach ($property->images->sortBy('sort_order') as $gi) {
            $url = $gi->image_url ?? $fallback;
            if ($url !== $mainImg) $slides->push($url);
        }
    }
    $slides = $slides->values();
    $cardId = 'pc-' . $property->id;
@endphp

<div class="property-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300">

    {{-- Image Carousel --}}
    <div class="relative h-52 overflow-hidden bg-gray-100"
         x-data="{
            idx: 0,
            slides: {{ $slides->toJson() }},
            timer: null,
            start() {
                if (this.slides.length > 1) {
                    this.timer = setInterval(() => { this.idx = (this.idx + 1) % this.slides.length; }, 3500);
                }
            },
            stop() { clearInterval(this.timer); },
            prev() { this.idx = (this.idx - 1 + this.slides.length) % this.slides.length; },
            next() { this.idx = (this.idx + 1) % this.slides.length; }
         }"
         x-init="start()"
         @mouseenter="stop()"
         @mouseleave="start()">

        {{-- Slides --}}
        <template x-for="(src, i) in slides" :key="i">
            <img :src="src"
                 :class="{'opacity-100': idx===i, 'opacity-0 absolute inset-0': idx!==i}"
                 class="w-full h-full object-cover transition-opacity duration-700"
                 loading="lazy"
                 :onerror="`this.onerror=null;this.src='${slides[0]||'{{ $fallback }}'}'`"
                 alt="{{ $property->name }}">
        </template>

        {{-- Nav dots (only if >1 slide) --}}
        <template x-if="slides.length > 1">
            <div class="absolute bottom-2 left-0 right-0 flex justify-center gap-1">
                <template x-for="(s, i) in slides" :key="i">
                    <button @click.prevent="idx=i; stop(); start()"
                            :class="idx===i ? 'bg-white' : 'bg-white/50'"
                            class="w-1.5 h-1.5 rounded-full transition-colors"></button>
                </template>
            </div>
        </template>

        {{-- Prev/Next arrows (only if >1 slide) --}}
        <template x-if="slides.length > 1">
            <div>
                <button @click.prevent="prev(); stop(); start()"
                        class="absolute left-2 top-1/2 -translate-y-1/2 w-7 h-7 bg-black/30 hover:bg-black/60 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">‹</button>
                <button @click.prevent="next(); stop(); start()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 w-7 h-7 bg-black/30 hover:bg-black/60 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition">›</button>
            </div>
        </template>

        {{-- Badges --}}
        @if($property->is_featured)
        <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full z-10">Featured</span>
        @endif
        @if($property->discount_price)
        <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full z-10">Sale</span>
        @endif

        {{-- Favourite button --}}
        @auth
        <button onclick="toggleFav({{ $property->id }}, this)" data-id="{{ $property->id }}"
                class="absolute bottom-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors z-10">
            <i class="fas fa-heart text-sm"></i>
        </button>
        @endauth

        {{-- Link overlay --}}
        <a href="{{ route('properties.show', $property->slug) }}" class="absolute inset-0 z-0"></a>
    </div>

    {{-- Card body --}}
    <div class="p-4">
        <div class="flex items-start justify-between gap-2 mb-1">
            <a href="{{ route('properties.show', $property->slug) }}" class="font-bold text-slate-800 hover:text-amber-500 transition-colors text-sm leading-tight line-clamp-1">{{ $property->name }}</a>
            <div class="flex items-center gap-1 flex-shrink-0">
                <i class="fas fa-star text-amber-400 text-xs"></i>
                <span class="text-xs font-semibold text-gray-700">{{ number_format($property->rating, 1) }}</span>
                <span class="text-xs text-gray-400">({{ $property->review_count }})</span>
            </div>
        </div>
        <p class="text-xs text-gray-500 mb-3 flex items-center gap-1">
            <i class="fas fa-map-marker-alt text-amber-400"></i> {{ $property->location }}, {{ $property->city }}
        </p>
        <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
            <span><i class="fas fa-bed mr-1"></i>{{ $property->bedrooms }} Bed{{ $property->bedrooms != 1 ? 's' : '' }}</span>
            <span><i class="fas fa-bath mr-1"></i>{{ $property->bathrooms }} Bath</span>
            <span><i class="fas fa-users mr-1"></i>{{ $property->max_guests }} Guests</span>
        </div>
        <div class="flex items-center justify-between">
            <div>
                @if($property->discount_price)
                <span class="text-xs text-gray-400 line-through">₦{{ number_format($property->price_per_night, 0) }}</span>
                <p class="font-black text-slate-900">₦{{ number_format($property->discount_price, 0) }}<span class="text-xs font-normal text-gray-400">/night</span></p>
                @else
                <p class="font-black text-slate-900">₦{{ number_format($property->price_per_night, 0) }}<span class="text-xs font-normal text-gray-400">/night</span></p>
                @endif
            </div>
            <a href="{{ route('properties.show', $property->slug) }}"
               class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors">
                Book Now
            </a>
        </div>
    </div>
</div>
