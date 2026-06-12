@extends('layouts.admin')
@section('title','Booking Settings') @section('page-title','Booking Settings')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.booking.update') }}">
@csrf
<div class="space-y-4">
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Default Check-in Time</label>
<input type="time" name="default_checkin_time" value="{{ $settings['default_checkin_time'] ?? '14:00' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Default Check-out Time</label>
<input type="time" name="default_checkout_time" value="{{ $settings['default_checkout_time'] ?? '12:00' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Tax Percentage (%)</label>
<input type="number" name="tax_percentage" value="{{ $settings['tax_percentage'] ?? 0 }}" min="0" max="100" step="0.1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Service Charge (₦)</label>
<input type="number" name="service_charge" value="{{ $settings['service_charge'] ?? 0 }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Cancellation Window (hours)</label>
<input type="number" name="cancellation_window" value="{{ $settings['cancellation_window'] ?? 24 }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Auto-expire Unpaid (minutes)</label>
<input type="number" name="auto_expire_minutes" value="{{ $settings['auto_expire_minutes'] ?? 30 }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div>
<div class="space-y-2">
<label class="flex items-center gap-2"><input type="checkbox" name="guest_booking" value="1" {{ ($settings['guest_booking']??1)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Allow Guest (without account) Booking</span></label>
<label class="flex items-center gap-2"><input type="checkbox" name="require_login" value="1" {{ ($settings['require_login']??0)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Require Login Before Booking</span></label>
</div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save Booking Settings</button>
</div>
</form>
</div>
</div>
@endsection
