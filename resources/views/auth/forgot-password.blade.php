@extends('layouts.app')
@section('title', 'Forgot Password — Onpointluxury')
@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 to-slate-800 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-amber-500 rounded-xl flex items-center justify-center"><span class="text-white font-black">OPL</span></div>
                <span class="font-black text-2xl text-white">Onpoint<span class="text-amber-400">luxury</span></span>
            </a>
            <h1 class="text-2xl font-black text-white">Reset Password</h1>
            <p class="text-gray-400 mt-1 text-sm">Enter your email to receive a reset link</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            @if(session('status'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4 text-sm">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl transition-colors">
                        Send Reset Link
                    </button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-amber-500 hover:text-amber-600">← Back to login</a>
            </div>
        </div>
    </div>
</div>
@endsection
