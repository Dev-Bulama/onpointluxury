@extends('layouts.admin')
@section('title','FAQs') @section('page-title','FAQs')
@section('content')
<div class="max-w-3xl">
<!-- Add Form -->
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
<h3 class="font-semibold text-gray-800 mb-4">Add New FAQ</h3>
<form method="POST" action="{{ route('admin.faqs.store') }}">
@csrf
<div class="space-y-3">
<div><label class="block text-sm font-medium text-gray-700 mb-1">Question *</label>
<input type="text" name="question" value="{{ old('question') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
@error('question')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
<div><label class="block text-sm font-medium text-gray-700 mb-1">Answer *</label>
<textarea name="answer" rows="3" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('answer') }}</textarea>
@error('answer')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
<div class="flex items-center gap-4">
<div class="flex-1"><label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
<input type="number" name="sort_order" value="{{ old('sort_order',0) }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></div>
<label class="flex items-center gap-2 mt-5"><input type="checkbox" name="is_active" value="1" checked class="w-4 h-4"><span class="text-sm text-gray-700">Active</span></label>
</div>
<button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Add FAQ</button>
</div>
</form>
</div>
<!-- FAQ List -->
<div class="space-y-3">
@forelse($faqs as $faq)
<div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
<div class="flex items-start justify-between gap-3">
<div class="flex-1">
<div class="flex items-center gap-2 mb-1">
<p class="font-semibold text-sm text-gray-800">{{ $faq->question }}</p>
<span class="px-2 py-0.5 {{ $faq->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs rounded-full">{{ $faq->is_active ? 'Active' : 'Inactive' }}</span>
</div>
<p class="text-sm text-gray-600">{{ $faq->answer }}</p>
</div>
<div class="flex items-center gap-2 flex-shrink-0">
<a href="{{ route('admin.faqs.edit',$faq) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.faqs.destroy',$faq) }}" onsubmit="return confirm('Delete this FAQ?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</div>
</div>
@empty
<div class="bg-white rounded-xl p-12 text-center text-gray-400 shadow-sm border border-gray-100">No FAQs yet. Add your first one above.</div>
@endforelse
</div>
</div>
@endsection
