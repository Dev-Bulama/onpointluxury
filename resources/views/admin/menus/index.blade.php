@extends('layouts.admin')
@section('title','Menus') @section('page-title','Menu Management')
@section('content')
<div class="flex items-center justify-between mb-6">
<div><h2 class="text-xl font-bold text-gray-800">Menus</h2><p class="text-sm text-gray-500">Manage site navigation menus</p></div>
<a href="{{ route('admin.menus.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> New Menu</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Menu Name</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Location</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Items</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($menus as $menu)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3"><p class="font-medium text-sm">{{ $menu->name }}</p><p class="text-xs text-gray-400 font-mono">{{ $menu->slug }}</p></td>
<td class="px-4 py-3 hidden sm:table-cell"><span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full capitalize">{{ $menu->location ?? 'none' }}</span></td>
<td class="px-4 py-3 hidden md:table-cell text-sm text-gray-600">{{ $menu->items_count ?? $menu->items->count() }} items</td>
<td class="px-4 py-3"><span class="px-2 py-0.5 {{ $menu->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs rounded-full">{{ $menu->is_active ? 'Active' : 'Inactive' }}</span></td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="{{ route('admin.menus.show',$menu) }}" class="text-blue-500 hover:text-blue-700 text-sm" title="Manage Items"><i class="fas fa-list"></i></a>
<a href="{{ route('admin.menus.edit',$menu) }}" class="text-gray-500 hover:text-gray-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.menus.destroy',$menu) }}" onsubmit="return confirm('Delete this menu?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">No menus yet</td></tr>
@endforelse
</tbody>
</table>
</div>
@endsection
