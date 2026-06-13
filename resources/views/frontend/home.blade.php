@extends('layouts.app')
@section('title', 'Onpointluxury — Premium Apartment & Hotel Bookings in Nigeria')

@section('content')

<!-- HERO SECTION -->
<section class="relative bg-slate-900 min-h-[88vh] flex items-center overflow-hidden">
    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1600')] bg-cover bg-center opacity-30"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-900/80"></div>
    <div class="relative max-w-7xl mx-auto px-4 py-24 w-full">
        <div class="max-w-3xl mb-10">
            <div class="inline-flex items-center gap-2 bg-amber-500/20 border border-amber-500/40 text-amber-300 text-sm px-4 py-2 rounded-full mb-6">
                <i class="fas fa-star text-amber-400"></i> Nigeria's #1 Luxury Booking Platform
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-tight mb-4">
                Find Your Perfect <span class="text-amber-400">Luxury Stay</span> in Nigeria
            </h1>
            <p class="text-lg text-gray-300 leading-relaxed">
                Premium apartments, hotel suites, and serviced residences in Lagos, Abuja & Port Harcourt. Book securely, stay luxuriously.
            </p>
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
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black text-slate-900">Browse by Type</h2>
            <p class="text-gray-500 mt-2">Find exactly the kind of stay you're looking for</p>
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

<!-- FEATURED PROPERTIES -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-amber-500 font-semibold text-sm uppercase tracking-wider mb-1">Hand-Picked</p>
                <h2 class="text-3xl font-black text-slate-900">Featured Properties</h2>
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

<!-- WHY BOOK WITH US -->
<section class="py-20 bg-slate-900">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-14">
            <p class="text-amber-400 font-semibold text-sm uppercase tracking-wider mb-2">Why Choose Us</p>
            <h2 class="text-3xl font-black text-white">The Onpointluxury Difference</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['icon'=>'fas fa-shield-alt','color'=>'amber','title'=>'Verified Properties','desc'=>'Every property is personally inspected and verified to meet our international quality standards.'],
                ['icon'=>'fas fa-lock','color'=>'green','title'=>'Secure Payments','desc'=>'All transactions are processed through Paystack, Nigeria\'s most trusted payment gateway.'],
                ['icon'=>'fab fa-whatsapp','color'=>'green','title'=>'WhatsApp Support','desc'=>'24/7 direct support via WhatsApp. Real humans, instant responses, no bots.'],
                ['icon'=>'fas fa-star','color'=>'amber','title'=>'Best Price Guarantee','desc'=>'Find a lower price elsewhere? We\'ll match it. No questions asked.'],
            ] as $feature)
            <div class="text-center">
                <div class="w-14 h-14 bg-{{ $feature['color'] }}-500/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $feature['icon'] }} text-{{ $feature['color'] }}-400 text-2xl"></i>
                </div>
                <h3 class="font-bold text-white mb-2">{{ $feature['title'] }}</h3>
                <p class="text-sm text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ALL PROPERTIES -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-amber-500 font-semibold text-sm uppercase tracking-wider mb-1">Available Now</p>
                <h2 class="text-3xl font-black text-slate-900">Latest Properties</h2>
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

<!-- TESTIMONIALS -->
@if($testimonials->count())
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <p class="text-amber-500 font-semibold text-sm uppercase tracking-wider mb-2">Guest Reviews</p>
            <h2 class="text-3xl font-black text-slate-900">What Our Guests Say</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials->take(6) as $t)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-1 mb-3">
                    @for($i=1;$i<=5;$i++)
                    <i class="fas fa-star text-sm {{ $i <= $t->rating ? 'text-amber-400' : 'text-gray-200' }}"></i>
                    @endfor
                </div>
                <p class="text-gray-700 text-sm leading-relaxed mb-4 italic">"{{ $t->comment }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-sm">{{ substr($t->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-semibold text-sm text-slate-800">{{ $t->name }}</p>
                        <p class="text-xs text-gray-400">{{ $t->title }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- BLOG SECTION -->
@if($blogPosts->count())
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-end justify-between mb-10">
            <div>
                <p class="text-amber-500 font-semibold text-sm uppercase tracking-wider mb-1">Insights</p>
                <h2 class="text-3xl font-black text-slate-900">From Our Blog</h2>
            </div>
            <a href="{{ route('blog.index') }}" class="text-sm font-medium text-slate-600 hover:text-amber-500 flex items-center gap-1">
                All Articles <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($blogPosts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="group">
                <div class="bg-slate-200 rounded-2xl overflow-hidden h-48 mb-4">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/'.$post->featured_image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center">
                        <i class="fas fa-newspaper text-white text-4xl opacity-50"></i>
                    </div>
                    @endif
                </div>
                <span class="text-xs text-amber-500 font-semibold uppercase">{{ $post->category }}</span>
                <h3 class="font-bold text-slate-900 mt-1 group-hover:text-amber-500 transition-colors leading-tight">{{ $post->title }}</h3>
                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $post->excerpt }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $post->published_at?->format('d M Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA SECTION -->
<section class="py-20 bg-amber-500">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white mb-4">Ready to Book Your Luxury Stay?</h2>
        <p class="text-amber-100 mb-8">Browse our curated collection and book securely online in minutes. Or chat with us directly on WhatsApp.</p>
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('properties.index') }}" class="bg-white text-amber-600 font-bold px-8 py-3 rounded-xl hover:bg-amber-50 transition-colors">
                Browse Properties
            </a>
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','2348012345678') }}" target="_blank"
               class="bg-green-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2">
                <i class="fab fa-whatsapp text-lg"></i> WhatsApp Us
            </a>
        </div>
    </div>
</section>

@endsection
@push('scripts')
<script>
document.getElementById('hero_checkin')?.addEventListener('change', function() {
    const checkout = document.getElementById('hero_checkout');
    if(checkout) checkout.min = this.value;
});
</script>
@endpush
