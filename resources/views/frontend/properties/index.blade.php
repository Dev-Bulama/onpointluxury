@extends('layouts.app')
@section('title', 'Browse Properties — Onpointluxury')
@section('content')

<div class="bg-slate-900 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-black text-white mb-2">Browse Properties</h1>
        <p class="text-gray-400">{{ $properties->total() }} properties available</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="flex flex-col lg:flex-row gap-8">

        <!-- Filter Sidebar -->
        <aside class="lg:w-72 flex-shrink-0" x-data="{ filtersOpen: false }">
            <div class="lg:hidden mb-4">
                <button @click="filtersOpen = !filtersOpen" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm font-semibold flex items-center justify-between">
                    <span><i class="fas fa-filter mr-2 text-amber-500"></i>Filters</span>
                    <i class="fas fa-chevron-down text-xs transition-transform" :class="filtersOpen ? 'rotate-180' : ''"></i>
                </button>
            </div>
            <form method="GET" action="{{ route('properties.index') }}" id="filterForm"
                  class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 space-y-6"
                  :class="{ 'hidden lg:block': !filtersOpen }" x-show="filtersOpen || window.innerWidth >= 1024" x-cloak>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Property name, area..."
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Location</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Lagos, Abuja..."
                           class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Property Type</label>
                    <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <option value="">All Types</option>
                        @foreach($propertyTypes as $type)
                        <option value="{{ $type->slug }}" {{ request('type') == $type->slug ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Category</label>
                    <select name="category" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Price Range (₦/night)</label>
                    <div class="grid grid-cols-2 gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                               class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                               class="border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Bedrooms</label>
                    <select name="bedrooms" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <option value="">Any</option>
                        @foreach([1,2,3,4,5] as $n)
                        <option value="{{ $n }}" {{ request('bedrooms') == $n ? 'selected' : '' }}>{{ $n }}+ Bedroom{{ $n > 1 ? 's' : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Guests</label>
                    <select name="guests" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <option value="">Any</option>
                        @foreach([1,2,3,4,5,6,8,10] as $n)
                        <option value="{{ $n }}" {{ request('guests') == $n ? 'selected' : '' }}>{{ $n }}+ Guests</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Amenities</label>
                    <div class="space-y-2 max-h-40 overflow-y-auto">
                        @foreach($amenities->take(12) as $amenity)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                   {{ in_array($amenity->id, request('amenities', [])) ? 'checked' : '' }}
                                   class="w-4 h-4 text-amber-500 rounded">
                            <span class="text-sm text-gray-700">{{ $amenity->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 rounded-xl text-sm transition-colors">
                        Apply Filters
                    </button>
                    <a href="{{ route('properties.index') }}" class="px-3 py-2.5 border border-gray-200 rounded-xl text-gray-500 hover:bg-gray-50 text-sm">
                        Clear
                    </a>
                </div>
            </form>
        </aside>

        <!-- Results -->
        <div class="flex-1">
            <!-- Sort Bar -->
            <div class="flex items-center justify-between mb-6 bg-white rounded-xl px-4 py-3 shadow-sm border border-gray-100">
                <p class="text-sm text-gray-600">
                    Showing <strong>{{ $properties->firstItem() }}–{{ $properties->lastItem() }}</strong> of <strong>{{ $properties->total() }}</strong> properties
                </p>
                <select name="sort" onchange="document.getElementById('filterForm').submit()"
                        class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest First</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                </select>
            </div>

            @if($properties->isEmpty())
            <div class="text-center py-20 bg-white rounded-2xl border border-gray-100">
                <i class="fas fa-search text-5xl text-gray-200 mb-4"></i>
                <h3 class="text-lg font-bold text-gray-700 mb-2">No properties found</h3>
                <p class="text-gray-400 text-sm mb-6">Try adjusting your filters or search terms</p>
                <a href="{{ route('properties.index') }}" class="bg-amber-500 text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-amber-600">Clear Filters</a>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($properties as $property)
                @include('partials.property-card', ['property' => $property])
                @endforeach
            </div>
            <div class="mt-8">{{ $properties->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
