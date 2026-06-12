<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Property};
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $propertyIds = Property::where('user_id', auth()->id())->pluck('id');
        $query = Booking::with('property')->whereIn('property_id', $propertyIds);
        if ($request->status) $query->where('booking_status', $request->status);
        $bookings = $query->latest()->paginate(20);
        return view('manager.bookings', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $propertyIds = Property::where('user_id', auth()->id())->pluck('id');
        abort_if(!$propertyIds->contains($booking->property_id), 403);
        $booking->load(['property', 'payments']);
        return view('manager.booking-show', compact('booking'));
    }
}
