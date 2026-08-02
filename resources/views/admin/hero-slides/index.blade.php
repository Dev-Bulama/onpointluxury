@extends('layouts.admin')
@section('title','Hero Slides') @section('page-title','Hero Slides')
@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <p class="text-sm text-gray-500">Manage homepage hero slideshow. Drag rows to reorder.</p>
    </div>
    <a href="{{ route('admin.hero-slides.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 flex items-center gap-2">
        <i class="fas fa-plus"></i> Add Slide
    </a>
</div>

@if($slides->isEmpty())
<div class="bg-white rounded-xl p-12 text-center border border-gray-100 shadow-sm">
    <i class="fas fa-images text-gray-300 text-5xl mb-4"></i>
    <p class="text-gray-500 font-medium mb-2">No hero slides yet</p>
    <p class="text-gray-400 text-sm mb-6">Add your first slide to replace the default hero images.</p>
    <a href="{{ route('admin.hero-slides.create') }}" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Add First Slide</a>
</div>
@else
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm" id="slides-table">
        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
            <tr>
                <th class="px-4 py-3 w-8"></th>
                <th class="px-4 py-3 text-left w-24">Image</th>
                <th class="px-4 py-3 text-left">Content</th>
                <th class="px-4 py-3 text-left hidden md:table-cell">CTAs</th>
                <th class="px-4 py-3 text-center w-24">Status</th>
                <th class="px-4 py-3 text-right w-28">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50" id="sortable-body">
            @foreach($slides as $slide)
            <tr class="hover:bg-gray-50 transition" data-id="{{ $slide->id }}">
                <td class="px-4 py-3 text-gray-300 cursor-grab active:cursor-grabbing">
                    <i class="fas fa-grip-vertical"></i>
                </td>
                <td class="px-4 py-3">
                    <div class="w-20 h-14 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                        <img src="{{ $slide->desktop_image_url }}"
                             alt="{{ $slide->alt_text }}"
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.style.display='none'">
                    </div>
                </td>
                <td class="px-4 py-3">
                    @if($slide->badge)
                    <span class="inline-block text-xs text-amber-600 font-semibold uppercase tracking-wide mb-1">{{ Str::limit($slide->badge, 40) }}</span><br>
                    @endif
                    <span class="font-semibold text-gray-800">{{ Str::limit($slide->headline, 50) }}</span>
                    @if($slide->description)
                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">{{ $slide->description }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="inline-block bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-xs font-medium mb-1">{{ $slide->cta1_text }}</span>
                    @if($slide->cta2_text)
                    <br><span class="inline-block bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">{{ $slide->cta2_text }}</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    <button onclick="toggleSlide({{ $slide->id }}, this)"
                            data-active="{{ $slide->is_active ? '1' : '0' }}"
                            class="px-3 py-1 rounded-full text-xs font-semibold transition {{ $slide->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $slide->is_active ? 'Active' : 'Inactive' }}
                    </button>
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-blue-500 hover:text-blue-700 mr-3 text-xs font-medium">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('admin.hero-slides.destroy', $slide) }}" class="inline"
                          onsubmit="return confirm('Delete this slide?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 text-xs font-medium">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4 bg-blue-50 border border-blue-200 rounded-xl p-4 text-sm text-blue-700">
    <i class="fas fa-info-circle mr-2"></i>
    <strong>Tip:</strong> Drag rows to reorder slides. Changes save automatically.
    Hero images can be uploaded files or external URLs (Unsplash, CDN, etc.).
</div>
@endif

<script>
// Simple drag-to-reorder
let dragEl = null;
document.querySelectorAll('#sortable-body tr').forEach(row => {
    row.draggable = true;
    row.addEventListener('dragstart', e => { dragEl = row; row.classList.add('opacity-50'); });
    row.addEventListener('dragend', e => { row.classList.remove('opacity-50'); saveOrder(); });
    row.addEventListener('dragover', e => { e.preventDefault(); const tb = row.parentNode; tb.insertBefore(dragEl, row); });
});

function saveOrder() {
    const ids = [...document.querySelectorAll('#sortable-body tr')].map(r => r.dataset.id);
    fetch('{{ route('admin.hero-slides.reorder') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: JSON.stringify({ order: ids }),
    });
}

function toggleSlide(id, btn) {
    fetch(`/admin/hero-slides/${id}/toggle`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
    })
    .then(r => r.json())
    .then(data => {
        btn.dataset.active = data.is_active ? '1' : '0';
        btn.textContent = data.is_active ? 'Active' : 'Inactive';
        btn.className = 'px-3 py-1 rounded-full text-xs font-semibold transition ' +
            (data.is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500');
    });
}
</script>
@endsection
