@extends('layouts.admin')
@section('title', 'Add Property')
@section('page-title', 'Add Property')
@section('content')
<div class="max-w-5xl">
<form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data">
@csrf
<div class="grid lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 space-y-6">

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Basic Information</h3>
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property Name *</label>
<input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
<select name="property_type_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">Select Type</option>
@foreach($types as $t)<option value="{{ $t->id }}" {{ old('property_type_id')==$t->id?'selected':'' }}>{{ $t->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
<select name="property_category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">Select Category</option>
@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('property_category_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
</select></div>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
<textarea name="short_description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('short_description') }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
<textarea name="description" rows="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description') }}</textarea></div>
</div></div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Location</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Location/Area *</label>
<input type="text" name="location" value="{{ old('location') }}" required placeholder="e.g., Victoria Island" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">City</label>
<input type="text" name="city" value="{{ old('city') }}" placeholder="Lagos" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">State</label>
<input type="text" name="state" value="{{ old('state') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
<input type="text" name="country" value="{{ old('country','Nigeria') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
<textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('address') }}</textarea></div>
</div></div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Pricing (₦)</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Price Per Night *</label>
<input type="number" name="price_per_night" value="{{ old('price_per_night') }}" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Weekend Price</label>
<input type="number" name="weekend_price" value="{{ old('weekend_price') }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Monthly Price</label>
<input type="number" name="monthly_price" value="{{ old('monthly_price') }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Discount Price</label>
<input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div></div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Details</h3>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label>
<input type="number" name="bedrooms" value="{{ old('bedrooms',1) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label>
<input type="number" name="bathrooms" value="{{ old('bathrooms',1) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label>
<input type="number" name="max_guests" value="{{ old('max_guests',2) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Beds</label>
<input type="number" name="beds" value="{{ old('beds',1) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label>
<input type="time" name="check_in_time" value="{{ old('check_in_time','14:00') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label>
<input type="time" name="check_out_time" value="{{ old('check_out_time','12:00') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Size</label>
<input type="text" name="property_size" value="{{ old('property_size') }}" placeholder="150 sqm" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Video URL</label>
<input type="url" name="video_link" value="{{ old('video_link') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div></div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Policies & Rules</h3>
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">House Rules</label>
<textarea name="house_rules" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('house_rules') }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Cancellation Policy</label>
<textarea name="cancellation_policy" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('cancellation_policy') }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Refund Policy</label>
<textarea name="refund_policy" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('refund_policy') }}</textarea></div>
</div></div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Amenities</h3>
<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
@foreach($amenities as $a)
<label class="flex items-center gap-2 cursor-pointer">
<input type="checkbox" name="amenities[]" value="{{ $a->id }}" {{ in_array($a->id, old('amenities',[])) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
<span class="text-sm text-gray-700">{{ $a->name }}</span>
</label>
@endforeach
</div></div>

<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">SEO</h3>
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
<input type="text" name="seo_title" value="{{ old('seo_title') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">SEO Description</label>
<textarea name="seo_description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('seo_description') }}</textarea></div>
</div></div>

</div><!-- end main col -->

<div class="space-y-5">
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Publish</h3>
<div class="space-y-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
<select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="draft" {{ old('status')=='draft'?'selected':'' }}>Draft</option>
<option value="published" {{ old('status')=='published'?'selected':'' }}>Published</option>
<option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Assigned Manager</label>
<select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">No Manager</option>
@foreach($managers as $m)<option value="{{ $m->id }}" {{ old('user_id')==$m->id?'selected':'' }}>{{ $m->name }}</option>@endforeach
</select></div>
<label class="flex items-center gap-2 cursor-pointer">
<input type="checkbox" name="is_featured" value="1" {{ old('is_featured')?'checked':'' }} class="w-4 h-4">
<span class="text-sm text-gray-700">Mark as Featured</span>
</label>
</div>
<div class="mt-4 space-y-2">
<button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Save Property</button>
<a href="{{ route('admin.properties.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700">Cancel</a>
</div></div>

<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-3">Featured Image</h3>
<input type="file" name="featured_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs"></div>

<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-3">Gallery Images</h3>
<input type="file" name="gallery[]" multiple accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
<p class="text-xs text-gray-400 mt-1">Select multiple</p></div>
</div>
</div>
</form></div>
@endsection
