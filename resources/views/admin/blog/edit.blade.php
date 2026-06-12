@extends('layouts.admin')
@section('title','Edit Blog Post') @section('page-title','Edit Blog Post')
@section('content')
<div class="max-w-4xl">
<a href="{{ route('admin.blog.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<form method="POST" action="{{ route('admin.blog.update',$blog) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="grid lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 space-y-5">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
<input type="text" name="title" value="{{ old('title',$blog->title) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
<textarea name="excerpt" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('excerpt',$blog->excerpt) }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Content *</label>
<textarea name="content" rows="12" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('content',$blog->content) }}</textarea></div>
</div>
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">SEO</h3>
<div class="space-y-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label><input type="text" name="seo_title" value="{{ old('seo_title',$blog->seo_title) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label><textarea name="seo_description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('seo_description',$blog->seo_description) }}</textarea></div>
</div>
</div>
</div>
<div class="space-y-5">
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Publish</h3>
<div class="space-y-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
<select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
@foreach(['general','guides','tips','insights','news'] as $cat)
<option value="{{ $cat }}" {{ old('category',$blog->category)==$cat?'selected':'' }}>{{ ucfirst($cat) }}</option>
@endforeach
</select></div>
<label class="flex items-center gap-2"><input type="checkbox" name="is_published" value="1" {{ old('is_published',$blog->is_published)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Published</span></label>
</div>
<div class="mt-4 space-y-2">
<button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Update Post</button>
<a href="{{ route('admin.blog.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700">Cancel</a>
</div>
</div>
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-3">Featured Image</h3>
@if($blog->featured_image)
<img src="{{ asset('storage/'.$blog->featured_image) }}" class="w-full h-32 object-cover rounded-lg mb-3">
@endif
<input type="file" name="featured_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
<p class="text-xs text-gray-400 mt-1">Leave blank to keep existing image.</p>
</div>
</div>
</div>
</form>
</div>
@endsection
