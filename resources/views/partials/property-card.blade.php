<div class="property-card bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300">
    <a href="{{ route('properties.show', $property->slug) }}" class="block relative overflow-hidden h-52">
        @php
            $imgSrc = $property->featured_image_url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80';
        @endphp
        <img src="{{ $imgSrc }}"
             alt="{{ $property->name }}"
             class="property-img w-full h-full object-cover"
             loading="lazy"
             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80'">
        @if($property->is_featured)
        <span class="absolute top-3 left-3 bg-amber-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">Featured</span>
        @endif
        @if($property->discount_price)
        <span class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">Sale</span>
        @endif
        @auth
        <button onclick="toggleFav({{ $property->id }}, this)" data-id="{{ $property->id }}"
                class="absolute bottom-3 right-3 w-8 h-8 bg-white/90 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors">
            <i class="fas fa-heart text-sm"></i>
        </button>
        @endauth
    </a>
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
