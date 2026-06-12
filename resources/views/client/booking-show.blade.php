@extends('layouts.app')

@section('title', 'Booking ' . $booking->booking_reference . ' — Onpointluxury')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
            <a href="{{ route('client.dashboard') }}" class="hover:text-amber-500">Dashboard</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <a href="{{ route('client.bookings') }}" class="hover:text-amber-500">Bookings</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-slate-600 font-medium font-mono">{{ $booking->booking_reference }}</span>
        </nav>

        @php
            $bookingColors = [
                'confirmed' => 'bg-green-100 text-green-700 border-green-200',
                'pending'   => 'bg-amber-100 text-amber-700 border-amber-200',
                'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                'completed' => 'bg-blue-100 text-blue-700 border-blue-200',
            ];
            $paymentColors = [
                'paid'           => 'bg-green-100 text-green-700 border-green-200',
                'pending'        => 'bg-amber-100 text-amber-700 border-amber-200',
                'partially_paid' => 'bg-orange-100 text-orange-700 border-orange-200',
                'refunded'       => 'bg-purple-100 text-purple-700 border-purple-200',
            ];
            $bColor = $bookingColors[$booking->booking_status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
            $pColor = $paymentColors[$booking->payment_status] ?? 'bg-slate-100 text-slate-600 border-slate-200';
        @endphp

        {{-- Title row --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 font-mono">{{ $booking->booking_reference }}</h1>
                <p class="text-slate-500 text-sm mt-1">Booking confirmed on {{ $booking->created_at->format('d M Y') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="px-3 py-1.5 rounded-full text-sm font-semibold border {{ $bColor }}">
                    <i class="fas fa-circle text-[8px] mr-1"></i>{{ ucfirst($booking->booking_status) }}
                </span>
                <span class="px-3 py-1.5 rounded-full text-sm font-semibold border {{ $pColor }}">
                    <i class="fas fa-credit-card text-xs mr-1"></i>{{ ucwords(str_replace('_', ' ', $booking->payment_status)) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Property Card --}}
                @if($booking->property)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    @if($booking->property->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $booking->property->featured_image) }}"
                                alt="{{ $booking->property->name }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">{{ $booking->property->name }}</h2>
                                <p class="text-slate-500 text-sm mt-1">
                                    <i class="fas fa-map-marker-alt text-amber-500 mr-1"></i>
                                    {{ $booking->property->location }}{{ $booking->property->city ? ', ' . $booking->property->city : '' }}
                                </p>
                            </div>
                            <a href="{{ route('properties.show', $booking->property->slug) }}"
                                class="flex-shrink-0 text-xs font-semibold text-amber-500 hover:text-amber-600 border border-amber-200 hover:border-amber-400 px-3 py-1.5 rounded-lg transition">
                                View Property
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Stay Details --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-5">Stay Details</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-5">
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-wide">Check-in</p>
                            <p class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('D, d M Y') }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">From 12:00 PM</p>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-wide">Check-out</p>
                            <p class="font-semibold text-slate-900">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('D, d M Y') }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">By 11:00 AM</p>
                        </div>
                        <div class="bg-amber-50 rounded-xl p-4">
                            <p class="text-xs text-amber-600 font-medium mb-1 uppercase tracking-wide">Duration</p>
                            <p class="font-bold text-amber-700 text-xl">{{ $booking->nights }}</p>
                            <p class="text-xs text-amber-500 mt-0.5">Night{{ $booking->nights > 1 ? 's' : '' }}</p>
                        </div>

                        @if($booking->guests ?? false)
                        <div class="bg-slate-50 rounded-xl p-4">
                            <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-wide">Guests</p>
                            <p class="font-semibold text-slate-900">{{ $booking->guests }}</p>
                        </div>
                        @endif

                        @if($booking->special_requests ?? false)
                        <div class="bg-slate-50 rounded-xl p-4 col-span-2 sm:col-span-3">
                            <p class="text-xs text-slate-400 font-medium mb-1 uppercase tracking-wide">Special Requests</p>
                            <p class="text-slate-700 text-sm">{{ $booking->special_requests }}</p>
                        </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                {{-- Amount Breakdown --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Payment Summary</h3>
                    <div class="space-y-3 text-sm">
                        @if($booking->property)
                        <div class="flex justify-between text-slate-600">
                            <span>₦{{ number_format($booking->property->effective_price) }} &times; {{ $booking->nights }} night{{ $booking->nights > 1 ? 's' : '' }}</span>
                            <span class="font-medium">₦{{ number_format($booking->property->effective_price * $booking->nights) }}</span>
                        </div>
                        @endif
                        @if(($booking->service_fee ?? 0) > 0)
                        <div class="flex justify-between text-slate-600">
                            <span>Service fee</span>
                            <span class="font-medium">₦{{ number_format($booking->service_fee) }}</span>
                        </div>
                        @endif
                        @if(($booking->tax_amount ?? 0) > 0)
                        <div class="flex justify-between text-slate-600">
                            <span>Tax</span>
                            <span class="font-medium">₦{{ number_format($booking->tax_amount) }}</span>
                        </div>
                        @endif
                        <div class="border-t border-slate-100 pt-3 flex justify-between font-bold text-slate-900 text-base">
                            <span>Total</span>
                            <span class="text-amber-600">₦{{ number_format($booking->total_amount) }}</span>
                        </div>
                    </div>

                    {{-- Pay Now CTA --}}
                    @if($booking->payment_status !== 'paid')
                    <div class="mt-5 pt-4 border-t border-slate-100">
                        <div class="flex items-start gap-2 bg-amber-50 border border-amber-200 rounded-xl p-3 mb-4">
                            <i class="fas fa-exclamation-circle text-amber-500 mt-0.5 flex-shrink-0"></i>
                            <p class="text-xs text-amber-700">
                                Your payment is <strong>{{ ucwords(str_replace('_', ' ', $booking->payment_status)) }}</strong>. Complete payment to confirm your stay.
                            </p>
                        </div>
                        <a href="{{ route('payment.initiate', $booking->id) }}"
                            class="flex items-center justify-center gap-2 w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition text-sm">
                            <i class="fas fa-lock"></i> Pay Now — ₦{{ number_format($booking->total_amount) }}
                        </a>
                    </div>
                    @else
                    <div class="mt-4 flex items-center gap-2 bg-green-50 border border-green-200 rounded-xl px-4 py-3">
                        <i class="fas fa-check-circle text-green-500"></i>
                        <p class="text-sm font-medium text-green-700">Payment complete</p>
                    </div>
                    @endif
                </div>

                {{-- Support --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                    <h3 class="text-base font-semibold text-slate-900 mb-1">Need Help?</h3>
                    <p class="text-sm text-slate-500 mb-4">Reach out to our support team via WhatsApp for any booking-related queries.</p>
                    @php
                        $phone = preg_replace('/\D/', '', \App\Models\Setting::get('contact_phone', '2348000000000'));
                        $message = urlencode("Hello, I need help with booking reference: {$booking->booking_reference}");
                    @endphp
                    <a href="https://wa.me/{{ $phone }}?text={{ $message }}"
                        target="_blank" rel="noopener"
                        class="flex items-center justify-center gap-2 w-full py-3 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl transition text-sm">
                        <i class="fab fa-whatsapp text-lg"></i> WhatsApp Support
                    </a>
                </div>

                {{-- Back --}}
                <a href="{{ route('client.bookings') }}" class="flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 transition">
                    <i class="fas fa-arrow-left"></i> Back to all bookings
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
