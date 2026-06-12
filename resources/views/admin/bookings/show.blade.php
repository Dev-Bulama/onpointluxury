@extends('layouts.admin')
@section('title','Booking Details') @section('page-title','Booking Details')
@section('content')
<div class="max-w-4xl">
<div class="flex items-center justify-between mb-6">
<a href="{{ route('admin.bookings.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-2 text-sm"><i class="fas fa-arrow-left"></i> Back to Bookings</a>
<span class="font-mono font-bold text-blue-600 text-lg">{{ $booking->booking_reference }}</span>
</div>
<div class="grid lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 space-y-5">
<!-- Property Info -->
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Property</h3>
<div class="flex gap-4">
@if($booking->property->featured_image)
<img src="{{ asset('storage/'.$booking->property->featured_image) }}" class="w-20 h-16 object-cover rounded-lg flex-shrink-0">
@endif
<div>
<p class="font-bold">{{ $booking->property->name }}</p>
<p class="text-sm text-gray-500">{{ $booking->property->location }}, {{ $booking->property->city }}</p>
<a href="{{ route('properties.show',$booking->property->slug) }}" target="_blank" class="text-xs text-blue-600 hover:underline">View Property</a>
</div>
</div>
</div>
<!-- Booking Info -->
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Booking Details</h3>
<div class="grid sm:grid-cols-2 gap-4 text-sm">
<div><p class="text-gray-500">Check-in</p><p class="font-semibold">{{ $booking->check_in_date?->format('D, d M Y') }}</p></div>
<div><p class="text-gray-500">Check-out</p><p class="font-semibold">{{ $booking->check_out_date?->format('D, d M Y') }}</p></div>
<div><p class="text-gray-500">Nights</p><p class="font-semibold">{{ $booking->nights }}</p></div>
<div><p class="text-gray-500">Guests</p><p class="font-semibold">{{ $booking->guests }}</p></div>
<div><p class="text-gray-500">Price/Night</p><p class="font-semibold">₦{{ number_format($booking->price_per_night,2) }}</p></div>
<div><p class="text-gray-500">Subtotal</p><p class="font-semibold">₦{{ number_format($booking->subtotal,2) }}</p></div>
@if($booking->tax > 0)<div><p class="text-gray-500">Tax</p><p class="font-semibold">₦{{ number_format($booking->tax,2) }}</p></div>@endif
@if($booking->service_charge > 0)<div><p class="text-gray-500">Service Charge</p><p class="font-semibold">₦{{ number_format($booking->service_charge,2) }}</p></div>@endif
<div class="sm:col-span-2 bg-gray-50 rounded-lg p-3"><div class="flex justify-between font-black"><span>Total Amount</span><span class="text-lg">₦{{ number_format($booking->total_amount,2) }}</span></div></div>
</div>
</div>
<!-- Guest Info -->
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Guest Information</h3>
<div class="grid sm:grid-cols-2 gap-4 text-sm">
<div><p class="text-gray-500">Name</p><p class="font-semibold">{{ $booking->customer_name }}</p></div>
<div><p class="text-gray-500">Email</p><p class="font-semibold">{{ $booking->customer_email }}</p></div>
<div><p class="text-gray-500">Phone</p><p class="font-semibold">{{ $booking->customer_phone ?? '—' }}</p></div>
<div><p class="text-gray-500">Source</p><p class="font-semibold capitalize">{{ $booking->source }}</p></div>
@if($booking->special_request)<div class="sm:col-span-2"><p class="text-gray-500">Special Request</p><p class="font-semibold">{{ $booking->special_request }}</p></div>@endif
</div>
</div>
<!-- Payments -->
@if($booking->payments->count())
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Payment History</h3>
@foreach($booking->payments as $payment)
<div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg mb-2">
<div><p class="text-sm font-mono">{{ $payment->paystack_reference }}</p><p class="text-xs text-gray-400">{{ $payment->paid_at?->format('d M Y H:i') ?? $payment->created_at->format('d M Y') }}</p></div>
<div class="text-right"><p class="font-bold">₦{{ number_format($payment->amount,2) }}</p>
<span class="text-xs px-2 py-0.5 {{ $payment->status==='success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} rounded-full">{{ $payment->status }}</span>
</div>
</div>
@endforeach
</div>
@endif
</div>
<!-- Sidebar -->
<div class="space-y-5">
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Status</h3>
<div class="space-y-3">
@php $bc=['pending'=>'yellow','confirmed'=>'blue','paid'=>'green','cancelled'=>'red','reserved'=>'indigo','checked_in'=>'emerald','checked_out'=>'gray']; $c=$bc[$booking->booking_status]??'gray'; @endphp
<div class="bg-{{ $c }}-50 border border-{{ $c }}-200 rounded-lg p-3 text-center">
<p class="text-{{ $c }}-700 font-bold capitalize">{{ str_replace('_',' ',$booking->booking_status) }}</p>
<p class="text-{{ $c }}-500 text-xs">Booking Status</p>
</div>
@php $pc=['pending'=>'yellow','paid'=>'green','failed'=>'red','refunded'=>'blue']; $pc2=$pc[$booking->payment_status]??'gray'; @endphp
<div class="bg-{{ $pc2 }}-50 border border-{{ $pc2 }}-200 rounded-lg p-3 text-center">
<p class="text-{{ $pc2 }}-700 font-bold capitalize">{{ $booking->payment_status }}</p>
<p class="text-{{ $pc2 }}-500 text-xs">Payment Status</p>
</div>
</div>
<form method="POST" action="{{ route('admin.bookings.status',$booking) }}" class="mt-4">
@csrf
<label class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
<select name="booking_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm mb-2">
@foreach(['pending','reserved','confirmed','paid','checked_in','checked_out','cancelled','refunded','expired'] as $s)
<option value="{{ $s }}" {{ $booking->booking_status==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
@endforeach
</select>
<button type="submit" class="w-full bg-gray-800 text-white py-2 rounded-lg text-sm hover:bg-gray-700">Update</button>
</form>
</div>
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 text-sm space-y-2">
<h3 class="font-semibold text-gray-800 mb-3">Quick Actions</h3>
<a href="https://wa.me/{{ preg_replace('/[^0-9]/','',$booking->customer_phone ?? '') }}" target="_blank"
   class="flex items-center gap-2 w-full bg-green-600 text-white py-2 px-3 rounded-lg hover:bg-green-700 text-sm">
<i class="fab fa-whatsapp"></i> WhatsApp Guest
</a>
<a href="mailto:{{ $booking->customer_email }}" class="flex items-center gap-2 w-full border border-gray-200 py-2 px-3 rounded-lg hover:bg-gray-50 text-sm">
<i class="fas fa-envelope text-blue-500"></i> Email Guest
</a>
</div>
</div>
</div>
</div>
@endsection
