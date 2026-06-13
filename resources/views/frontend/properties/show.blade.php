@extends('layouts.app')
@section('title', $property->seo_title ?? $property->name . ' — Onpointluxury')
@section('meta_description', $property->seo_description ?? $property->short_description)

@section('content')
<div x-data="bookingApp()" x-init="init()">

<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-200 py-3 px-4">
    <div class="max-w-7xl mx-auto text-sm text-gray-500 flex items-center gap-2">
        <a href="{{ route('home') }}" class="hover:text-amber-500">Home</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <a href="{{ route('properties.index') }}" class="hover:text-amber-500">Properties</a>
        <i class="fas fa-chevron-right text-xs"></i>
        <span class="text-gray-800">{{ $property->name }}</span>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid lg:grid-cols-3 gap-8">

        <!-- Main Content -->
        <div class="lg:col-span-2">

            <!-- Gallery -->
            @php
                $mainImg = $property->featured_image_url ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200&q=80';
                $fallback = 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=800&q=80';
            @endphp
            <div class="rounded-2xl overflow-hidden mb-6" x-data="{ activeImg: '{{ $mainImg }}' }">
                <div class="h-80 md:h-[420px] bg-gray-100 overflow-hidden rounded-2xl">
                    <img :src="activeImg"
                         alt="{{ $property->name }}"
                         class="w-full h-full object-cover"
                         onerror="this.onerror=null;this.src='{{ $fallback }}'">
                </div>
                @if($property->images->count())
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    <button @click="activeImg='{{ $mainImg }}'"
                            class="flex-shrink-0 w-20 h-16 rounded-xl overflow-hidden border-2 border-amber-500">
                        <img src="{{ $mainImg }}" class="w-full h-full object-cover"
                             onerror="this.onerror=null;this.src='{{ $fallback }}'">
                    </button>
                    @foreach($property->images as $img)
                    <button @click="activeImg='{{ $img->image_url }}'"
                            class="flex-shrink-0 w-20 h-16 rounded-xl overflow-hidden border-2 border-transparent hover:border-amber-400 transition-colors">
                        <img src="{{ $img->image_url }}" class="w-full h-full object-cover"
                             onerror="this.onerror=null;this.src='{{ $fallback }}'">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Title & Key Info -->
            <div class="mb-6">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-3">
                    <div>
                        @if($property->propertyType)
                        <span class="bg-amber-100 text-amber-700 text-xs font-semibold px-2.5 py-1 rounded-full mb-2 inline-block">{{ $property->propertyType->name }}</span>
                        @endif
                        <h1 class="text-2xl md:text-3xl font-black text-slate-900">{{ $property->name }}</h1>
                        <p class="text-gray-500 mt-1 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-amber-400"></i>
                            {{ $property->address ?? $property->location }}, {{ $property->city }}, {{ $property->country }}
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="flex items-center gap-1 justify-end">
                            @for($i=1;$i<=5;$i++)
                            <i class="fas fa-star text-sm {{ $i <= round($property->rating) ? 'text-amber-400' : 'text-gray-200' }}"></i>
                            @endfor
                            <span class="text-sm font-bold ml-1">{{ number_format($property->rating,1) }}</span>
                        </div>
                        <p class="text-xs text-gray-400">{{ $property->review_count }} reviews</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="flex flex-wrap gap-4 p-4 bg-gray-50 rounded-xl">
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-bed text-amber-400"></i> <strong>{{ $property->bedrooms }}</strong> Bedrooms
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-bath text-amber-400"></i> <strong>{{ $property->bathrooms }}</strong> Bathrooms
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-users text-amber-400"></i> Up to <strong>{{ $property->max_guests }}</strong> guests
                    </div>
                    @if($property->property_size)
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-expand-arrows-alt text-amber-400"></i> <strong>{{ $property->property_size }}</strong>
                    </div>
                    @endif
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-sign-in-alt text-amber-400"></i> Check-in <strong>{{ $property->check_in_time }}</strong>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-700">
                        <i class="fas fa-sign-out-alt text-amber-400"></i> Check-out <strong>{{ $property->check_out_time }}</strong>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-xl font-black text-slate-900 mb-3">About This Property</h2>
                <div class="text-gray-600 leading-relaxed text-sm prose max-w-none">
                    {!! nl2br(e($property->description)) !!}
                </div>
            </div>

            <!-- Amenities -->
            @if($property->amenities->count())
            <div class="mb-8">
                <h2 class="text-xl font-black text-slate-900 mb-4">Amenities</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($property->amenities as $amenity)
                    <div class="flex items-center gap-2 p-3 bg-gray-50 rounded-xl text-sm text-gray-700">
                        <i class="fas fa-check-circle text-green-500"></i> {{ $amenity->name }}
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Rooms -->
            @if($property->rooms->count())
            <div class="mb-8">
                <h2 class="text-xl font-black text-slate-900 mb-4">Available Rooms</h2>
                <div class="space-y-3">
                    @foreach($property->rooms->where('status','active') as $room)
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-amber-300 transition-colors">
                        <div class="flex items-center justify-between flex-wrap gap-3">
                            <div>
                                <h3 class="font-bold text-slate-800">{{ $room->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $room->room_type }} · {{ $room->beds }} bed(s) · {{ $room->max_guests }} guests max</p>
                            </div>
                            <div class="text-right">
                                <p class="font-black text-slate-900">₦{{ number_format($room->price_per_night, 0) }}<span class="text-xs font-normal text-gray-400">/night</span></p>
                                <button @click="selectRoom({{ $room->id }}, {{ $room->price_per_night }})"
                                        class="mt-1 bg-amber-500 text-white text-xs font-bold px-3 py-1.5 rounded-lg hover:bg-amber-600 transition-colors">
                                    Select Room
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Policies -->
            <div class="mb-8 grid sm:grid-cols-2 gap-4">
                @if($property->house_rules)
                <div class="bg-blue-50 rounded-xl p-4">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2"><i class="fas fa-list-ul text-blue-500"></i> House Rules</h3>
                    <p class="text-sm text-gray-600">{{ $property->house_rules }}</p>
                </div>
                @endif
                @if($property->cancellation_policy)
                <div class="bg-green-50 rounded-xl p-4">
                    <h3 class="font-bold text-slate-800 mb-2 flex items-center gap-2"><i class="fas fa-ban text-green-500"></i> Cancellation Policy</h3>
                    <p class="text-sm text-gray-600">{{ $property->cancellation_policy }}</p>
                </div>
                @endif
            </div>

            <!-- Reviews -->
            @if($property->reviews->count())
            <div class="mb-8">
                <h2 class="text-xl font-black text-slate-900 mb-4">
                    Guest Reviews
                    <span class="text-base font-normal text-gray-500 ml-2">{{ $property->review_count }} reviews</span>
                </h2>
                <div class="space-y-4">
                    @foreach($property->reviews->take(5) as $review)
                    <div class="border border-gray-100 rounded-xl p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-bold">{{ substr($review->reviewer_name ?? $review->user?->name ?? 'G', 0, 1) }}</span>
                                </div>
                                <span class="font-semibold text-sm">{{ $review->reviewer_name ?? $review->user?->name ?? 'Guest' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i=1;$i<=5;$i++)
                                <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Booking Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-20 space-y-4">

                <!-- Price Card -->
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                    <div class="mb-4">
                        @if($property->discount_price)
                        <span class="text-gray-400 line-through text-sm">₦{{ number_format($property->price_per_night, 0) }}</span>
                        <p class="text-3xl font-black text-slate-900">₦{{ number_format($property->discount_price, 0) }}<span class="text-sm font-normal text-gray-500">/night</span></p>
                        @else
                        <p class="text-3xl font-black text-slate-900">₦{{ number_format($property->price_per_night, 0) }}<span class="text-sm font-normal text-gray-500">/night</span></p>
                        @endif
                    </div>

                    <!-- Date Picker -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden mb-3">
                        <div class="grid grid-cols-2 divide-x divide-gray-200">
                            <div class="p-3">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Check-in</label>
                                <input type="date" x-model="checkIn" :min="today" @change="calculateTotal()"
                                       class="w-full text-sm font-semibold text-slate-800 focus:outline-none bg-transparent">
                            </div>
                            <div class="p-3">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Check-out</label>
                                <input type="date" x-model="checkOut" :min="checkIn || today" @change="calculateTotal()"
                                       class="w-full text-sm font-semibold text-slate-800 focus:outline-none bg-transparent">
                            </div>
                        </div>
                        <div class="border-t border-gray-200 p-3">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Guests</label>
                            <select x-model="guests" class="w-full text-sm font-semibold text-slate-800 focus:outline-none bg-transparent">
                                @for($i=1; $i<=$property->max_guests; $i++)
                                <option value="{{ $i }}">{{ $i }} Guest{{ $i > 1 ? 's' : '' }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div x-show="nights > 0" class="bg-gray-50 rounded-xl p-3 mb-3 text-sm space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>₦{{ number_format($property->effective_price, 0) }} × <span x-text="nights"></span> nights</span>
                            <span x-text="'₦' + subtotal.toLocaleString()"></span>
                        </div>
                        <div class="flex justify-between font-black text-slate-900 border-t border-gray-200 pt-2">
                            <span>Total</span>
                            <span x-text="'₦' + total.toLocaleString()"></span>
                        </div>
                    </div>

                    <!-- Book Now Button -->
                    <a :href="nights > 0 ? bookingUrl : '#'"
                       @click.prevent="nights > 0 ? window.location.href = bookingUrl : alert('Please select check-in and check-out dates')"
                       class="block w-full bg-amber-500 hover:bg-amber-600 text-white text-center font-bold py-3 rounded-xl transition-colors mb-3">
                        <i class="fas fa-calendar-check mr-2"></i>
                        <span x-text="nights > 0 ? 'Reserve — ₦' + total.toLocaleString() : 'Check Availability'"></span>
                    </a>

                    <!-- WhatsApp Button -->
                    <a :href="whatsappUrl" target="_blank"
                       class="block w-full bg-green-600 hover:bg-green-700 text-white text-center font-bold py-3 rounded-xl transition-colors flex items-center justify-center gap-2">
                        <i class="fab fa-whatsapp text-lg"></i> WhatsApp Inquiry
                    </a>

                    <p class="text-center text-xs text-gray-400 mt-3">No charges until confirmation</p>
                </div>

                <!-- Manager Info -->
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-sm text-slate-800 mb-3">Property Managed By</h3>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ substr($property->manager?->name ?? 'OPL', 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ $property->manager?->name ?? 'Onpointluxury Team' }}</p>
                            <p class="text-xs text-gray-400">Verified Host</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Similar Properties -->
    @if($similar->count())
    <div class="mt-12 pt-8 border-t border-gray-100">
        <h2 class="text-2xl font-black text-slate-900 mb-6">Similar Properties</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($similar as $prop)
            @include('partials.property-card', ['property' => $prop])
            @endforeach
        </div>
    </div>
    @endif
</div>

</div>
@endsection

@push('scripts')
<script>
function bookingApp() {
    return {
        checkIn: '',
        checkOut: '',
        guests: 1,
        nights: 0,
        subtotal: 0,
        total: 0,
        today: new Date().toISOString().split('T')[0],
        pricePerNight: {{ $property->effective_price }},
        propertyId: {{ $property->id }},
        propertyName: @json($property->name),
        propertyLocation: @json($property->location . ', ' . $property->city),
        whatsappNumber: @json($whatsappNumber),

        get bookingUrl() {
            return `/booking/${this.propertyId}?check_in=${this.checkIn}&check_out=${this.checkOut}&guests=${this.guests}`;
        },

        get whatsappUrl() {
            let msg = `Hello, I am interested in booking ${this.propertyName}.\n\nProperty: ${this.propertyName}\nLocation: ${this.propertyLocation}\nPrice: ₦${this.pricePerNight.toLocaleString()} per night`;
            if (this.checkIn) msg += `\nCheck-in: ${this.checkIn}`;
            if (this.checkOut) msg += `\nCheck-out: ${this.checkOut}`;
            msg += `\nGuests: ${this.guests}`;
            if (this.total > 0) msg += `\nEstimated Total: ₦${this.total.toLocaleString()}`;
            msg += `\nProperty Link: ${window.location.href}\n\nPlease confirm availability.`;
            return `https://wa.me/${this.whatsappNumber}?text=${encodeURIComponent(msg)}`;
        },

        init() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('check_in')) { this.checkIn = params.get('check_in'); }
            if (params.get('check_out')) { this.checkOut = params.get('check_out'); }
            if (params.get('guests')) { this.guests = parseInt(params.get('guests')); }
            this.calculateTotal();
        },

        calculateTotal() {
            if (this.checkIn && this.checkOut) {
                const d1 = new Date(this.checkIn);
                const d2 = new Date(this.checkOut);
                this.nights = Math.round((d2 - d1) / 86400000);
                if (this.nights > 0) {
                    this.subtotal = this.pricePerNight * this.nights;
                    this.total = this.subtotal;
                } else {
                    this.nights = 0; this.subtotal = 0; this.total = 0;
                }
            }
        },

        selectRoom(roomId, price) {
            this.pricePerNight = price;
            this.calculateTotal();
        }
    }
}
</script>
@endpush
