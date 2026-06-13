@extends('layouts.admin')
@section('title','SMTP Settings') @section('page-title','SMTP Email Settings')
@section('content')
<div class="max-w-2xl space-y-6">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.smtp.update') }}">
@csrf
<div class="space-y-4">
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">SMTP Host</label>
<input type="text" name="smtp_host" value="{{ $settings['smtp_host'] ?? '' }}" placeholder="smtp.gmail.com" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">SMTP Port</label>
<input type="text" name="smtp_port" value="{{ $settings['smtp_port'] ?? '587' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
<input type="text" name="smtp_username" value="{{ $settings['smtp_username'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
<input type="password" name="smtp_password" value="{{ $settings['smtp_password'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Encryption</label>
<select name="smtp_encryption" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="tls" {{ ($settings['smtp_encryption']??'tls')=='tls'?'selected':'' }}>TLS</option>
<option value="ssl" {{ ($settings['smtp_encryption']??'')=='ssl'?'selected':'' }}>SSL</option>
<option value="" {{ ($settings['smtp_encryption']??'none')==''?'selected':'' }}>None</option>
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">From Name</label>
<input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? 'Onpointluxury' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">From Email</label>
<input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save SMTP Settings</button>
</div>
</form>
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Send Test Email</h3>
<form method="POST" action="{{ route('admin.settings.smtp.update') }}">
@csrf
<div class="flex gap-3">
<input type="email" name="test_email" placeholder="test@example.com" required class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm">
<button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">Send Test</button>
</div>
</form>
</div>
</div>
@endsection
