@extends('layouts.admin')
@section('title', 'Properties')
@section('page-title', 'Properties')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800">All Properties</h2>
        <p class="text-sm text-gray-500">Manage your property listings</p>
    </div>
    <a href="{{ route('admin.properties.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center gap-2 w-fit">
        <i class="fas fa-plus"></i> Add Property
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-5">
    <form method="GET" class="flex flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, city, location..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm flex-1 min-w-48 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">All Status</option>
            <option value="published" {{ request('status')=='published'?'selected':'' }}>Published</option>
            <option value="draft"     {{ request('status')=='draft'?'selected':'' }}>Draft</option>
            <option value="inactive"  {{ request('status')=='inactive'?'selected':'' }}>Inactive</option>
        </select>
        <select name="type_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            <option value="">All Types</option>
            @foreach($types ?? [] as $type)
            <option value="{{ $type->id }}" {{ request('type_id')==$type->id?'selected':'' }}>{{ $type->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">
            <i class="fas fa-search mr-1"></i> Search
        </button>
        <a href="{{ route('admin.properties.index') }}"
           class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm hover:bg-gray-200 transition">Clear</a>
    </form>
</div>

<!-- Properties Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Property</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden md:table-cell">Type</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide hidden lg:table-cell">Price/Night</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($properties as $property)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($property->featured_image)
                                    <img src="{{ asset('storage/'.$property->featured_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-building text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-gray-800">{{ $property->name }}</p>
                                <p class="text-xs text-gray-500">{{ $property->location }}{{ $property->city ? ', '.$property->city : '' }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    @if($property->is_featured)
                                        <span class="text-xs bg-yellow-100 text-yellow-700 px-1.5 py-0.5 rounded-full font-medium">
                                            <i class="fas fa-star text-xs mr-0.5"></i>Featured
                                        </span>
                                    @endif
                                    <span class="text-xs text-gray-400">★ {{ $property->rating ?? '0.0' }}</span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 hidden md:table-cell">
                        <span class="text-sm text-gray-600">{{ $property->propertyType->name ?? '—' }}</span>
                    </td>
                    <td class="px-5 py-3.5 hidden lg:table-cell">
                        <span class="text-sm font-semibold text-gray-800">₦{{ number_format($property->price_per_night, 0) }}</span>
                    </td>
                    <td class="px-5 py-3.5">
                        @php
                            $sc = ['published'=>'green','draft'=>'yellow','inactive'=>'red'];
                            $c = $sc[$property->status] ?? 'gray';
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                            bg-{{ $c }}-100 text-{{ $c }}-700 capitalize">
                            <span class="w-1.5 h-1.5 rounded-full bg-{{ $c }}-500"></span>
                            {{ $property->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('properties.show', $property->slug) }}" target="_blank"
                               class="text-gray-400 hover:text-gray-700 transition p-1 rounded hover:bg-gray-100" title="Preview">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('admin.properties.edit', $property) }}"
                               class="text-blue-400 hover:text-blue-700 transition p-1 rounded hover:bg-blue-50" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.properties.destroy', $property) }}"
                                  onsubmit="return confirm('Delete this property? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-red-400 hover:text-red-700 transition p-1 rounded hover:bg-red-50" title="Delete">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-16 text-center text-gray-400">
                        <i class="fas fa-building text-4xl mb-3 opacity-30"></i>
                        <p class="text-sm">No properties found</p>
                        <a href="{{ route('admin.properties.create') }}" class="mt-2 inline-block text-blue-600 text-sm hover:underline">
                            Add your first property
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($properties->hasPages())
    <div class="p-4 border-t border-gray-100">
        {{ $properties->withQueryString()->links() }}
    </div>
    @endif
</div>

@endsection
