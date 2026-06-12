@extends('layouts.app')

@section('title', 'My Dashboard — Onpointluxury')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">
                Welcome back, <span class="text-amber-500">{{ auth()->user()->name }}</span>
            </h1>
            <p class="text-slate-500 mt-1">Here's an overview of your bookings and activity.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            {{-- Total Bookings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-calendar-check text-amber-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Bookings</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $totalBookings }}</p>
                </div>
            </div>

            {{-- Upcoming Bookings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-blue-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Upcoming Stays</p>
                    <p class="text-3xl font-bold text-slate-900">{{ $upcomingBookings }}</p>
                </div>
            </div>

            {{-- Total Spent --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-naira-sign text-green-500 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-slate-500 font-medium">Total Spent</p>
                    <p class="text-3xl font-bold text-slate-900">₦{{ number_format($totalSpent) }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Recent Bookings --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Recent Bookings</h2>
                    <a href="{{ route('client.bookings') }}" class="text-sm text-amber-500 hover:text-amber-600 font-medium">
                        View all <i class="fas fa-arrow-right ml-1 text-xs"></i>
                    </a>
                </div>

                @if($recentBookings->isEmpty())
                    <div class="px-6 py-12 text-center">
                        <i class="fas fa-calendar-xmark text-slate-300 text-4xl mb-3"></i>
                        <p class="text-slate-500 font-medium">No bookings yet</p>
                        <p class="text-slate-400 text-sm mt-1">Your recent bookings will appear here.</p>
                        <a href="{{ route('properties.index') }}" class="inline-block mt-4 px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-lg transition">
                            Browse Properties
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wide">
                                <tr>
                                    <th class="px-6 py-3 text-left">Reference</th>
                                    <th class="px-6 py-3 text-left">Property</th>
                                    <th class="px-6 py-3 text-left hidden md:table-cell">Dates</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($recentBookings as $booking)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 font-mono font-medium text-slate-800">
                                        <a href="{{ route('client.booking-show', $booking) }}" class="hover:text-amber-500">
                                            {{ $booking->booking_reference }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 max-w-[160px] truncate">
                                        {{ $booking->property->name ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 hidden md:table-cell whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }}
                                        – {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'confirmed'  => 'bg-green-100 text-green-700',
                                                'pending'    => 'bg-amber-100 text-amber-700',
                                                'cancelled'  => 'bg-red-100 text-red-700',
                                                'completed'  => 'bg-blue-100 text-blue-700',
                                            ];
                                            $color = $statusColors[$booking->booking_status] ?? 'bg-slate-100 text-slate-600';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $color }}">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-semibold text-slate-800">
                                        ₦{{ number_format($booking->total_amount) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Quick Links --}}
            <div class="space-y-4">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Quick Links</h2>
                    <nav class="space-y-2">
                        <a href="{{ route('client.bookings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-50 text-slate-700 hover:text-amber-600 transition group">
                            <i class="fas fa-calendar-alt w-5 text-center text-slate-400 group-hover:text-amber-500"></i>
                            <span class="font-medium">My Bookings</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-slate-300 group-hover:text-amber-400"></i>
                        </a>
                        <a href="{{ route('client.favorites') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-50 text-slate-700 hover:text-amber-600 transition group">
                            <i class="fas fa-heart w-5 text-center text-slate-400 group-hover:text-amber-500"></i>
                            <span class="font-medium">Saved Properties</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-slate-300 group-hover:text-amber-400"></i>
                        </a>
                        <a href="{{ route('client.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-50 text-slate-700 hover:text-amber-600 transition group">
                            <i class="fas fa-user-circle w-5 text-center text-slate-400 group-hover:text-amber-500"></i>
                            <span class="font-medium">My Profile</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-slate-300 group-hover:text-amber-400"></i>
                        </a>
                        <a href="{{ route('properties.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-amber-50 text-slate-700 hover:text-amber-600 transition group">
                            <i class="fas fa-building w-5 text-center text-slate-400 group-hover:text-amber-500"></i>
                            <span class="font-medium">Browse Properties</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-slate-300 group-hover:text-amber-400"></i>
                        </a>
                    </nav>
                </div>

                {{-- Account Info --}}
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-full bg-amber-500 flex items-center justify-center font-bold text-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400 text-xs">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('client.profile') }}" class="block text-center text-sm font-semibold py-2 px-4 bg-amber-500 hover:bg-amber-600 rounded-lg transition">
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
