@extends('layouts.admin')

@section('title', 'Manager Dashboard')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Manager Dashboard</h1>
        <p class="text-gray-400 text-sm mt-1">Welcome back, {{ auth()->user()->name }}</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <div class="bg-navy-sidebar rounded-xl p-5 border border-white/5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-amber-500/20 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-building text-amber-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wide">Assigned Properties</p>
                <p class="text-3xl font-bold text-white">{{ $assignedProperties }}</p>
            </div>
        </div>

        <div class="bg-navy-sidebar rounded-xl p-5 border border-white/5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-calendar-check text-green-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wide">Active Bookings</p>
                <p class="text-3xl font-bold text-white">{{ $activeBookings }}</p>
            </div>
        </div>

        <div class="bg-navy-sidebar rounded-xl p-5 border border-white/5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-lg bg-yellow-500/20 flex items-center justify-center flex-shrink-0">
                <i class="fas fa-clock text-yellow-400 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs uppercase tracking-wide">Pending Bookings</p>
                <p class="text-3xl font-bold text-white">{{ $pendingBookings }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="bg-navy-sidebar rounded-xl border border-white/5">
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h2 class="text-white font-semibold">Recent Bookings</h2>
            <a href="{{ route('manager.bookings') }}" class="text-amber-400 hover:text-amber-300 text-sm transition-colors">
                View All <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Reference</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Property</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Guest</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Check-in</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Amount</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($recentBookings as $booking)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4 text-amber-400 font-mono font-medium">{{ $booking->reference }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $booking->property->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-300">{{ $booking->user->name ?? $booking->guest_name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-gray-300">₦{{ number_format($booking->total_amount ?? 0) }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'confirmed' => 'bg-green-500/20 text-green-400',
                                    'pending'   => 'bg-yellow-500/20 text-yellow-400',
                                    'cancelled' => 'bg-red-500/20 text-red-400',
                                    'completed' => 'bg-blue-500/20 text-blue-400',
                                ];
                                $color = $statusColors[$booking->status] ?? 'bg-gray-500/20 text-gray-400';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <i class="fas fa-calendar-times text-3xl mb-2 block"></i>
                            No recent bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
        <a href="{{ route('manager.properties') }}"
           class="flex items-center gap-3 bg-navy-sidebar border border-white/5 rounded-xl p-4 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all group">
            <i class="fas fa-building text-amber-400 text-lg"></i>
            <div>
                <p class="text-white text-sm font-medium group-hover:text-amber-400 transition-colors">My Properties</p>
                <p class="text-gray-500 text-xs">Manage your assigned properties</p>
            </div>
            <i class="fas fa-chevron-right text-gray-600 ml-auto group-hover:text-amber-400 transition-colors"></i>
        </a>

        <a href="{{ route('manager.bookings') }}"
           class="flex items-center gap-3 bg-navy-sidebar border border-white/5 rounded-xl p-4 hover:border-amber-500/30 hover:bg-amber-500/5 transition-all group">
            <i class="fas fa-calendar-alt text-amber-400 text-lg"></i>
            <div>
                <p class="text-white text-sm font-medium group-hover:text-amber-400 transition-colors">All Bookings</p>
                <p class="text-gray-500 text-xs">View and manage booking requests</p>
            </div>
            <i class="fas fa-chevron-right text-gray-600 ml-auto group-hover:text-amber-400 transition-colors"></i>
        </a>
    </div>
</div>
@endsection
