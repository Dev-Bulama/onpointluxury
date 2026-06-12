@extends('layouts.admin')
@section('title','SEO Settings') @section('page-title','SEO Settings')
@section('content')
<div class="max-w-2xl">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.settings.seo.update') }}" enctype="multipart/form-data">
@csrf
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Title</label>
<input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Description</label>
<textarea name="meta_description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ $settings['meta_description'] ?? '' }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Default OG Image</label>
@if(!empty($settings['og_image']))<img src="{{ asset('storage/'.$settings['og_image']) }}" class="h-20 mb-2 rounded">@endif
<input type="file" name="og_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">robots.txt Content</label>
<textarea name="robots_txt" rows="5" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ $settings['robots_txt'] ?? "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /dashboard" }}</textarea></div>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save SEO Settings</button>
</div>
</form>
</div>
</div>
@endsection
