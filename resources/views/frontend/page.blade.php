@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? '')

@section('content')

{{-- Page Hero --}}
<section class="bg-slate-900 py-14 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-gradient-to-br from-amber-400 to-transparent"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative">
        <div class="text-center">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-tight">
                {{ $page->title }}
            </h1>
        </div>
    </div>
</section>

{{-- Page Content --}}
<section class="py-14 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12">
            <div class="prose prose-slate max-w-none
                        prose-headings:font-bold prose-headings:text-slate-900
                        prose-h2:text-2xl prose-h3:text-xl
                        prose-p:text-gray-600 prose-p:leading-relaxed
                        prose-a:text-amber-600 prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-sm
                        prose-ul:text-gray-600 prose-ol:text-gray-600
                        prose-li:leading-relaxed
                        prose-blockquote:border-l-amber-500 prose-blockquote:text-gray-500 prose-blockquote:not-italic
                        prose-strong:text-slate-800
                        prose-hr:border-gray-200">
                {!! $page->content !!}
            </div>
        </div>

        {{-- Back Navigation --}}
        <div class="mt-8 flex items-center justify-between">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : '/' }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-amber-600 transition-colors font-medium">
                <i class="fas fa-arrow-left text-xs"></i> Go Back
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 text-sm text-amber-600 hover:text-amber-700 font-medium transition-colors">
                Have a question? <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
    </div>
</section>

@endsection
