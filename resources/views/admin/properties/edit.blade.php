@extends('layouts.admin')
@section('title', 'Edit Property')
@section('page-title', 'Edit: ' . $property->name)
@section('content')
<div class="max-w-5xl">
<form method="POST" action="{{ route('admin.properties.update', $property) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="grid lg:grid-cols-3 gap-6">
<div class="lg:col-span-2 space-y-6">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Basic Information</h3>
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property Name *</label>
<input type="text" name="name" value="{{ old('name',$property->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"></div>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
<select name="property_type_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">Select Type</option>
@foreach($types as $t)<option value="{{ $t->id }}" {{ old('property_type_id',$property->property_type_id)==$t->id?'selected':'' }}>{{ $t->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
<select name="property_category_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">Select Category</option>
@foreach($categories as $c)<option value="{{ $c->id }}" {{ old('property_category_id',$property->property_category_id)==$c->id?'selected':'' }}>{{ $c->name }}</option>@endforeach
</select></div></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
<textarea name="short_description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('short_description',$property->short_description) }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
<textarea name="description" rows="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description',$property->description) }}</textarea></div>
</div></div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Location</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
<input type="text" name="location" value="{{ old('location',$property->location) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">City</label>
<input type="text" name="city" value="{{ old('city',$property->city) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">State</label>
<input type="text" name="state" value="{{ old('state',$property->state) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
<input type="text" name="country" value="{{ old('country',$property->country) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div class="sm:col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
<textarea name="address" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('address',$property->address) }}</textarea></div>
</div></div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Pricing (₦)</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Price Per Night *</label>
<input type="number" name="price_per_night" value="{{ old('price_per_night',$property->price_per_night) }}" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Weekend Price</label>
<input type="number" name="weekend_price" value="{{ old('weekend_price',$property->weekend_price) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Monthly Price</label>
<input type="number" name="monthly_price" value="{{ old('monthly_price',$property->monthly_price) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Discount Price</label>
<input type="number" name="discount_price" value="{{ old('discount_price',$property->discount_price) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div></div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Details</h3>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Bedrooms</label><input type="number" name="bedrooms" value="{{ old('bedrooms',$property->bedrooms) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Bathrooms</label><input type="number" name="bathrooms" value="{{ old('bathrooms',$property->bathrooms) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label><input type="number" name="max_guests" value="{{ old('max_guests',$property->max_guests) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Beds</label><input type="number" name="beds" value="{{ old('beds',$property->beds) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Check-in</label><input type="time" name="check_in_time" value="{{ old('check_in_time',$property->check_in_time) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Check-out</label><input type="time" name="check_out_time" value="{{ old('check_out_time',$property->check_out_time) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Size</label><input type="text" name="property_size" value="{{ old('property_size',$property->property_size) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Video URL</label><input type="url" name="video_link" value="{{ old('video_link',$property->video_link) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div></div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Policies</h3>
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">House Rules</label><textarea name="house_rules" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('house_rules',$property->house_rules) }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Cancellation Policy</label><textarea name="cancellation_policy" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('cancellation_policy',$property->cancellation_policy) }}</textarea></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Refund Policy</label><textarea name="refund_policy" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('refund_policy',$property->refund_policy) }}</textarea></div>
</div></div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4 pb-2 border-b">Amenities</h3>
<div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
@foreach($amenities as $a)
<label class="flex items-center gap-2 cursor-pointer">
<input type="checkbox" name="amenities[]" value="{{ $a->id }}" {{ in_array($a->id, $selectedAmenities) ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
<span class="text-sm text-gray-700">{{ $a->name }}</span>
</label>
@endforeach
</div></div>
</div>
<div class="space-y-5">
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Publish</h3>
<div class="space-y-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
<select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="draft" {{ old('status',$property->status)=='draft'?'selected':'' }}>Draft</option>
<option value="published" {{ old('status',$property->status)=='published'?'selected':'' }}>Published</option>
<option value="inactive" {{ old('status',$property->status)=='inactive'?'selected':'' }}>Inactive</option>
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Assigned Manager</label>
<select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">No Manager</option>
@foreach($managers as $m)<option value="{{ $m->id }}" {{ old('user_id',$property->user_id)==$m->id?'selected':'' }}>{{ $m->name }}</option>@endforeach
</select></div>
<label class="flex items-center gap-2 cursor-pointer">
<input type="checkbox" name="is_featured" value="1" {{ old('is_featured',$property->is_featured)?'checked':'' }} class="w-4 h-4">
<span class="text-sm text-gray-700">Mark as Featured</span>
</label>
</div>
<div class="mt-4 space-y-2">
<button type="submit" class="w-full bg-blue-600 text-white py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Update Property</button>
<a href="{{ route('admin.properties.index') }}" class="block text-center text-sm text-gray-500 hover:text-gray-700">Cancel</a>
</div></div>
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-3">Featured Image</h3>
@if($property->featured_image_url)
<div class="relative mb-3 group">
    <img src="{{ $property->featured_image_url }}" class="w-full h-32 object-cover rounded-lg">
    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition rounded-lg flex items-center justify-center">
        <span class="text-white text-xs font-medium">Upload below to replace</span>
    </div>
</div>
@endif
<label class="block text-xs text-gray-500 mb-1">Upload new featured image to replace current</label>
<input type="file" name="featured_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
</div>
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100" x-data="galleryManager()">
<div class="flex items-center justify-between mb-3">
    <h3 class="font-semibold text-gray-800">Gallery Images</h3>
    <span class="text-xs text-gray-400">Click × to delete</span>
</div>
@if($property->images->count())
<div class="grid grid-cols-3 gap-2 mb-4" id="gallery-grid">
    @foreach($property->images->sortBy('sort_order') as $img)
    @php $imgUrl = str_starts_with($img->image,'http') ? $img->image : asset('storage/'.$img->image); @endphp
    <div class="relative group rounded overflow-hidden" id="img-wrap-{{ $img->id }}">
        <img src="{{ $imgUrl }}" class="w-full h-20 object-cover">
        <button type="button"
            onclick="deleteGalleryImage({{ $property->id }}, {{ $img->id }}, this)"
            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs font-bold opacity-0 group-hover:opacity-100 transition flex items-center justify-center hover:bg-red-600"
            title="Delete this image">×</button>
    </div>
    @endforeach
</div>
@else
<p class="text-sm text-gray-400 mb-3">No gallery images yet.</p>
@endif
<label class="block text-xs text-gray-500 mb-1">Add more images (multiple allowed)</label>
<input type="file" name="gallery[]" multiple accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
</div>

<script>
function deleteGalleryImage(propertyId, imageId, btn) {
    if (!confirm('Delete this image?')) return;
    const wrap = document.getElementById('img-wrap-' + imageId);
    btn.disabled = true;
    fetch(`/admin/properties/${propertyId}/images/${imageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            wrap.style.transition = 'opacity 0.3s';
            wrap.style.opacity = '0';
            setTimeout(() => wrap.remove(), 300);
        }
    })
    .catch(() => { btn.disabled = false; alert('Delete failed, try again.'); });
}
</script>
</div></div>
</form></div>
@endsection
