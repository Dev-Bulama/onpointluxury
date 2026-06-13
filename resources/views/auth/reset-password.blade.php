@extends('layouts.app')
@section('title', 'Reset Password — Onpointluxury')
@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-slate-900 p-8 text-center">
                <div class="w-14 h-14 bg-amber-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-black text-white">Reset Password</h1>
                <p class="text-gray-400 text-sm mt-1">Choose a new password for your account</p>
            </div>
            <div class="p-8">
                @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
                @endif
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                            <input type="email" name="email" value="{{ old('email', $email ?? '') }}" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" required minlength="6"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        </div>
                        <button type="submit"
                                class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black py-3 rounded-xl transition-colors mt-2">
                            Reset Password
                        </button>
                    </div>
                </form>
                <div class="mt-5 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-amber-500">← Back to Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
