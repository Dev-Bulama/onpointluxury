<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\{Property, Booking};

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $propertyIds = Property::where('user_id', $user->id)->pluck('id');

        $stats = [
            'properties' => $propertyIds->count(),
            'bookings'   => Booking::whereIn('property_id', $propertyIds)->count(),
            'pending'    => Booking::whereIn('property_id', $propertyIds)->where('booking_status', 'pending')->count(),
            'revenue'    => Booking::whereIn('property_id', $propertyIds)->where('payment_status', 'paid')->sum('total_amount'),
        ];

        $recent = Booking::with('property')
            ->whereIn('property_id', $propertyIds)
            ->latest()->take(10)->get();

        return view('manager.dashboard', compact('stats', 'recent'));
    }
}
