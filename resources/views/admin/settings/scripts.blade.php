@extends('layouts.admin')
@section('title','Script Settings') @section('page-title','Scripts & Integrations')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<div class="bg-orange-50 border border-orange-200 rounded-lg p-3 mb-5 text-sm text-orange-800">
<i class="fas fa-exclamation-triangle mr-2"></i>Only add scripts from trusted providers. Malicious scripts can compromise your site.
</div>
<form method="POST" action="{{ route('admin.settings.scripts.update') }}">
@csrf
<div class="space-y-5">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Google Analytics / Tag Manager</label>
<textarea name="google_analytics" rows="4" placeholder="<!-- Google tag (gtag.js) -->" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['google_analytics'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Facebook Pixel</label>
<textarea name="facebook_pixel" rows="4" placeholder="<!-- Facebook Pixel Code -->" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['facebook_pixel'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Chatbot Script (Tawk.to / Crisp / Intercom)</label>
<textarea name="chatbot_script" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['chatbot_script'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Custom Header Scripts (injected before &lt;/head&gt;)</label>
<textarea name="header_scripts" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['header_scripts'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Custom Footer Scripts (injected before &lt;/body&gt;)</label>
<textarea name="footer_scripts" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['footer_scripts'] ?? '' }}</textarea></div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save Scripts</button>
</div>
</form>
</div>
</div>
@endsection
