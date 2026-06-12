@extends('layouts.admin')
@section('title','Blog') @section('page-title','Blog Posts')
@section('content')
<div class="flex items-center justify-between mb-6">
<h2 class="text-xl font-bold text-gray-800">Blog Posts</h2>
<a href="{{ route('admin.blog.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 flex items-center gap-2"><i class="fas fa-plus"></i> New Post</a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
<table class="w-full">
<thead><tr class="bg-gray-50 border-b border-gray-100">
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Post</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Category</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Date</th>
<th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Actions</th>
</tr></thead>
<tbody class="divide-y divide-gray-50">
@forelse($posts as $post)
<tr class="hover:bg-gray-50">
<td class="px-4 py-3">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
@if($post->featured_image)<img src="{{ asset('storage/'.$post->featured_image) }}" class="w-full h-full object-cover">
@else<div class="w-full h-full flex items-center justify-center"><i class="fas fa-image text-gray-300"></i></div>@endif
</div>
<div><p class="font-medium text-sm line-clamp-1">{{ $post->title }}</p><p class="text-xs text-gray-400">{{ $post->slug }}</p></div>
</div>
</td>
<td class="px-4 py-3 hidden sm:table-cell"><span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">{{ $post->category }}</span></td>
<td class="px-4 py-3"><span class="px-2 py-0.5 {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }} text-xs rounded-full">{{ $post->is_published ? 'Published' : 'Draft' }}</span></td>
<td class="px-4 py-3 hidden md:table-cell text-xs text-gray-500">{{ $post->published_at?->format('d M Y') ?? '—' }}</td>
<td class="px-4 py-3">
<div class="flex items-center gap-2">
<a href="{{ route('admin.blog.edit',$post) }}" class="text-blue-500 hover:text-blue-700 text-sm"><i class="fas fa-edit"></i></a>
<form method="POST" action="{{ route('admin.blog.destroy',$post) }}" onsubmit="return confirm('Delete this post?')">@csrf @method('DELETE')
<button type="submit" class="text-red-400 hover:text-red-600 text-sm"><i class="fas fa-trash"></i></button>
</form>
</div>
</td>
</tr>
@empty
<tr><td colspan="5" class="px-4 py-12 text-center text-gray-400">No blog posts yet</td></tr>
@endforelse
</tbody>
</table>
<div class="p-4 border-t border-gray-100">{{ $posts->links() }}</div>
</div>
@endsection
