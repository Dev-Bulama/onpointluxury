@extends('layouts.admin')
@section('title','Edit Room') @section('page-title','Edit Room / Unit')
@section('content')
<div class="max-w-3xl">
<a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<form method="POST" action="{{ route('admin.rooms.update',$room) }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="space-y-5">
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Basic Info</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property *</label>
<select name="property_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">Select Property</option>
@foreach($properties as $p)<option value="{{ $p->id }}" {{ old('property_id',$room->property_id)==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Room Name *</label>
<input type="text" name="name" value="{{ old('name',$room->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Room Number</label>
<input type="text" name="room_number" value="{{ old('room_number',$room->room_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
<select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
@foreach(['standard','deluxe','suite','penthouse','studio','apartment'] as $t)
<option value="{{ $t }}" {{ old('type',$room->type)==$t?'selected':'' }}>{{ ucfirst($t) }}</option>
@endforeach
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Price Per Night (₦) *</label>
<input type="number" name="price_per_night" value="{{ old('price_per_night',$room->price_per_night) }}" min="0" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Max Guests *</label>
<input type="number" name="max_guests" value="{{ old('max_guests',$room->max_guests) }}" min="1" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Size (sqm)</label>
<input type="number" name="size" value="{{ old('size',$room->size) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Floor</label>
<input type="text" name="floor" value="{{ old('floor',$room->floor) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div>
<div class="mt-4"><label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
<textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description',$room->description) }}</textarea></div>
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Amenities</h3>
<div class="grid sm:grid-cols-3 gap-2">
@php $currentAmenities = old('amenities', $room->amenities ?? []); @endphp
@foreach(['WiFi','Air Conditioning','TV','Mini Bar','Safe','Balcony','Bathtub','Kitchen','Washer','Parking','Pool Access','Gym Access'] as $amenity)
<label class="flex items-center gap-2">
<input type="checkbox" name="amenities[]" value="{{ $amenity }}" {{ in_array($amenity, $currentAmenities) ? 'checked' : '' }} class="w-4 h-4">
<span class="text-sm text-gray-700">{{ $amenity }}</span>
</label>
@endforeach
</div>
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Images</h3>
<div class="mb-4">
@if($room->featured_image)
<img src="{{ asset('storage/'.$room->featured_image) }}" class="w-full h-40 object-cover rounded-lg mb-3">
@endif
<label class="block text-sm font-medium text-gray-700 mb-1">Replace Featured Image</label>
<input type="file" name="featured_image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs">
<p class="text-xs text-gray-400 mt-1">Leave blank to keep existing image.</p>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Add More Images</label>
<input type="file" name="images[]" accept="image/*" multiple class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs"></div>
</div>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<h3 class="font-semibold text-gray-800 mb-4">Availability</h3>
<div class="space-y-2">
<label class="flex items-center gap-2"><input type="checkbox" name="is_available" value="1" {{ old('is_available',$room->is_available)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Available for Booking</span></label>
<label class="flex items-center gap-2"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured',$room->is_featured)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Feature this Room</span></label>
</div>
</div>
<div class="flex gap-3">
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Update Room</button>
<a href="{{ route('admin.rooms.index') }}" class="bg-gray-100 text-gray-600 px-6 py-2.5 rounded-lg text-sm hover:bg-gray-200">Cancel</a>
</div>
</div>
</form>
</div>
@endsection
