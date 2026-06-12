@extends('layouts.admin')
@section('title','Messages') @section('page-title','Contact Messages')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">From</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Subject</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Date</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($messages as $msg)
<tr class="hover:bg-gray-50 {{ !$msg->is_read ? 'font-semibold' : '' }}">
<td class="px-4 py-3">
<p class="text-sm {{ !$msg->is_read ? 'font-bold' : '' }}">{{ $msg->name }}</p>
<p class="text-xs text-gray-400">{{ $msg->email }}</p>
</td>
<td class="px-4 py-3 hidden sm:table-cell">
<p class="text-sm">{{ $msg->subject }}</p>
<p class="text-xs text-gray-400 line-clamp-1">{{ $msg->message }}</p>
</td>
<td class="px-4 py-3 hidden md:table-cell text-xs text-gray-500">{{ $msg->created_at->format('d M Y H:i') }}</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="{{ route('admin.messages.show',$msg) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-eye"></i></a>
<form method="POST" action="{{ route('admin.messages.destroy',$msg) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="4" class="px-4 py-12 text-center text-gray-400">No messages found</td></tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-gray-100">{{ $messages->links() }}</div>
</div>
@endsection
