@extends('layouts.admin')
@section('title','Pages') @section('page-title','CMS Pages')
@section('content')
<div class="flex items-center justify-between mb-6">
<div><h2 class="text-xl font-bold text-gray-800">Pages</h2><p class="text-sm text-gray-500">Manage static CMS pages</p></div>
<a href="{{ route('admin.pages.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> New Page</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Title</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Slug</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Updated</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($pages as $page)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3"><p class="font-medium text-sm">{{ $page->title }}</p></td>
<td class="px-4 py-3 hidden sm:table-cell"><code class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-600">/{{ $page->slug }}</code></td>
<td class="px-4 py-3"><span class="px-2 py-0.5 {{ $page->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} text-xs rounded-full">{{ $page->is_published ? 'Published' : 'Draft' }}</span></td>
<td class="px-4 py-3 hidden md:table-cell text-xs text-gray-500">{{ $page->updated_at->format('d M Y') }}</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="{{ route('admin.pages.edit',$page) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.pages.destroy',$page) }}" onsubmit="return confirm('Delete this page?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">No pages yet</td></tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-gray-100">{{ $pages->links() }}</div>
</div>
@endsection
