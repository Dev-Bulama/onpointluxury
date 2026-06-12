@extends('layouts.admin')
@section('title','Bookings') @section('page-title','Bookings')
@section('content')
<div class="flex items-center justify-between mb-6">
<div><h2 class="text-xl font-bold text-gray-800">All Bookings</h2><p class="text-sm text-gray-500">Manage all property reservations</p></div>
<a href="{{ route('admin.bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> New Booking</a>
</div>
<!-- Filters -->
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-5">
<form method="GET" class="flex flex-wrap gap-3">
<input type="text" name="search" value="{{ request('search') }}" placeholder="Reference, name, email..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 min-w-48 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
<select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">All Status</option>
@foreach(['pending','reserved','confirmed','paid','checked_in','checked_out','cancelled','refunded','expired'] as $s)
<option value="{{ $s }}" {{ request('status')==$s?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
@endforeach
</select>
<select name="payment_status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">All Payment</option>
@foreach(['pending','paid','failed','refunded'] as $s)
<option value="{{ $s }}" {{ request('payment_status')==$s?'selected':'' }}>{{ ucfirst($s) }}</option>
@endforeach
</select>
<button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">Filter</button>
<a href="{{ route('admin.bookings.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200">Clear</a>
</form>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<div class="overflow-x-auto">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Reference</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Property</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Guest</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Dates</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Amount</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($bookings as $booking)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3"><p class="font-mono text-xs font-bold text-blue-600">{{ $booking->booking_reference }}</p><p class="text-xs text-gray-400">{{ $booking->created_at->format('d M Y') }}</p></td>
<td class="px-4 py-3 hidden md:table-cell"><p class="text-sm text-gray-700 line-clamp-1">{{ $booking->property->name ?? '—' }}</p></td>
<td class="px-4 py-3 hidden sm:table-cell"><p class="text-sm font-medium">{{ $booking->customer_name }}</p><p class="text-xs text-gray-400">{{ $booking->customer_email }}</p></td>
<td class="px-4 py-3 hidden lg:table-cell text-xs text-gray-600">
<p>In: {{ $booking->check_in_date?->format('d M Y') }}</p>
<p>Out: {{ $booking->check_out_date?->format('d M Y') }}</p>
<p>{{ $booking->nights }} night(s)</p>
</td>
<td class="px-4 py-3"><p class="font-bold text-sm">₦{{ number_format($booking->total_amount,0) }}</p>
@php $pc=['pending'=>'yellow','paid'=>'green','failed'=>'red','refunded'=>'blue']; @endphp
<span class="text-xs px-2 py-0.5 bg-{{ $pc[$booking->payment_status]??'gray' }}-100 text-{{ $pc[$booking->payment_status]??'gray' }}-700 rounded-full capitalize">{{ $booking->payment_status }}</span>
</td>
<td class="px-4 py-3">
@php $bc=['pending'=>'yellow','confirmed'=>'blue','paid'=>'green','cancelled'=>'red','reserved'=>'indigo','checked_in'=>'teal','checked_out'=>'gray']; @endphp
<span class="px-2 py-1 bg-{{ $bc[$booking->booking_status]??'gray' }}-100 text-{{ $bc[$booking->booking_status]??'gray' }}-700 text-xs rounded-full capitalize">{{ str_replace('_',' ',$booking->booking_status) }}</span>
</td>
<td class="px-4 py-3"><a href="{{ route('admin.bookings.show',$booking) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-eye"></i></a></td>
</tr>
@empty
<tr><td colspan="7" class="px-4 py-12 text-center text-gray-400">No bookings found</td></tr>
@endforelse
</tbody>
</table>
</div>
<div class="p-4 border-t border-gray-100">{{ $bookings->links() }}</div>
</div>
@endsection
