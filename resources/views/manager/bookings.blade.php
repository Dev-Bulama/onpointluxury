@extends('layouts.admin')

@section('title', 'Property Bookings')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Property Bookings</h1>
        <p class="text-gray-400 text-sm mt-1">All bookings for your assigned properties</p>
    </div>

    {{-- Filters --}}
    <form method="GET" class="mb-5 flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search by reference or guest..."
               class="bg-navy-sidebar border border-white/10 text-gray-300 placeholder-gray-600 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-amber-500/50 w-64">

        <select name="status" class="bg-navy-sidebar border border-white/10 text-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:border-amber-500/50">
            <option value="">All Statuses</option>
            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-search mr-1.5"></i> Filter
        </button>

        @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('manager.bookings') }}" class="border border-white/10 text-gray-400 hover:text-white text-sm px-4 py-2 rounded-lg transition-colors">
            Clear
        </a>
        @endif
    </form>

    <div class="bg-navy-sidebar rounded-xl border border-white/5">
        <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-white font-semibold">Bookings</h2>
            <span class="text-gray-400 text-sm">{{ $bookings->total() ?? count($bookings) }} total</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Reference</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Property</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Guest</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Dates</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Amount</th>
                        <th class="text-left text-gray-400 font-medium px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($bookings as $booking)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-amber-400 font-mono font-medium text-xs">{{ $booking->reference }}</span>
                        </td>
                        <td class="px-6 py-4 text-gray-300">
                            {{ $booking->property->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-gray-300">{{ $booking->user->name ?? $booking->guest_name ?? '—' }}</p>
                            @if($booking->user->email ?? $booking->guest_email ?? null)
                            <p class="text-gray-500 text-xs">{{ $booking->user->email ?? $booking->guest_email }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">
                            <div>
                                <span class="text-gray-300">{{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}</span>
                            </div>
                            <div class="text-gray-500">
                                to {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                            </div>
                            @php
                                $nights = \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out));
                            @endphp
                            <div class="text-amber-400/70 text-xs">{{ $nights }} night{{ $nights != 1 ? 's' : '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-300 font-medium whitespace-nowrap">
                            ₦{{ number_format($booking->total_amount ?? 0) }}
                        </td>
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
                        <td colspan="6" class="px-6 py-14 text-center text-gray-500">
                            <i class="fas fa-calendar-times text-4xl mb-3 block opacity-30"></i>
                            <p class="font-medium">No bookings found.</p>
                            <p class="text-xs mt-1">Bookings for your properties will appear here.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($bookings, 'links') && $bookings->hasPages())
        <div class="px-6 py-4 border-t border-white/5">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
