@extends('layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with Onpointluxury. We\'re here to help with your luxury accommodation needs.')

@section('content')

{{-- Page Hero --}}
<section class="bg-slate-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-gradient-to-br from-amber-400 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 relative text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Contact Us</h1>
        <p class="text-gray-300 text-lg max-w-2xl mx-auto">
            Have a question or ready to book? We'd love to hear from you.
        </p>
    </div>
</section>

{{-- Contact Section --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- Contact Form --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-slate-900 mb-2">Send Us a Message</h2>
                <p class="text-gray-500 text-sm mb-6">We'll get back to you within 24 hours.</p>

                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    {{ session('success') }}
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
                    <p class="font-medium mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   placeholder="John Doe"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all @error('name') border-red-400 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="john@example.com"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all @error('email') border-red-400 @enderror">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                   placeholder="+234 800 000 0000"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Subject <span class="text-red-500">*</span></label>
                            <select name="subject" required
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all @error('subject') border-red-400 @enderror">
                                <option value="">Select subject</option>
                                <option value="booking_inquiry" {{ old('subject') === 'booking_inquiry' ? 'selected' : '' }}>Booking Inquiry</option>
                                <option value="property_info" {{ old('subject') === 'property_info' ? 'selected' : '' }}>Property Information</option>
                                <option value="support" {{ old('subject') === 'support' ? 'selected' : '' }}>Customer Support</option>
                                <option value="partnership" {{ old('subject') === 'partnership' ? 'selected' : '' }}>Partnership</option>
                                <option value="other" {{ old('subject') === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" rows="5" required
                                  placeholder="Tell us how we can help you..."
                                  class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-500/10 transition-all resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit"
                            class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Contact Info --}}
            <div class="space-y-6">
                {{-- Office Info --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Get In Touch</h3>
                    <div class="space-y-4">
                        @php $address = \App\Models\Setting::get('address') @endphp
                        @if($address)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-map-marker-alt text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">Office Address</p>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $address }}</p>
                            </div>
                        </div>
                        @endif

                        @php $phone = \App\Models\Setting::get('phone') @endphp
                        @if($phone)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">Phone</p>
                                <a href="tel:{{ $phone }}" class="text-sm text-amber-600 hover:text-amber-700 mt-0.5 block">{{ $phone }}</a>
                            </div>
                        </div>
                        @endif

                        @php $email = \App\Models\Setting::get('email') @endphp
                        @if($email)
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-envelope text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">Email</p>
                                <a href="mailto:{{ $email }}" class="text-sm text-amber-600 hover:text-amber-700 mt-0.5 block">{{ $email }}</a>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-amber-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-700">Working Hours</p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    {{ \App\Models\Setting::get('working_hours', 'Mon – Fri: 8:00am – 6:00pm') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp CTA --}}
                @php $whatsapp = \App\Models\Setting::get('whatsapp_number') @endphp
                @if($whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $whatsapp) }}"
                   target="_blank" rel="noopener"
                   class="flex items-center gap-4 bg-green-500 hover:bg-green-600 text-white rounded-2xl p-5 transition-all duration-200 group">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <i class="fab fa-whatsapp text-2xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Chat on WhatsApp</p>
                        <p class="text-green-100 text-sm">Quick responses — usually within minutes</p>
                    </div>
                    <i class="fas fa-arrow-right ml-auto group-hover:translate-x-1 transition-transform"></i>
                </a>
                @endif

                {{-- Social Links --}}
                @php
                    $instagram = \App\Models\Setting::get('instagram');
                    $facebook  = \App\Models\Setting::get('facebook');
                    $twitter   = \App\Models\Setting::get('twitter');
                @endphp
                @if($instagram || $facebook || $twitter)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-3 uppercase tracking-wide">Follow Us</h3>
                    <div class="flex gap-3">
                        @if($instagram)
                        <a href="{{ $instagram }}" target="_blank" class="w-10 h-10 rounded-xl bg-pink-50 hover:bg-pink-100 flex items-center justify-center text-pink-500 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @endif
                        @if($facebook)
                        <a href="{{ $facebook }}" target="_blank" class="w-10 h-10 rounded-xl bg-blue-50 hover:bg-blue-100 flex items-center justify-center text-blue-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        @endif
                        @if($twitter)
                        <a href="{{ $twitter }}" target="_blank" class="w-10 h-10 rounded-xl bg-sky-50 hover:bg-sky-100 flex items-center justify-center text-sky-500 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Map Placeholder --}}
        <div class="mt-12 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gray-100 h-64 flex items-center justify-center relative">
                <div class="text-center text-gray-400">
                    <i class="fas fa-map text-5xl mb-3 block opacity-40"></i>
                    <p class="font-medium text-gray-500">Map Location</p>
                    @if($address)
                    <p class="text-sm text-gray-400 mt-1">{{ $address }}</p>
                    <a href="https://maps.google.com/?q={{ urlencode($address) }}"
                       target="_blank"
                       class="inline-flex items-center gap-1.5 mt-3 text-amber-600 hover:text-amber-700 text-sm font-medium">
                        <i class="fas fa-directions"></i> Get Directions
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
