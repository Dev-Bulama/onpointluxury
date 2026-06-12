<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bookings = Booking::where('user_id', $user->id)->latest()->take(5)->get();
        $totalBookings    = Booking::where('user_id', $user->id)->count();
        $upcomingBookings = Booking::where('user_id', $user->id)
            ->whereIn('booking_status', ['confirmed', 'paid', 'reserved'])
            ->where('check_in_date', '>=', now())
            ->count();
        $totalSpent       = Booking::where('user_id', $user->id)->where('payment_status', 'paid')->sum('total_amount');
        $recentBookings   = $bookings;
        return view('client.dashboard', compact('recentBookings', 'totalBookings', 'upcomingBookings', 'totalSpent'));
    }
}
