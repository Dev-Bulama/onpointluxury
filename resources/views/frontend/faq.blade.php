@extends('layouts.app')

@section('title', 'Frequently Asked Questions')
@section('meta_description', 'Find answers to common questions about booking, payments, cancellations, and our luxury properties.')

@section('content')

{{-- Hero --}}
<section class="bg-slate-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-gradient-to-br from-amber-400 to-transparent"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 relative text-center">
        <p class="text-amber-400 text-sm font-semibold uppercase tracking-widest mb-3">Help Center</p>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Frequently Asked Questions</h1>
        <p class="text-gray-300 text-lg">
            Everything you need to know about our services, bookings, and properties.
        </p>
    </div>
</section>

{{-- FAQ Content --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">

        @php
            $grouped = collect($faqs ?? [])->groupBy('category');
            $hasCategories = $grouped->keys()->filter()->count() > 1;
        @endphp

        @if($hasCategories)
        {{-- Category Navigation --}}
        <div class="flex flex-wrap gap-2 mb-10 justify-center" x-data="{ active: '{{ $grouped->keys()->first() }}' }">
            @foreach($grouped->keys() as $category)
            <button @click="active = '{{ $category }}'"
                    :class="active === '{{ $category }}' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-gray-600 border-gray-200 hover:border-amber-300'"
                    class="px-4 py-2 rounded-full text-sm font-medium border transition-all duration-200">
                {{ $category ?: 'General' }}
            </button>
            @endforeach
        </div>

        {{-- Categorized FAQs --}}
        @foreach($grouped as $category => $items)
        <div x-data="{ activeCategory: '{{ $grouped->keys()->first() }}' }"
             x-show="activeCategory === '{{ $category }}' || '{{ $category }}' === activeCategory">
        @endforeach

        <div x-data="{ active: '{{ $grouped->keys()->first() }}' }">
            @foreach($grouped as $category => $items)
            <div x-show="active === '{{ $category }}'" x-cloak>
                @if($category)
                <h2 class="text-lg font-bold text-slate-900 mb-5 flex items-center gap-2">
                    <span class="w-1 h-6 bg-amber-500 rounded-full inline-block"></span>
                    {{ $category }}
                </h2>
                @endif
                <div class="space-y-3 mb-10" x-data="{ openItem: null }">
                    @foreach($items as $index => $faq)
                    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                        <button @click="openItem = openItem === {{ $loop->index }} ? null : {{ $loop->index }}"
                                class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-slate-800 text-sm pr-4">{{ $faq->question ?? $faq['question'] ?? '' }}</span>
                            <i class="fas fa-chevron-down text-amber-500 flex-shrink-0 transition-transform duration-200 text-xs"
                               :class="openItem === {{ $loop->index }} ? 'rotate-180' : ''"></i>
                        </button>
                        <div x-show="openItem === {{ $loop->index }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-cloak
                             class="px-6 pb-5 text-gray-500 text-sm leading-relaxed border-t border-gray-50">
                            <div class="pt-4">{{ $faq->answer ?? $faq['answer'] ?? '' }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- No categories / single list --}}
        <div x-data="{ openItem: null }" class="space-y-3">
            @forelse($faqs ?? [] as $faq)
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                <button @click="openItem = openItem === {{ $loop->index }} ? null : {{ $loop->index }}"
                        class="w-full flex items-center justify-between px-6 py-5 text-left hover:bg-gray-50 transition-colors group">
                    <span class="font-semibold text-slate-800 text-sm pr-4 group-hover:text-amber-700 transition-colors">
                        {{ $faq->question ?? $faq['question'] ?? '' }}
                    </span>
                    <div class="w-7 h-7 rounded-full bg-amber-50 flex items-center justify-center flex-shrink-0 transition-all"
                         :class="openItem === {{ $loop->index }} ? 'bg-amber-500' : ''">
                        <i class="fas fa-plus text-amber-500 text-xs transition-transform duration-200"
                           :class="openItem === {{ $loop->index }} ? 'rotate-45 text-white' : ''"></i>
                    </div>
                </button>
                <div x-show="openItem === {{ $loop->index }}"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-cloak
                     class="px-6 pb-5 text-gray-500 text-sm leading-relaxed border-t border-gray-50">
                    <div class="pt-4">{{ $faq->answer ?? $faq['answer'] ?? '' }}</div>
                </div>
            </div>
            @empty
            <div class="text-center py-16 text-gray-400">
                <i class="fas fa-question-circle text-5xl mb-4 block opacity-30"></i>
                <p class="text-lg font-medium text-gray-500">No FAQs available yet.</p>
            </div>
            @endforelse
        </div>
        @endif

        {{-- Still Need Help CTA --}}
        <div class="mt-14 bg-slate-900 rounded-2xl p-8 text-center">
            <i class="fas fa-headset text-3xl text-amber-400 mb-3 block"></i>
            <h3 class="text-xl font-bold text-white mb-2">Still have questions?</h3>
            <p class="text-gray-400 mb-5">Our support team is here to help you 7 days a week.</p>
            <div class="flex flex-wrap gap-3 justify-center">
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
                @php $whatsapp = \App\Models\Setting::get('whatsapp_number') @endphp
                @if($whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-6 py-3 rounded-xl transition-colors">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection
