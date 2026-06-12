@extends('layouts.admin')
@section('title','Edit Page') @section('page-title','Edit Page')
@section('content')
<div class="max-w-4xl">
<a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<form method="POST" action="{{ route('admin.pages.update',$page) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="grid lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 space-y-5">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Page Title *</label>
<input type="text" name="title" value="{{ old('title',$page->title) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
<input type="text" name="slug" value="{{ old('slug',$page->slug) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
<textarea name="content" rows="14" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono text-xs">{{ old('content',$page->content) }}</textarea></div>
</div>
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">SEO</h3>
<div class="space-y-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
<input type="text" name="meta_title" value="{{ old('meta_title',$page->meta_title) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
<textarea name="meta_description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('meta_description',$page->meta_description) }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">OG Image</label>
@if(!empty($page->og_image))<img src="{{ asset('storage/'.$page->og_image) }}" class="h-20 mb-2 rounded">@endif
<input type="file" name="og_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
<p class="text-xs text-gray-400 mt-1">Leave blank to keep existing image.</p></div>
</div>
</div>
</div>
<div class="space-y-5">
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Options</h3>
<div class="space-y-3">
<label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" {{ old('is_published',$page->is_published)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Published</span></label>
<label class="flex items-center gap-2"><input type="checkbox" name="show_in_nav" value="1" {{ old('show_in_nav',$page->show_in_nav)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Show in Navigation</span></label>
</div>
<div class="mt-4 space-y-2">
<button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Update Page</button>
<a href="{{ route('admin.pages.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700">Cancel</a>
</div>
</div>
</div>
</div>
</form>
</div>
@endsection
