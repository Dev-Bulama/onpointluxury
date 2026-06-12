@extends('layouts.admin')
@section('title','Users') @section('page-title','Users')
@section('content')
<div class="flex items-center justify-between mb-6">
<div><h2 class="text-xl font-bold text-gray-800">Users</h2><p class="text-sm text-gray-500">Manage all system users</p></div>
<a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> Add User</a>
</div>
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-5">
<form method="GET" class="flex flex-wrap gap-3">
<input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..." class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 min-w-48 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
<select name="role" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="">All Roles</option>
<option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
<option value="manager" {{ request('role')=='manager'?'selected':'' }}>Manager</option>
<option value="client" {{ request('role')=='client'?'selected':'' }}>Client</option>
</select>
<button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm">Filter</button>
<a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm">Clear</a>
</form>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">User</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Role</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Phone</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($users as $user)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3">
<div class="flex items-center gap-3">
<div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
<span class="text-blue-700 font-bold text-sm">{{ substr($user->name,0,1) }}</span>
</div>
<div><p class="font-medium text-sm">{{ $user->name }}</p><p class="text-xs text-gray-400">{{ $user->email }}</p></div>
</div>
</td>
<td class="px-4 py-3 hidden sm:table-cell">
@php $rc=['admin'=>'red','manager'=>'blue','client'=>'green']; @endphp
<span class="px-2.5 py-1 bg-{{ $rc[$user->role]??'gray' }}-100 text-{{ $rc[$user->role]??'gray' }}-700 text-xs rounded-full capitalize">{{ $user->role }}</span>
</td>
<td class="px-4 py-3 hidden md:table-cell text-sm text-gray-600">{{ $user->phone ?? '—' }}</td>
<td class="px-4 py-3">
<span class="px-2 py-0.5 {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }} text-xs rounded-full">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="{{ route('admin.users.edit',$user) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.users.toggle-status',$user) }}" class="inline">
@csrf <button type="submit" class="text-gray-400 hover:text-gray-600 text-sm" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
<i class="fas fa-{{ $user->is_active ? 'toggle-on text-green-500' : 'toggle-off' }}"></i>
</button>
</form>
@if($user->id !== auth()->id())
<form method="POST" action="{{ route('admin.users.destroy',$user) }}" onsubmit="return confirm('Delete this user?')">
@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
@endif
</div>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">No users found</td></tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-gray-100">{{ $users->links() }}</div>
</div>
@endsection
