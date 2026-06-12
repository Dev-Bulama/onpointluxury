@extends('layouts.admin')

@section('title', 'My Properties')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">My Properties</h1>
        <p class="text-gray-400 text-sm mt-1">Properties assigned to your account</p>
    </div>

    <div class="bg-navy-sidebar rounded-xl border border-white/5">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-white font-semibold">All Properties</h2>
            <span class="text-gray-400 text-sm">{{ $properties->total() ?? count($properties) }} total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Property</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Location</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Status</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Bookings</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($properties as $property)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($property->featured_image)
                                <img src="{{ asset('storage/' . $property->featured_image) }}"
                                     alt="{{ $property->name }}"
                                     class="w-10 h-10 rounded-lg object-cover flex-shrink-0">
                                @else
                                <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-building text-gray-500"></i>
                                </div>
                                @endif
                                <div>
                                    <p class="text-white font-medium">{{ $property->name }}</p>
                                    <p class="text-gray-500 text-xs">{{ $property->type ?? 'Property' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-300">
                            <i class="fas fa-map-marker-alt text-amber-400 mr-1.5 text-xs"></i>
                            {{ $property->location ?? $property->city ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'active'      => 'bg-green-500/20 text-green-400',
                                    'inactive'    => 'bg-gray-500/20 text-gray-400',
                                    'maintenance' => 'bg-yellow-500/20 text-yellow-400',
                                ];
                                $color = $statusColors[$property->status] ?? 'bg-gray-500/20 text-gray-400';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                {{ ucfirst($property->status ?? 'unknown') }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-white font-medium">{{ $property->bookings_count ?? $property->bookings()->count() }}</span>
                            <span class="text-gray-500 text-xs ml-1">bookings</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('properties.show', $property->slug ?? $property->id) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 text-xs text-amber-400 hover:text-amber-300 transition-colors border border-amber-500/30 hover:border-amber-400 rounded-lg px-3 py-1.5">
                                <i class="fas fa-external-link-alt"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-14 text-center text-gray-500">
                            <i class="fas fa-building text-4xl mb-3 block opacity-30"></i>
                            <p class="font-medium">No properties assigned yet.</p>
                            <p class="text-xs mt-1">Contact an admin to have properties assigned to your account.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($properties, 'links') && $properties->hasPages())
        <div class="px-6 py-4 border-t border-white/5">
            {{ $properties->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
