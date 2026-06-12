<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('property')->where('user_id', auth()->id());
        if ($request->status) $query->where('booking_status', $request->status);
        $bookings = $query->latest()->paginate(10);
        return view('client.bookings', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== auth()->id(), 403);
        $booking->load(['property', 'payments']);
        return view('client.booking-show', compact('booking'));
    }
}
