@extends('layouts.admin')
@section('title','General Settings') @section('page-title','General Settings')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.general.update') }}" enctype="multipart/form-data">
@csrf
<div class="space-y-4">
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
<input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
<input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
<input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
<input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Number</label>
<input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="2348012345678" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
<select name="currency" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="NGN" {{ ($settings['currency']??'NGN')=='NGN'?'selected':'' }}>NGN — Nigerian Naira</option>
<option value="USD" {{ ($settings['currency']??'')=='USD'?'selected':'' }}>USD — US Dollar</option>
</select></div>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
<textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $settings['address'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Google Map Embed Code</label>
<textarea name="google_map_embed" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['google_map_embed'] ?? '' }}</textarea></div>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
@if(!empty($settings['logo']))<img src="{{ asset('storage/'.$settings['logo']) }}" class="h-12 mb-2">@endif
<input type="file" name="logo" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Favicon</label>
<input type="file" name="favicon" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs"></div>
</div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save Settings</button>
</div>
</form>
</div>
</div>
@endsection
