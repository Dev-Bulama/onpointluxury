@extends('layouts.app')

@section('title', 'My Profile — Onpointluxury')

@section('content')
<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900">My Profile</h1>
            <p class="text-slate-500 mt-1">Manage your personal information and security settings.</p>
        </div>

        {{-- Success/Error Alerts --}}
        @if(session('success'))
            <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-3 rounded-xl text-sm" x-data="{ show: true }" x-show="show">
                <i class="fas fa-check-circle flex-shrink-0"></i>
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ml-auto text-green-500 hover:text-green-700"><i class="fas fa-times"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-3 rounded-xl text-sm">
                <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('client.profile.update') }}" x-data="{ pwSection: false }">
            @csrf
            @method('PATCH')

            {{-- Avatar + Name --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                <div class="flex items-center gap-5 mb-6 pb-6 border-b border-slate-100">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-white font-bold text-2xl flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-lg font-bold text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="text-slate-400 text-sm">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-slate-400 mt-1">Member since {{ auth()->user()->created_at->format('F Y') }}</p>
                    </div>
                </div>

                <h2 class="text-base font-semibold text-slate-900 mb-5">Personal Information</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Full Name --}}
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Full Name <span class="text-red-400">*</span>
                        </label>
                        <input type="text" id="name" name="name"
                            value="{{ old('name', auth()->user()->name) }}"
                            required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition @error('name') border-red-400 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email (readonly) --}}
                    <div class="sm:col-span-2">
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Email Address
                        </label>
                        <div class="relative">
                            <input type="email" id="email" name="email"
                                value="{{ auth()->user()->email }}"
                                readonly
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-400 bg-slate-50 cursor-not-allowed focus:outline-none">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-medium text-slate-400 bg-slate-100 px-2 py-0.5 rounded">
                                <i class="fas fa-lock mr-1"></i>Locked
                            </span>
                        </div>
                        <p class="text-slate-400 text-xs mt-1">Email cannot be changed. Contact support if needed.</p>
                    </div>

                    {{-- Phone --}}
                    <div class="sm:col-span-2">
                        <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Phone Number
                        </label>
                        <div class="flex">
                            <span class="flex items-center px-4 border border-r-0 border-slate-200 rounded-l-xl bg-slate-50 text-slate-500 text-sm">
                                <i class="fas fa-phone mr-2"></i>+234
                            </span>
                            <input type="tel" id="phone" name="phone"
                                value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                placeholder="80X XXX XXXX"
                                class="flex-1 border border-slate-200 rounded-r-xl px-4 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition @error('phone') border-red-400 @enderror">
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
                <button type="button" @click="pwSection = !pwSection"
                    class="flex items-center justify-between w-full text-left">
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Change Password</h2>
                        <p class="text-slate-400 text-xs mt-0.5">Leave blank to keep your current password</p>
                    </div>
                    <i class="fas text-slate-400 transition-transform duration-200"
                        :class="pwSection ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>

                <div x-show="pwSection" x-collapse x-cloak class="mt-5 space-y-5 border-t border-slate-100 pt-5">
                    {{-- Current Password --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Current Password
                        </label>
                        <input type="password" id="current_password" name="current_password"
                            autocomplete="current-password"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition @error('current_password') border-red-400 @enderror">
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- New Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                            New Password
                        </label>
                        <input type="password" id="password" name="password"
                            autocomplete="new-password"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition @error('password') border-red-400 @enderror">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-slate-400 text-xs mt-1">Minimum 8 characters.</p>
                    </div>

                    {{-- Confirm Password --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
                            Confirm New Password
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            autocomplete="new-password"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent transition">
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit"
                    class="flex-1 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="{{ route('client.dashboard') }}"
                    class="flex-1 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold rounded-xl transition text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>

        </form>

    </div>
</div>
@endsection
