@extends('layouts.app')
@section('title', 'Complete Payment — Onpointluxury')
@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="bg-slate-900 p-6 text-white text-center">
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-lock text-white text-xl"></i>
                </div>
                <h1 class="text-xl font-black">Secure Payment</h1>
                <p class="text-gray-400 text-sm mt-1">Powered by Paystack</p>
            </div>
            <div class="p-6">
                <div class="bg-gray-50 rounded-xl p-4 mb-6 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Booking Ref</span><span class="font-bold text-amber-600">{{ $booking->booking_reference }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Property</span><span class="font-semibold">{{ $booking->property->name }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Check-in</span><span class="font-semibold">{{ $booking->check_in_date->format('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Check-out</span><span class="font-semibold">{{ $booking->check_out_date->format('d M Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Nights</span><span class="font-semibold">{{ $booking->nights }}</span></div>
                    <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                        <span class="font-black text-slate-900">Total</span>
                        <span class="font-black text-2xl text-slate-900">₦{{ number_format($booking->total_amount, 0) }}</span>
                    </div>
                </div>

                <button id="payBtn" onclick="payWithPaystack()"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl transition-colors flex items-center justify-center gap-3 text-lg">
                    <i class="fas fa-credit-card"></i>
                    Pay ₦{{ number_format($booking->total_amount, 0) }}
                </button>

                <div class="mt-4 flex items-center justify-center gap-4 text-xs text-gray-400">
                    <span><i class="fas fa-shield-alt text-green-500 mr-1"></i>256-bit SSL</span>
                    <span><i class="fas fa-lock text-blue-500 mr-1"></i>PCI-DSS</span>
                    <span><i class="fab fa-cc-visa text-blue-700 mr-1"></i>Visa</span>
                    <span><i class="fab fa-cc-mastercard text-red-500 mr-1"></i>Mastercard</span>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-gray-600">← Cancel and return home</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
async function payWithPaystack() {
    const btn = document.getElementById('payBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Initializing...';

    try {
        const res = await fetch('{{ route('payment.initialize') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ booking_id: {{ $booking->id }} })
        });
        const data = await res.json();
        if (data.status && data.authorization_url) {
            window.location.href = data.authorization_url;
        } else {
            alert('Could not initialize payment. Please try again.');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Pay ₦{{ number_format($booking->total_amount, 0) }}';
        }
    } catch(e) {
        alert('Payment initialization failed. Please check your connection.');
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-credit-card mr-2"></i>Pay ₦{{ number_format($booking->total_amount, 0) }}';
    }
}
</script>
@endpush
