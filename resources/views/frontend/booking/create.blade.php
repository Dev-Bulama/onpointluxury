@extends('layouts.app')
@section('title', 'Complete Your Booking — Onpointluxury')
@section('content')
<div class="bg-slate-900 py-10 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="flex items-center gap-3 text-gray-400 text-sm mb-4">
            <a href="{{ route('properties.show', $property->slug) }}" class="hover:text-amber-400">{{ $property->name }}</a>
            <i class="fas fa-chevron-right text-xs"></i>
            <span class="text-white">Complete Booking</span>
        </div>
        <h1 class="text-2xl font-black text-white">Complete Your Reservation</h1>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="grid lg:grid-cols-3 gap-8">

        <!-- Booking Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}">
                <input type="hidden" name="check_in_date" value="{{ $checkIn }}">
                <input type="hidden" name="check_out_date" value="{{ $checkOut }}">
                <input type="hidden" name="guests" value="{{ $guests }}">

                <!-- Your Details -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-lg font-black text-slate-900 mb-4">Your Details</h2>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                            @error('customer_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address *</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                            @error('customer_email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number *</label>
                            <input type="text" name="customer_phone" value="{{ old('customer_phone', auth()->user()?->phone) }}" required
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                            @error('customer_phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Special Requests (optional)</label>
                            <textarea name="special_request" rows="3" placeholder="Any special requirements, arrival time, etc."
                                      class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">{{ old('special_request') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-6" x-data="{ method: 'paystack' }">
                    <h2 class="text-lg font-black text-slate-900 mb-4">Payment Method</h2>
                    <input type="hidden" name="payment_method" :value="method">
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                               :class="method === 'paystack' ? 'border-amber-500 bg-amber-50' : 'border-gray-200 hover:border-amber-200'">
                            <input type="radio" x-model="method" value="paystack" class="w-4 h-4 text-amber-500">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-7 bg-blue-600 rounded flex items-center justify-center">
                                    <span class="text-white text-xs font-black">PAY</span>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-slate-800">Pay with Paystack</p>
                                    <p class="text-xs text-gray-500">Card, bank transfer, USSD, mobile money</p>
                                </div>
                                <div class="ml-auto flex gap-1">
                                    <div class="w-8 h-5 bg-blue-700 rounded text-white text-xs flex items-center justify-center font-bold">Visa</div>
                                    <div class="w-8 h-5 bg-red-500 rounded text-white text-xs flex items-center justify-center font-bold">MC</div>
                                </div>
                            </div>
                        </label>
                        @if(\App\Models\Setting::get('whatsapp_booking_enabled'))
                        <label class="flex items-center gap-3 p-4 border-2 rounded-xl cursor-pointer transition-colors"
                               :class="method === 'whatsapp' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-200'">
                            <input type="radio" x-model="method" value="whatsapp" class="w-4 h-4 text-green-500">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-10 h-7 bg-green-600 rounded flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-sm text-slate-800">Reserve via WhatsApp</p>
                                    <p class="text-xs text-gray-500">Contact us to arrange payment</p>
                                </div>
                            </div>
                        </label>
                        @endif
                    </div>
                </div>

                <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black py-4 rounded-2xl text-base transition-colors">
                    <i class="fas fa-lock mr-2"></i> Confirm Reservation
                </button>
                <p class="text-center text-xs text-gray-400 mt-3">
                    <i class="fas fa-shield-alt text-green-500 mr-1"></i>
                    Your payment is secured by Paystack. 256-bit SSL encryption.
                </p>
            </form>
        </div>

        <!-- Booking Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 sticky top-20">
                <h2 class="font-black text-slate-900 mb-4">Booking Summary</h2>

                @if($property->featured_image)
                <img src="{{ asset('storage/'.$property->featured_image) }}" alt="{{ $property->name }}"
                     class="w-full h-36 object-cover rounded-xl mb-4">
                @endif

                <h3 class="font-bold text-slate-800 text-sm">{{ $property->name }}</h3>
                <p class="text-xs text-gray-500 flex items-center gap-1 mt-1 mb-4">
                    <i class="fas fa-map-marker-alt text-amber-400"></i> {{ $property->location }}, {{ $property->city }}
                </p>

                <div class="space-y-3 text-sm border-t border-gray-100 pt-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Check-in</span>
                        <span class="font-semibold">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('D, d M Y') : '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Check-out</span>
                        <span class="font-semibold">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('D, d M Y') : '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Duration</span>
                        <span class="font-semibold">{{ $nights }} Night{{ $nights != 1 ? 's' : '' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Guests</span>
                        <span class="font-semibold">{{ $guests }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Price/Night</span>
                        <span class="font-semibold">₦{{ number_format($property->effective_price, 0) }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-3 flex justify-between">
                        <span class="font-black text-slate-900">Total</span>
                        <span class="font-black text-xl text-slate-900">₦{{ number_format($total, 0) }}</span>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-green-50 rounded-xl text-xs text-green-700 flex items-start gap-2">
                    <i class="fas fa-check-circle mt-0.5 flex-shrink-0"></i>
                    <span>Free cancellation up to 24 hours before check-in (subject to property policy)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
