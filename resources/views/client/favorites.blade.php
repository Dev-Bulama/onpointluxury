@extends('layouts.app')

@section('title', 'Saved Properties — Onpointluxury')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">Saved Properties</h1>
                <p class="text-slate-500 mt-1">Properties you've marked as favourites.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition text-sm">
                <i class="fas fa-compass"></i> Explore Properties
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($favorites->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 px-6 py-20 text-center">
                <div class="w-20 h-20 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-5">
                    <i class="fas fa-heart-crack text-red-300 text-3xl"></i>
                </div>
                <h2 class="text-xl font-bold text-slate-800 mb-2">No saved properties yet</h2>
                <p class="text-slate-400 max-w-sm mx-auto mb-6">
                    Browse our premium properties and tap the heart icon to save the ones you love.
                </p>
                <a href="{{ route('properties.index') }}"
                    class="inline-flex items-center gap-2 px-7 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition">
                    <i class="fas fa-compass"></i> Explore Properties
                </a>
            </div>
        @else
            {{-- Properties Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $property)
                <div class="property-card bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group hover:shadow-md transition-shadow duration-300">

                    {{-- Image --}}
                    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
                        @if($property->featured_image)
                            <img src="{{ asset('storage/' . $property->featured_image) }}"
                                alt="{{ $property->name }}"
                                class="property-img w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-slate-300 text-4xl"></i>
                            </div>
                        @endif

                        {{-- Remove button --}}
                        <div class="absolute top-3 right-3">
                            <form method="POST" action="{{ route('client.favorites.remove') }}"
                                x-data="{ loading: false }"
                                @submit="loading = true">
                                @csrf
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                <button type="submit"
                                    x-bind:class="loading ? 'opacity-50 cursor-wait' : 'hover:bg-red-500 hover:text-white hover:border-red-500'"
                                    class="w-9 h-9 rounded-full bg-white border border-slate-200 text-red-400 flex items-center justify-center transition shadow-sm"
                                    title="Remove from favourites">
                                    <i class="fas fa-heart text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-1 group-hover:text-amber-600 transition">
                            {{ $property->name }}
                        </h3>
                        <p class="text-slate-400 text-xs mt-1 mb-3">
                            <i class="fas fa-map-marker-alt text-amber-400 mr-1"></i>
                            {{ $property->location }}{{ $property->city ? ', ' . $property->city : '' }}
                        </p>

                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-amber-600 font-bold text-lg">₦{{ number_format($property->effective_price) }}</span>
                                <span class="text-slate-400 text-xs"> / night</span>
                            </div>
                            <a href="{{ route('properties.show', $property->slug) }}"
                                class="px-4 py-1.5 bg-slate-900 hover:bg-amber-500 text-white text-xs font-semibold rounded-lg transition">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($favorites->hasPages())
                <div class="mt-8">
                    {{ $favorites->links() }}
                </div>
            @endif
        @endif

    </div>
</div>
@endsection
