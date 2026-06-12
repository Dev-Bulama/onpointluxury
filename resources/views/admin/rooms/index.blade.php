@extends('layouts.admin')
@section('title','Rooms') @section('page-title','Rooms / Units')
@section('content')
<div class="flex items-center justify-between mb-6">
<div><h2 class="text-xl font-bold text-gray-800">Rooms &amp; Units</h2><p class="text-sm text-gray-500">Manage property rooms and unit types</p></div>
<a href="{{ route('admin.rooms.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> Add Room</a>
</div>
<!-- Filters -->
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-5">
<form method="GET" class="flex flex-wrap gap-3">
<select name="property_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">All Properties</option>
@foreach($properties as $property)
<option value="{{ $property->id }}" {{ request('property_id')==$property->id?'selected':'' }}>{{ $property->name }}</option>
@endforeach
</select>
<button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
<a href="{{ route('admin.rooms.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm">Clear</a>
</form>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Room</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Property</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Type</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Capacity</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Price/Night</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($rooms as $room)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
@if($room->featured_image)<img src="{{ asset('storage/'.$room->featured_image) }}" class="w-full h-full object-cover">
@else<div class="w-full h-full flex items-center justify-center"><i class="fas fa-bed text-gray-300"></i></div>@endif
</div>
<div><p class="font-medium text-sm">{{ $room->name }}</p><p class="text-xs text-gray-400">#{{ $room->room_number ?? 'N/A' }}</p></div>
</div>
</td>
<td class="px-4 py-3 hidden sm:table-cell text-sm text-gray-600">{{ $room->property->name ?? '—' }}</td>
<td class="px-4 py-3 hidden md:table-cell"><span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full capitalize">{{ $room->type ?? 'standard' }}</span></td>
<td class="px-4 py-3 hidden lg:table-cell text-sm text-gray-600">{{ $room->max_guests ?? 1 }} guest(s)</td>
<td class="px-4 py-3"><p class="font-bold text-sm">₦{{ number_format($room->price_per_night,0) }}</p></td>
<td class="px-4 py-3"><span class="px-2 py-0.5 {{ $room->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs rounded-full">{{ $room->is_available ? 'Available' : 'Unavailable' }}</span></td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="{{ route('admin.rooms.edit',$room) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.rooms.destroy',$room) }}" onsubmit="return confirm('Delete this room?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">No rooms found</td></tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-gray-100">{{ $rooms->links() }}</div>
</div>
@endsection
