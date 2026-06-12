@extends('layouts.admin')
@section('title','Testimonials') @section('page-title','Testimonials')
@section('content')
<div class="max-w-3xl">
<!-- Add Form -->
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
<h3 class="font-semibold text-gray-800 mb-4">Add New Testimonial</h3>
<form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
@csrf
<div class="space-y-3">
<div class="grid sm:grid-cols-2 gap-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
<input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Title / Role</label>
<input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Guest, Business Traveler" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
<select name="rating" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
@for($i=5;$i>=1;$i--)<option value="{{ $i }}" {{ old('rating',5)==$i?'selected':'' }}>{{ $i }} Star{{ $i!=1?'s':'' }}</option>@endfor
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Avatar</label>
<input type="file" name="avatar" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs"></div>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Testimonial *</label>
<textarea name="content" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('content') }}</textarea>
@error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
<div class="flex items-center gap-4">
<div class="flex-1"><label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
<input type="number" name="sort_order" value="{{ old('sort_order',0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<label class="flex items-center gap-2 mt-5"><input type="checkbox" name="is_active" value="1" checked class="w-4 h-4"><span class="text-sm text-gray-700">Active</span></label>
</div>
<button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Add Testimonial</button>
</div>
</form>
</div>
<!-- Testimonials List -->
<div class="space-y-3">
@forelse($testimonials as $testimonial)
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<div class="flex items-start gap-4 justify-between">
<div class="flex items-start gap-3 flex-1">
@if($testimonial->avatar)
<img src="{{ asset('storage/'.$testimonial->avatar) }}" class="w-12 h-12 rounded-full object-cover flex-shrink-0">
@else
<div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
<span class="text-blue-700 font-bold">{{ substr($testimonial->name,0,1) }}</span>
</div>
@endif
<div class="flex-1">
<div class="flex items-center gap-2 mb-0.5">
<p class="font-semibold text-sm">{{ $testimonial->name }}</p>
@if($testimonial->title)<p class="text-xs text-gray-400">{{ $testimonial->title }}</p>@endif
<span class="px-2 py-0.5 {{ $testimonial->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs rounded-full">{{ $testimonial->is_active ? 'Active' : 'Inactive' }}</span>
</div>
<div class="flex mb-1">@for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i<=$testimonial->rating?'text-amber-400':'text-gray-200' }}"></i>@endfor</div>
<p class="text-sm text-gray-600">{{ $testimonial->content }}</p>
</div>
</div>
<div class="flex items-center gap-2 flex-shrink-0">
<a href="{{ route('admin.testimonials.edit',$testimonial) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.testimonials.destroy',$testimonial) }}" onsubmit="return confirm('Delete this testimonial?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</div>
</div>
@empty
<div class="bg-white rounded-xl p-12 text-center text-gray-400 shadow-sm border border-gray-100">No testimonials yet. Add your first one above.</div>
@endforelse
</div>
</div>
@endsection
