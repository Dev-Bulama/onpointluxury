@extends('layouts.admin')
@section('title','Payments') @section('page-title','Payments')
@section('content')
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 mb-6">
<div class="flex items-center justify-between">
<div><p class="text-sm text-gray-500">Total Revenue</p><p class="text-3xl font-black text-gray-800">₦{{ number_format($totalRevenue,0) }}</p></div>
<div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center"><i class="fas fa-chart-line text-green-600 text-2xl"></i></div>
</div>
</div>
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-5">
<form method="GET" class="flex flex-wrap gap-3">
<select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">All Status</option>
<option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
<option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
<option value="failed" {{ request('status')=='failed'?'selected':'' }}>Failed</option>
</select>
<button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
</form>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Reference</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Booking</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Amount</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Date</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($payments as $payment)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3"><p class="font-mono text-xs">{{ $payment->paystack_reference ?? 'N/A' }}</p><p class="text-xs text-gray-400">{{ $payment->payment_channel ?? '—' }}</p></td>
<td class="px-4 py-3 hidden md:table-cell"><p class="text-sm font-mono text-blue-600">{{ $payment->booking->booking_reference ?? '—' }}</p><p class="text-xs text-gray-500 truncate max-w-xs">{{ $payment->booking->property->name ?? '—' }}</p></td>
<td class="px-4 py-3 hidden sm:table-cell"><p class="font-bold text-sm">₦{{ number_format($payment->amount,0) }}</p><p class="text-xs text-gray-400">{{ $payment->currency }}</p></td>
<td class="px-4 py-3">
@php $sc=['success'=>'green','pending'=>'yellow','failed'=>'red','abandoned'=>'gray']; @endphp
<span class="px-2.5 py-1 bg-{{ $sc[$payment->status]??'gray' }}-100 text-{{ $sc[$payment->status]??'gray' }}-700 text-xs rounded-full capitalize">{{ $payment->status }}</span>
</td>
<td class="px-4 py-3 hidden lg:table-cell text-xs text-gray-500">{{ $payment->paid_at?->format('d M Y H:i') ?? $payment->created_at->format('d M Y') }}</td>
</tr>
@empty
<tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">No payments found</td></tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-gray-100">{{ $payments->links() }}</div>
</div>
@endsection
