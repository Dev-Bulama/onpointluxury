@extends('layouts.admin')
@section('title','Message') @section('page-title','Message Details')
@section('content')
<div class="max-w-2xl">
<a href="{{ route('admin.messages.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-5"><i class="fas fa-arrow-left"></i> Back</a>
<div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
<div class="mb-5 pb-5 border-b border-gray-100">
<p class="text-xs text-gray-400 uppercase tracking-wide mb-1">From</p>
<p class="font-bold text-gray-800">{{ $message->name }}</p>
<p class="text-sm text-gray-500">{{ $message->email }}</p>
@if($message->phone)<p class="text-sm text-gray-500">{{ $message->phone }}</p>@endif
</div>
<div class="mb-5 pb-5 border-b border-gray-100">
<p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Subject</p>
<p class="font-semibold text-gray-800">{{ $message->subject }}</p>
</div>
<div class="mb-5 pb-5 border-b border-gray-100">
<p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Message</p>
<p class="text-gray-700 leading-relaxed">{{ $message->message }}</p>
</div>
<p class="text-xs text-gray-400">Received: {{ $message->created_at->format('D, d M Y H:i') }}</p>
<div class="flex gap-3 mt-6">
<a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}"
   class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm hover:bg-blue-700">
   <i class="fas fa-reply mr-2"></i>Reply via Email
</a>
@if($message->phone)
<a href="https://wa.me/{{ preg_replace('/\D/','',$message->phone) }}"
   target="_blank" class="bg-green-600 text-white px-5 py-2.5 rounded-lg text-sm hover:bg-green-700">
   <i class="fab fa-whatsapp mr-2"></i>WhatsApp
</a>
@endif
<form method="POST" action="{{ route('admin.messages.destroy',$message) }}" class="ml-auto" onsubmit="return confirm('Delete this message?')">
@csrf @method('DELETE')
<button type="submit" class="border border-red-300 text-red-500 px-4 py-2.5 rounded-lg text-sm hover:bg-red-50">Delete</button>
</form>
</div>
</div>
</div>
@endsection
