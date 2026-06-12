<?php
namespace App\Http\Controllers;

use App\Models\{Booking, Payment, Setting};
use App\Mail\BookingConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Http, Mail};

class PaymentController extends Controller
{
    public function initiate(Booking $booking)
    {
        if ($booking->payment_status === 'paid') {
            return redirect()->route('booking.confirmation', $booking);
        }
        return view('frontend.payment.initiate', compact('booking'));
    }

    public function initialize(Request $request)
    {
        $request->validate(['booking_id' => 'required|exists:bookings,id']);
        $booking = Booking::findOrFail($request->booking_id);

        if ($booking->payment_status === 'paid') {
            return response()->json(['status' => false, 'message' => 'Already paid']);
        }

        $secretKey = Setting::get('paystack_secret_key') ?: config('services.paystack.secret_key');

        $response = Http::withToken($secretKey)->post('https://api.paystack.co/transaction/initialize', [
            'email'     => $booking->customer_email,
            'amount'    => (int) ($booking->total_amount * 100),
            'reference' => $booking->booking_reference.'_'.time(),
            'callback_url' => route('payment.callback'),
            'metadata'  => [
                'booking_id'        => $booking->id,
                'booking_reference' => $booking->booking_reference,
                'customer_name'     => $booking->customer_name,
            ],
        ]);

        $data = $response->json();
        if ($data['status'] ?? false) {
            return response()->json([
                'status'            => true,
                'authorization_url' => $data['data']['authorization_url'],
                'reference'         => $data['data']['reference'],
            ]);
        }

        return response()->json(['status' => false, 'message' => $data['message'] ?? 'Initialization failed'], 400);
    }

    public function callback(Request $request)
    {
        $reference = $request->get('reference') ?? $request->get('trxref');
        if (!$reference) return redirect()->route('home')->with('error', 'Invalid payment reference.');

        $secretKey = Setting::get('paystack_secret_key') ?: config('services.paystack.secret_key');
        $response  = Http::withToken($secretKey)->get("https://api.paystack.co/transaction/verify/{$reference}");
        $data      = $response->json();

        if (!($data['status'] ?? false) || ($data['data']['status'] ?? '') !== 'success') {
            return redirect()->route('home')->with('error', 'Payment verification failed.');
        }

        $meta      = $data['data']['metadata'] ?? [];
        $bookingId = $meta['booking_id'] ?? null;
        $booking   = $bookingId ? Booking::find($bookingId) : null;

        if (!$booking) {
            $ref       = explode('_', $reference)[0];
            $booking   = Booking::where('booking_reference', $ref)->first();
        }

        if (!$booking) return redirect()->route('home')->with('error', 'Booking not found.');

        Payment::create([
            'booking_id'          => $booking->id,
            'paystack_reference'  => $reference,
            'amount'              => $data['data']['amount'] / 100,
            'currency'            => $data['data']['currency'],
            'channel'             => $data['data']['channel'],
            'status'              => 'success',
            'paid_at'             => now(),
            'gateway_response'    => $data['data']['gateway_response'] ?? 'Approved',
        ]);

        $booking->update(['payment_status' => 'paid', 'booking_status' => 'confirmed']);

        try { Mail::to($booking->customer_email)->send(new BookingConfirmation($booking)); } catch (\Exception $e) {}

        return redirect()->route('booking.confirmation', $booking)->with('success', 'Payment successful! Your booking is confirmed.');
    }
}
