@extends('layouts.admin')
@section('title','WhatsApp Settings') @section('page-title','WhatsApp Settings')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.whatsapp.update') }}">
@csrf
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
<input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="2348012345678 (no +, no spaces)" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<p class="text-xs text-gray-400 mt-1">Include country code without + sign. E.g., 2348012345678</p></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Default Inquiry Template</label>
<textarea name="whatsapp_template" rows="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['whatsapp_template'] ?? '' }}</textarea>
<p class="text-xs text-gray-400 mt-1">Available variables: {property}, {location}, {price}, {checkin}, {checkout}, {guests}</p></div>
<div class="space-y-2">
<label class="flex items-center gap-2"><input type="checkbox" name="whatsapp_inquiry_enabled" value="1" {{ ($settings['whatsapp_inquiry_enabled']??1)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Enable WhatsApp Inquiry Button</span></label>
<label class="flex items-center gap-2"><input type="checkbox" name="whatsapp_booking_enabled" value="1" {{ ($settings['whatsapp_booking_enabled']??1)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Enable Reserve via WhatsApp</span></label>
</div>
<button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700">Save WhatsApp Settings</button>
</div>
</form>
</div>
</div>
@endsection
