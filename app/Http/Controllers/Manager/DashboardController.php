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

        $assignedPropertiesCount = $propertyIds->count();
        $activeBookings  = Booking::whereIn('property_id', $propertyIds)->whereIn('booking_status', ['confirmed','checked_in'])->count();
        $pendingBookings = Booking::whereIn('property_id', $propertyIds)->where('booking_status', 'pending')->count();
        $totalRevenue    = Booking::whereIn('property_id', $propertyIds)->where('payment_status', 'paid')->sum('total_amount');

        $stats = [
            'properties' => $assignedPropertiesCount,
            'bookings'   => Booking::whereIn('property_id', $propertyIds)->count(),
            'pending'    => $pendingBookings,
            'revenue'    => $totalRevenue,
        ];

        $recent = $recentBookings = Booking::with('property')
            ->whereIn('property_id', $propertyIds)
            ->latest()->take(10)->get();

        $assignedProperties = $assignedPropertiesCount;

        return view('manager.dashboard', compact('stats', 'recent', 'recentBookings', 'assignedProperties', 'activeBookings', 'pendingBookings', 'totalRevenue'));
    }
}
