@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('content')

<!-- Stats Row 1 -->
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-5">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Properties</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total_properties'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-building text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Bookings Today</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['bookings_today'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-green-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Pending Payments</p>
                <p class="text-2xl font-bold text-orange-600 mt-1">{{ $stats['pending_payments'] ?? $stats['pending_bookings'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-clock text-orange-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Revenue</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">₦{{ number_format($stats['total_revenue'] ?? 0, 0) }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-coins text-yellow-600 text-xl"></i>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Users</p>
                <p class="text-2xl font-bold text-purple-600 mt-1">{{ $stats['total_users'] ?? 0 }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-purple-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row 2 -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 text-center">
        <p class="text-xs text-gray-500 mb-1">Confirmed</p>
        <p class="text-xl font-bold text-indigo-600">{{ $stats['confirmed_bookings'] ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 text-center">
        <p class="text-xs text-gray-500 mb-1">Paid</p>
        <p class="text-xl font-bold text-green-600">{{ $stats['paid_bookings'] ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 text-center">
        <p class="text-xs text-gray-500 mb-1">Clients</p>
        <p class="text-xl font-bold text-blue-600">{{ $stats['total_users'] ?? 0 }}</p>
    </div>
    <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 text-center">
        <p class="text-xs text-gray-500 mb-1">Pending Reviews</p>
        <p class="text-xl font-bold text-purple-600">{{ $stats['pending_reviews'] ?? 0 }}</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 mb-6">
    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
        <i class="fas fa-bolt text-yellow-500"></i> Quick Actions
    </h3>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.properties.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center gap-2">
            <i class="fas fa-plus"></i> Add Property
        </a>
        <a href="{{ route('admin.bookings.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition flex items-center gap-2">
            <i class="fas fa-calendar-plus"></i> New Booking
        </a>
        <a href="{{ route('admin.users.create') }}"
           class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition flex items-center gap-2">
            <i class="fas fa-user-plus"></i> Add User
        </a>
        <a href="{{ route('admin.blog.create') }}"
           class="bg-orange-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-orange-600 transition flex items-center gap-2">
            <i class="fas fa-pen"></i> Write Blog Post
        </a>
        <a href="{{ route('admin.settings.paystack') }}"
           class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800 transition flex items-center gap-2">
            <i class="fas fa-key"></i> Paystack Keys
        </a>
        <a href="{{ route('admin.settings.general') }}"
           class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition flex items-center gap-2">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-calendar-check text-green-500"></i> Recent Bookings
            </h3>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($recent_bookings ?? [] as $booking)
            <a href="{{ route('admin.bookings.show', $booking) }}" class="block p-4 hover:bg-gray-50 transition">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="font-medium text-sm text-gray-800">{{ $booking->booking_reference }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $booking->customer_name }} &middot; {{ $booking->property->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $booking->check_in_date?->format('d M') }} – {{ $booking->check_out_date?->format('d M Y') }}
                        </p>
                    </div>
                    <div class="text-right flex-shrink-0 ml-3">
                        <p class="text-sm font-bold text-gray-800">₦{{ number_format($booking->total_amount, 0) }}</p>
                        @php
                            $statusColors = [
                                'pending'   => 'yellow',
                                'confirmed' => 'blue',
                                'paid'      => 'green',
                                'cancelled' => 'red',
                                'reserved'  => 'indigo',
                                'completed' => 'teal',
                            ];
                            $sc = $statusColors[$booking->booking_status] ?? 'gray';
                        @endphp
                        <span class="inline-block mt-1 px-2 py-0.5 text-xs rounded-full font-medium
                            bg-{{ $sc }}-100 text-{{ $sc }}-700 capitalize">
                            {{ $booking->booking_status }}
                        </span>
                    </div>
                </div>
            </a>
            @empty
            <div class="p-10 text-center text-gray-400">
                <i class="fas fa-calendar-times text-3xl mb-2 opacity-40"></i>
                <p class="text-sm">No bookings yet</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Top Properties -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-500"></i> Top Properties
            </h3>
            <a href="{{ route('admin.properties.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($top_properties ?? [] as $property)
            <div class="p-4 flex items-center gap-4 hover:bg-gray-50 transition">
                <div class="w-11 h-11 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                    @if($property->featured_image)
                        <img src="{{ asset('storage/'.$property->featured_image) }}"
                             class="w-11 h-11 rounded-xl object-cover">
                    @else
                        <i class="fas fa-building text-blue-500"></i>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm text-gray-800 truncate">{{ $property->name }}</p>
                    <p class="text-xs text-gray-500">{{ $property->location }}, {{ $property->city }}</p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold text-gray-800">{{ $property->bookings_count ?? 0 }}</p>
                    <p class="text-xs text-gray-400">bookings</p>
                </div>
            </div>
            @empty
            <div class="p-10 text-center text-gray-400">
                <i class="fas fa-building text-3xl mb-2 opacity-40"></i>
                <p class="text-sm">No properties yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
