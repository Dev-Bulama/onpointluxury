@extends('layouts.app')

@section('title', 'Blog — Luxury Living Tips & Travel Guides')
@section('meta_description', 'Explore our blog for luxury living tips, travel guides, and insider knowledge about premium accommodations.')

@section('content')

{{-- Hero --}}
<section class="bg-slate-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-gradient-to-br from-amber-400 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative text-center">
        <p class="text-amber-400 text-sm font-semibold uppercase tracking-widest mb-3">Our Blog</p>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Luxury Living Insights</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">
            Travel tips, property guides, and everything you need to know about premium accommodations.
        </p>
    </div>
</section>

{{-- Blog Grid --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">

        @if(isset($featuredPost) && $featuredPost)
        {{-- Featured Post --}}
        <div class="mb-12">
            <a href="{{ route('blog.show', $featuredPost->slug) }}"
               class="group block bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 lg:flex">
                <div class="lg:w-1/2 overflow-hidden">
                    @if($featuredPost->featured_image)
                    <img src="{{ asset('storage/' . $featuredPost->featured_image) }}"
                         alt="{{ $featuredPost->title }}"
                         class="w-full h-64 lg:h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-64 lg:h-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center">
                        <i class="fas fa-newspaper text-5xl text-white/60"></i>
                    </div>
                    @endif
                </div>
                <div class="p-8 lg:w-1/2 flex flex-col justify-center">
                    <span class="inline-block text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full mb-4">Featured</span>
                    <h2 class="text-2xl font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-3 leading-tight">
                        {{ $featuredPost->title }}
                    </h2>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">{{ $featuredPost->excerpt }}</p>
                    <div class="flex items-center gap-3 text-xs text-gray-400">
                        <img src="{{ $featuredPost->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($featuredPost->author->name ?? 'Author') . '&size=32&background=c9a84c&color=fff' }}"
                             alt="{{ $featuredPost->author->name ?? '' }}"
                             class="w-7 h-7 rounded-full object-cover">
                        <span class="font-medium text-gray-600">{{ $featuredPost->author->name ?? 'Onpointluxury' }}</span>
                        <span class="text-gray-300">·</span>
                        <span>{{ $featuredPost->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endif

        {{-- Posts Grid --}}
        @if($posts->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($posts as $post)
            <article class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 flex flex-col">
                <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden flex-shrink-0">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-52 bg-gradient-to-br from-slate-800 to-slate-900 flex items-center justify-center">
                        <i class="fas fa-newspaper text-4xl text-white/20"></i>
                    </div>
                    @endif
                </a>
                <div class="p-6 flex flex-col flex-1">
                    <h3 class="font-bold text-slate-900 group-hover:text-amber-600 transition-colors mb-2 leading-tight text-lg">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed flex-1 mb-4">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                    </p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name ?? 'A') . '&size=28&background=c9a84c&color=fff' }}"
                                 alt="{{ $post->author->name ?? '' }}"
                                 class="w-6 h-6 rounded-full object-cover">
                            <span class="text-gray-500">{{ $post->author->name ?? 'Onpointluxury' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-gray-400">{{ $post->created_at->format('M d, Y') }}</span>
                            <a href="{{ route('blog.show', $post->slug) }}"
                               class="text-xs font-semibold text-amber-600 hover:text-amber-700 flex items-center gap-1 transition-colors">
                                Read <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
        <div class="mt-10 flex justify-center">
            {{ $posts->links() }}
        </div>
        @endif

        @else
        <div class="text-center py-20 text-gray-400">
            <i class="fas fa-newspaper text-5xl mb-4 block opacity-30"></i>
            <p class="text-xl font-medium text-gray-500">No blog posts yet.</p>
            <p class="text-sm mt-2">Check back soon for updates!</p>
        </div>
        @endif
    </div>
</section>

@endsection
