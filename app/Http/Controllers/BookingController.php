<?php
namespace App\Http\Controllers;

use App\Models\{Booking, Property, Setting};
use App\Mail\BookingConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Property $property, Request $request)
    {
        $checkIn  = $request->get('check_in');
        $checkOut = $request->get('check_out');
        $guests   = $request->get('guests', 1);

        $nights = 1;
        if ($checkIn && $checkOut) {
            $nights = max(1, Carbon::parse($checkIn)->diffInDays(Carbon::parse($checkOut)));
        }

        $total = $property->effective_price * $nights;

        return view('frontend.booking.create', compact('property', 'checkIn', 'checkOut', 'guests', 'nights', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id'     => 'required|exists:properties,id',
            'check_in_date'   => 'required|date|after_or_equal:today',
            'check_out_date'  => 'required|date|after:check_in_date',
            'guests'          => 'required|integer|min:1',
            'customer_name'   => 'required|string|max:255',
            'customer_email'  => 'required|email',
            'customer_phone'  => 'required|string',
            'payment_method'  => 'required|in:paystack,whatsapp',
        ]);

        $property  = Property::findOrFail($request->property_id);
        $nights    = Carbon::parse($request->check_in_date)->diffInDays($request->check_out_date);
        $price     = $property->effective_price;
        $subtotal  = $price * $nights;
        $taxPct    = (float) Setting::get('tax_percentage', 0);
        $svc       = (float) Setting::get('service_charge', 0);
        $tax       = ($subtotal * $taxPct) / 100;
        $total     = $subtotal + $tax + $svc;

        $booking = Booking::create([
            'property_id'      => $property->id,
            'user_id'          => auth()->id(),
            'check_in_date'    => $request->check_in_date,
            'check_out_date'   => $request->check_out_date,
            'nights'           => $nights,
            'guests'           => $request->guests,
            'price_per_night'  => $price,
            'subtotal'         => $subtotal,
            'tax'              => $tax,
            'service_charge'   => $svc,
            'total_amount'     => $total,
            'customer_name'    => $request->customer_name,
            'customer_email'   => $request->customer_email,
            'customer_phone'   => $request->customer_phone,
            'special_request'  => $request->special_request,
            'payment_method'   => $request->payment_method,
            'booking_status'   => 'pending',
            'payment_status'   => 'pending',
            'source'           => 'website',
        ]);

        try {
            Mail::to($booking->customer_email)->send(new BookingConfirmation($booking));
        } catch (\Exception $e) {}

        if ($request->payment_method === 'whatsapp') {
            return redirect()->route('booking.whatsapp', $booking);
        }

        return redirect()->route('payment.initiate', $booking->id);
    }

    public function confirmation(Booking $booking)
    {
        return view('frontend.booking.confirmation', compact('booking'));
    }

    public function whatsappRedirect(Booking $booking)
    {
        $number = Setting::get('whatsapp_number', '2348012345678');
        $msg = "Hello, I'd like to confirm my booking:\n"
             . "Reference: {$booking->booking_reference}\n"
             . "Property: {$booking->property->name}\n"
             . "Check-in: {$booking->check_in_date->format('d M Y')}\n"
             . "Check-out: {$booking->check_out_date->format('d M Y')}\n"
             . "Total: ₦".number_format($booking->total_amount, 0);
        return redirect("https://wa.me/{$number}?text=".urlencode($msg));
    }
}
