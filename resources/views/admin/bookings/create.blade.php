@extends('layouts.admin')
@section('title','New Booking') @section('page-title','New Booking')
@section('content')
<div class="max-w-2xl">
<a href="{{ route('admin.bookings.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.bookings.store') }}">
@csrf
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property *</label>
<select name="property_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">Select Property</option>
@foreach($properties as $p)<option value="{{ $p->id }}">{{ $p->name }} ({{ $p->location }})</option>@endforeach
</select></div>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Customer Name *</label>
<input type="text" name="customer_name" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Customer Email *</label>
<input type="email" name="customer_email" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
<input type="text" name="customer_phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Guests *</label>
<input type="number" name="guests" value="1" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Check-in *</label>
<input type="date" name="check_in_date" required min="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Check-out *</label>
<input type="date" name="check_out_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Booking Status</label>
<select name="booking_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
@foreach(['pending','reserved','confirmed','paid'] as $s)
<option value="{{ $s }}">{{ ucfirst($s) }}</option>
@endforeach
</select></div>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Special Request</label>
<textarea name="special_request" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea></div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Create Booking</button>
</div>
</form>
</div>
</div>
@endsection
