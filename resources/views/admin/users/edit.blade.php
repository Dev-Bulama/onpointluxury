@extends('layouts.admin')
@section('title','Edit User') @section('page-title','Edit User')
@section('content')
<div class="max-w-xl">
<a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<form method="POST" action="{{ route('admin.users.update',$user) }}">
@csrf @method('PUT')
<div class="space-y-4">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
<input type="text" name="name" value="{{ old('name',$user->name) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
<input type="email" name="email" value="{{ old('email',$user->email) }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
<input type="text" name="phone" value="{{ old('phone',$user->phone) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Role *</label>
<select name="role" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
<option value="client" {{ old('role',$user->role)=='client'?'selected':'' }}>Client</option>
<option value="manager" {{ old('role',$user->role)=='manager'?'selected':'' }}>Manager</option>
<option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>Admin</option>
</select></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">New Password (leave blank to keep)</label>
<input type="password" name="password" minlength="6" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active',$user->is_active)?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Active</span></label>
<button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Update User</button>
</div>
</form>
</div>
</div>
@endsection
