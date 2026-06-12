<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Booking, Payment, Property, User, Review, ContactMessage};

class DashboardController extends Controller {
    public function index() {
        $stats = [
            'total_properties' => Property::count(),
            'total_bookings' => Booking::count(),
            'total_revenue' => Payment::where('status','success')->sum('amount'),
            'pending_bookings' => Booking::where('booking_status','pending')->count(),
            'confirmed_bookings' => Booking::where('booking_status','confirmed')->count(),
            'paid_bookings' => Booking::where('booking_status','paid')->count(),
            'total_users' => User::where('role','client')->count(),
            'total_managers' => User::where('role','manager')->count(),
            'pending_reviews' => Review::where('status','pending')->count(),
            'unread_messages' => ContactMessage::where('is_read', false)->count(),
        ];
        $recent_bookings = Booking::with(['property','user'])->latest()->take(10)->get();
        $recent_payments = Payment::with(['booking.property'])->latest()->take(10)->get();
        $top_properties = Property::withCount('bookings')->orderBy('bookings_count','desc')->take(5)->get();
        
        return view('admin.dashboard', compact('stats','recent_bookings','recent_payments','top_properties'));
    }
}
