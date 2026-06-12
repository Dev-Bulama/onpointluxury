@extends('layouts.admin')
@section('title','Edit Room') @section('page-title','Edit Room')
@section('content')
<div class="max-w-xl">
<a href="{{ route('admin.rooms.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.rooms.update',$room) }}">
@csrf @method('PUT')
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Property *</label>
<select name="property_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
@foreach($properties as $p)<option value="{{ $p->id }}" {{ old('property_id',$room->property_id)==$p->id?'selected':'' }}>{{ $p->name }}</option>@endforeach
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Room Name *</label>
<input type="text" name="name" value="{{ old('name',$room->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div class="grid sm:grid-cols-2 gap-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Room Type</label>
<input type="text" name="room_type" value="{{ old('room_type',$room->room_type) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Price/Night *</label>
<input type="number" name="price_per_night" value="{{ old('price_per_night',$room->price_per_night) }}" required min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Max Guests</label>
<input type="number" name="max_guests" value="{{ old('max_guests',$room->max_guests) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Beds</label>
<input type="number" name="beds" value="{{ old('beds',$room->beds) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
<textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">{{ old('description',$room->description) }}</textarea></div>
<label class="flex items-center gap-2"><input type="checkbox" name="is_available" value="1" {{ old('is_available',$room->is_available)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Available</span></label>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Update Room</button>
</div>
</form>
</div>
</div>
@endsection
