<?php
namespace App\Http\Controllers;

use App\Models\{Property, PropertyType, Testimonial, BlogPost, Booking, User};

class HomeController extends Controller
{
    public function index()
    {
        $featuredProperties = Property::with(['propertyType', 'propertyCategory', 'images'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->latest()->take(8)->get();

        $allProperties = Property::with(['propertyType', 'propertyCategory', 'images'])
            ->where('status', 'published')
            ->latest()->take(6)->get();

        $propertyTypes = PropertyType::where('is_active', true)
            ->withCount(['properties' => fn($q) => $q->where('status', 'published')])
            ->having('properties_count', '>', 0)
            ->take(10)->get();

        $testimonials = Testimonial::where('is_active', true)
            ->orderBy('sort_order')->take(6)->get();

        $blogPosts = BlogPost::where('is_published', true)
            ->latest('published_at')->take(3)->get();

        $stats = [
            'properties' => Property::where('status', 'published')->count() ?: 50,
            'bookings'   => Booking::count() ?: 200,
            'clients'    => User::where('role', 'client')->count() ?: 150,
            'cities'     => 5,
        ];

        return view('frontend.home', compact(
            'featuredProperties', 'allProperties', 'propertyTypes',
            'testimonials', 'blogPosts', 'stats'
        ));
    }
}
