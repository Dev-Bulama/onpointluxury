@extends('layouts.app')
@section('title', 'Login — Onpointluxury')
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
            <h1 class="text-2xl font-black text-white">Welcome Back</h1>
            <p class="text-gray-400 mt-1 text-sm">Sign in to your account</p>
        </div>
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required
                               class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-sm text-gray-600">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-amber-500"> Remember me
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm text-amber-500 hover:text-amber-600">Forgot password?</a>
                    </div>
                    <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl transition-colors">
                        Sign In
                    </button>
                </div>
            </form>
            <div class="mt-6 pt-6 border-t border-gray-100 text-center">
                <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-amber-500 font-semibold hover:text-amber-600">Create one</a></p>
            </div>
            <div class="mt-4 p-4 bg-gray-50 rounded-xl text-xs text-gray-500 space-y-1">
                <p class="font-semibold text-gray-600">Demo Accounts:</p>
                <p>Admin: admin@example.com / password</p>
                <p>Manager: manager@example.com / password</p>
                <p>Client: client@example.com / password</p>
            </div>
        </div>
    </div>
</div>
@endsection
