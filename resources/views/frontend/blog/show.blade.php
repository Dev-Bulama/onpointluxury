@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')

{{-- Post Hero --}}
<section class="bg-slate-900 py-14 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-gradient-to-br from-amber-400 to-transparent"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative">
        <a href="{{ route('blog.index') }}"
           class="inline-flex items-center gap-2 text-amber-400 hover:text-amber-300 text-sm font-medium mb-6 transition-colors">
            <i class="fas fa-arrow-left text-xs"></i> Back to Blog
        </a>
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight mb-5">
            {{ $post->title }}
        </h1>
        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
            <div class="flex items-center gap-2">
                <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name ?? 'Author') . '&size=36&background=c9a84c&color=fff' }}"
                     alt="{{ $post->author->name ?? 'Author' }}"
                     class="w-9 h-9 rounded-full object-cover border-2 border-amber-500/30">
                <div>
                    <span class="text-white font-medium text-sm">{{ $post->author->name ?? 'Onpointluxury' }}</span>
                </div>
            </div>
            <span class="text-gray-600">·</span>
            <span><i class="fas fa-calendar-alt text-amber-400/70 mr-1.5"></i>{{ $post->created_at->format('F d, Y') }}</span>
            @if($post->category ?? null)
            <span class="text-gray-600">·</span>
            <span class="bg-amber-500/20 text-amber-400 text-xs font-medium px-2.5 py-1 rounded-full">{{ $post->category }}</span>
            @endif
        </div>
    </div>
</section>

{{-- Content + Sidebar --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- Main Content --}}
            <article class="lg:col-span-2">
                @if($post->featured_image)
                <div class="mb-8 rounded-2xl overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $post->featured_image) }}"
                         alt="{{ $post->title }}"
                         class="w-full max-h-[480px] object-cover">
                </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-10">
                    <div class="prose prose-slate max-w-none
                                prose-headings:font-bold prose-headings:text-slate-900
                                prose-p:text-gray-600 prose-p:leading-relaxed
                                prose-a:text-amber-600 prose-a:no-underline hover:prose-a:underline
                                prose-img:rounded-xl prose-img:shadow-sm
                                prose-blockquote:border-l-amber-500 prose-blockquote:text-gray-500
                                prose-strong:text-slate-800">
                        {!! $post->content !!}
                    </div>
                </div>

                {{-- Author Bio --}}
                @if($post->author ?? null)
                <div class="mt-6 bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center gap-5">
                    <img src="{{ $post->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) . '&size=72&background=c9a84c&color=fff' }}"
                         alt="{{ $post->author->name }}"
                         class="w-16 h-16 rounded-2xl object-cover flex-shrink-0">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Written by</p>
                        <p class="font-bold text-slate-900 text-lg">{{ $post->author->name }}</p>
                        @if($post->author->bio ?? null)
                        <p class="text-gray-500 text-sm mt-1">{{ $post->author->bio }}</p>
                        @endif
                    </div>
                </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('blog.index') }}"
                       class="inline-flex items-center gap-2 text-sm text-amber-600 hover:text-amber-700 font-medium transition-colors">
                        <i class="fas fa-arrow-left"></i> Back to all posts
                    </a>
                </div>
            </article>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                {{-- Related Posts --}}
                @if(isset($relatedPosts) && $relatedPosts->count())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-1 h-5 bg-amber-500 rounded-full inline-block"></span>
                        Latest Posts
                    </h3>
                    <div class="space-y-5">
                        @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}"
                           class="group flex gap-3 hover:opacity-80 transition-opacity">
                            <div class="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                                @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}"
                                     alt="{{ $related->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-amber-400 text-lg"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-slate-800 font-medium text-sm leading-snug group-hover:text-amber-600 transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </p>
                                <p class="text-gray-400 text-xs mt-1">{{ $related->created_at->format('M d, Y') }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- CTA --}}
                <div class="bg-slate-900 rounded-2xl p-6 text-center">
                    <i class="fas fa-calendar-check text-3xl text-amber-400 mb-3 block"></i>
                    <h3 class="font-bold text-white mb-2">Ready to Book?</h3>
                    <p class="text-gray-400 text-sm mb-4">Find your perfect luxury stay today.</p>
                    <a href="{{ route('properties.index') }}"
                       class="inline-block bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                        View Properties
                    </a>
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
