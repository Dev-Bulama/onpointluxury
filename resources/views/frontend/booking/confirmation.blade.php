@extends('layouts.app')
@section('title', 'Booking Confirmed — Onpointluxury')
@section('content')
<div class="min-h-screen bg-gray-50 py-16 px-4">
    <div class="max-w-2xl mx-auto">
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-green-500 text-4xl"></i>
            </div>
            <h1 class="text-3xl font-black text-slate-900">Booking {{ $booking->payment_status === 'paid' ? 'Confirmed' : 'Received' }}!</h1>
            <p class="text-gray-500 mt-2">Thank you, {{ $booking->customer_name }}. Your reservation details are below.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="bg-slate-900 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Booking Reference</p>
                        <p class="text-2xl font-black tracking-wider text-amber-400">{{ $booking->booking_reference }}</p>
                    </div>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold capitalize
                        @if($booking->booking_status === 'paid' || $booking->booking_status === 'confirmed') bg-green-500 text-white
                        @elseif($booking->booking_status === 'pending') bg-yellow-500 text-white
                        @else bg-gray-500 text-white @endif">
                        {{ $booking->booking_status }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                @if($booking->property->featured_image)
                <img src="{{ asset('storage/'.$booking->property->featured_image) }}" alt="{{ $booking->property->name }}"
                     class="w-full h-40 object-cover rounded-xl mb-4">
                @endif
                <h2 class="font-black text-lg text-slate-900 mb-1">{{ $booking->property->name }}</h2>
                <p class="text-gray-500 text-sm mb-6">{{ $booking->property->location }}, {{ $booking->property->city }}</p>

                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-gray-500 text-xs font-semibold uppercase mb-1">Check-in</p>
                        <p class="font-black text-slate-900">{{ $booking->check_in_date->format('D, d M Y') }}</p>
                        <p class="text-xs text-gray-400">From {{ $booking->property->check_in_time }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-gray-500 text-xs font-semibold uppercase mb-1">Check-out</p>
                        <p class="font-black text-slate-900">{{ $booking->check_out_date->format('D, d M Y') }}</p>
                        <p class="text-xs text-gray-400">By {{ $booking->property->check_out_time }}</p>
                    </div>
                    <div><p class="text-gray-500">Duration</p><p class="font-semibold">{{ $booking->nights }} night(s)</p></div>
                    <div><p class="text-gray-500">Guests</p><p class="font-semibold">{{ $booking->guests }}</p></div>
                    <div><p class="text-gray-500">Payment Status</p>
                        <span class="font-semibold capitalize {{ $booking->payment_status === 'paid' ? 'text-green-600' : 'text-orange-500' }}">
                            {{ $booking->payment_status }}
                        </span>
                    </div>
                    <div><p class="text-gray-500">Total Amount</p><p class="font-black text-xl text-slate-900">₦{{ number_format($booking->total_amount, 0) }}</p></div>
                </div>

                @if($booking->payment_status !== 'paid')
                <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <p class="text-sm text-yellow-800 font-semibold mb-3">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Payment Pending
                    </p>
                    <p class="text-sm text-yellow-700 mb-3">Your booking is reserved but not yet confirmed. Complete payment to confirm your stay.</p>
                    <a href="{{ route('payment.initiate', $booking->id) }}"
                       class="bg-amber-500 text-white font-bold px-4 py-2.5 rounded-xl text-sm hover:bg-amber-600 transition-colors inline-block">
                        <i class="fas fa-credit-card mr-2"></i>Pay Now — ₦{{ number_format($booking->total_amount, 0) }}
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap gap-3 justify-center">
            @if($booking->payment_status !== 'paid')
            <a href="{{ route('payment.initiate', $booking->id) }}" class="bg-amber-500 text-white font-bold px-6 py-3 rounded-xl hover:bg-amber-600 transition-colors">
                <i class="fas fa-credit-card mr-2"></i>Complete Payment
            </a>
            @endif
            <a href="https://wa.me/{{ \App\Models\Setting::get('whatsapp_number','2348012345678') }}?text={{ urlencode('Hello, I have a booking reference: '.$booking->booking_reference.'. Please assist me.') }}"
               target="_blank" class="bg-green-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-green-700 transition-colors flex items-center gap-2">
                <i class="fab fa-whatsapp text-lg"></i>WhatsApp Support
            </a>
            @auth
            <a href="{{ route('client.bookings') }}" class="bg-slate-900 text-white font-bold px-6 py-3 rounded-xl hover:bg-slate-800 transition-colors">
                View My Bookings
            </a>
            @endauth
            <a href="{{ route('home') }}" class="border border-gray-200 text-gray-600 font-bold px-6 py-3 rounded-xl hover:bg-gray-50 transition-colors">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
