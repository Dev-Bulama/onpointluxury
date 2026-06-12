@extends('layouts.admin')
@section('title','Paystack Settings') @section('page-title','Paystack Payment Settings')
@section('content')
<div class="max-w-2xl">
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-5 text-sm text-yellow-800">
<i class="fas fa-exclamation-triangle mr-2"></i>
<strong>Important:</strong> Keep your Secret Key private. Never expose it in frontend code.
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.paystack.update') }}">
@csrf
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Mode</label>
<select name="paystack_mode" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="test" {{ ($settings['paystack_mode']??'test')=='test'?'selected':'' }}>Test Mode</option>
<option value="live" {{ ($settings['paystack_mode']??'')=='live'?'selected':'' }}>Live Mode</option>
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Public Key</label>
<input type="text" name="paystack_public_key" value="{{ $settings['paystack_public_key'] ?? '' }}" placeholder="pk_test_..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
<input type="password" name="paystack_secret_key" value="{{ $settings['paystack_secret_key'] ?? '' }}" placeholder="sk_test_..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
<select name="paystack_currency" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="NGN" {{ ($settings['paystack_currency']??'NGN')=='NGN'?'selected':'' }}>NGN — Nigerian Naira</option>
<option value="GHS" {{ ($settings['paystack_currency']??'')=='GHS'?'selected':'' }}>GHS — Ghanaian Cedi</option>
</select></div>
<label class="flex items-center gap-2"><input type="checkbox" name="paystack_enabled" value="1" {{ ($settings['paystack_enabled']??1)?'checked':'' }} class="w-4 h-4 text-blue-600 rounded"><span class="text-sm text-gray-700">Enable Paystack Payments</span></label>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save Paystack Settings</button>
</div>
</form>
</div>
</div>
@endsection
