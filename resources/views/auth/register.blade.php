@extends('layouts.app')
@section('title', 'Register — Onpointluxury')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 to-slate-800 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center">
                    <span class="text-white font-black">OPL</span>
                </div>
                <span class="font-black text-2xl text-white">Onpoint<span class="text-amber-400">luxury</span></span>
            </a>
            <h1 class="text-2xl font-black text-white">Create Account</h1>
            <p class="text-gray-400 mt-1 text-sm">Join thousands of satisfied guests</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('name') border-red-400 @enderror">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+234..."
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required minlength="6"
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('password') border-red-400 @enderror">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl transition-colors">
                        Create Account
                    </button>
                </div>
            </form>
            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('login') }}" class="text-amber-500 font-semibold hover:text-amber-600">Sign in</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
