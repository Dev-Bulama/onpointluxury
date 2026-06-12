@extends('layouts.app')

@section('title', 'My Bookings — Onpointluxury')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">My Bookings</h1>
                <p class="text-slate-500 mt-1">Manage and track all your reservations.</p>
            </div>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition text-sm">
                <i class="fas fa-plus"></i> New Booking
            </a>
        </div>

        {{-- Filters --}}
        <form method="GET" action="{{ route('client.bookings') }}" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Filter by Status</label>
                    <select name="status" onchange="this.form.submit()"
                        class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-400 bg-white">
                        <option value="">All Bookings</option>
                        @foreach(['pending','confirmed','completed','cancelled'] as $s)
                            <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-slate-500 mb-1">Filter by Payment</label>
                    <select name="payment_status" onchange="this.form.submit()"
                        class="w-full border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-400 bg-white">
                        <option value="">All Payments</option>
                        @foreach(['pending','paid','partially_paid','refunded'] as $ps)
                            <option value="{{ $ps }}" {{ request('payment_status') === $ps ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $ps)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @if(request()->hasAny(['status','payment_status']))
                    <div class="flex items-end">
                        <a href="{{ route('client.bookings') }}" class="px-4 py-2 text-sm text-slate-500 hover:text-slate-700 border border-slate-200 rounded-lg transition bg-white">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    </div>
                @endif
            </div>
        </form>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            @if($bookings->isEmpty())
                <div class="px-6 py-16 text-center">
                    <i class="fas fa-calendar-xmark text-slate-300 text-5xl mb-4"></i>
                    <p class="text-slate-600 font-semibold text-lg">No bookings found</p>
                    <p class="text-slate-400 text-sm mt-1 mb-5">
                        @if(request()->hasAny(['status','payment_status']))
                            Try adjusting your filters.
                        @else
                            You haven't made any bookings yet.
                        @endif
                    </p>
                    <a href="{{ route('properties.index') }}" class="inline-block px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl transition text-sm">
                        Browse Properties
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                            <tr>
                                <th class="px-5 py-3 text-left">Reference</th>
                                <th class="px-5 py-3 text-left">Property</th>
                                <th class="px-5 py-3 text-left hidden lg:table-cell">Check-in</th>
                                <th class="px-5 py-3 text-left hidden lg:table-cell">Check-out</th>
                                <th class="px-5 py-3 text-center hidden md:table-cell">Nights</th>
                                <th class="px-5 py-3 text-right hidden md:table-cell">Amount</th>
                                <th class="px-5 py-3 text-center">Payment</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($bookings as $booking)
                            @php
                                $bookingColors = [
                                    'confirmed' => 'bg-green-100 text-green-700',
                                    'pending'   => 'bg-amber-100 text-amber-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    'completed' => 'bg-blue-100 text-blue-700',
                                ];
                                $paymentColors = [
                                    'paid'           => 'bg-green-100 text-green-700',
                                    'pending'        => 'bg-amber-100 text-amber-700',
                                    'partially_paid' => 'bg-orange-100 text-orange-700',
                                    'refunded'       => 'bg-purple-100 text-purple-700',
                                ];
                                $bColor = $bookingColors[$booking->booking_status] ?? 'bg-slate-100 text-slate-600';
                                $pColor = $paymentColors[$booking->payment_status] ?? 'bg-slate-100 text-slate-600';
                            @endphp
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 font-mono font-medium text-slate-800 whitespace-nowrap">
                                    {{ $booking->booking_reference }}
                                </td>
                                <td class="px-5 py-4 text-slate-700">
                                    <div class="font-medium max-w-[140px] truncate">{{ $booking->property->name ?? '—' }}</div>
                                    <div class="text-xs text-slate-400 mt-0.5 md:hidden">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }}–{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                        &middot; {{ $booking->nights }}n
                                    </div>
                                    <div class="text-xs text-slate-400 mt-0.5 md:hidden font-semibold">
                                        ₦{{ number_format($booking->total_amount) }}
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-slate-500 hidden lg:table-cell whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-slate-500 hidden lg:table-cell whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                </td>
                                <td class="px-5 py-4 text-center text-slate-700 font-medium hidden md:table-cell">
                                    {{ $booking->nights }}
                                </td>
                                <td class="px-5 py-4 text-right font-semibold text-slate-800 hidden md:table-cell whitespace-nowrap">
                                    ₦{{ number_format($booking->total_amount) }}
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $pColor }}">
                                        {{ ucwords(str_replace('_', ' ', $booking->payment_status)) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $bColor }}">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('client.booking-show', $booking) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold rounded-lg transition">
                                        <i class="fas fa-eye"></i>
                                        <span class="hidden sm:inline">View</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($bookings->hasPages())
                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection
