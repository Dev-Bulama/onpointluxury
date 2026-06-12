@extends('layouts.admin')
@section('title','Menu Items') @section('page-title','Menu Items')
@section('content')
<div class="max-w-3xl">
<div class="flex items-center justify-between mb-6">
<a href="{{ route('admin.menus.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1"><i class="fas fa-arrow-left"></i> Back to Menus</a>
<h2 class="font-bold text-gray-800">{{ $menu->name }}</h2>
</div>

<!-- Add Item Form -->
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
<h3 class="font-semibold text-gray-800 mb-4">Add Menu Item</h3>
<form method="POST" action="{{ route('admin.menus.items.store',$menu) }}">
@csrf
<div class="grid sm:grid-cols-2 gap-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Label *</label>
<input type="text" name="label" value="{{ old('label') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">URL *</label>
<input type="text" name="url" value="{{ old('url') }}" required placeholder="/about or https://..." class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Icon (optional)</label>
<input type="text" name="icon" value="{{ old('icon') }}" placeholder="fas fa-home" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
<input type="number" name="sort_order" value="{{ old('sort_order',0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
</div>
<div class="flex items-center gap-4 mt-3">
<label class="flex items-center gap-2"><input type="checkbox" name="open_in_new_tab" value="1" {{ old('open_in_new_tab')?'checked':'' }} class="w-4 h-4"><span class="text-sm text-gray-700">Open in new tab</span></label>
<button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Add Item</button>
</div>
</form>
</div>

<!-- Menu Items List -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
<p class="text-sm font-semibold text-gray-700">Current Menu Items ({{ $menu->items->count() }})</p>
</div>
@if($menu->items->isEmpty())
<div class="p-12 text-center text-gray-400">No menu items yet. Add one above.</div>
@else
<ul class="divide-y divide-gray-50">
@foreach($menu->items->sortBy('sort_order') as $item)
<li class="flex items-center justify-between px-5 py-3 hover:bg-gray-50">
<div class="flex items-center gap-3">
<i class="fas fa-grip-vertical text-gray-300 cursor-move"></i>
<div>
<p class="font-medium text-sm">{{ $item->label }}</p>
<p class="text-xs text-gray-400">{{ $item->url }}{{ $item->open_in_new_tab ? ' (new tab)' : '' }}</p>
</div>
</div>
<form method="POST" action="{{ route('admin.menus.items.destroy',[$menu,$item]) }}" onsubmit="return confirm('Remove item?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-times"></i></button>
</form>
</li>
@endforeach
</ul>
@endif
</div>
</div>
@endsection
