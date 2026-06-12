<?php
namespace App\Http\Controllers;

use App\Models\{Property, PropertyType, Testimonial, BlogPost};

class HomeController extends Controller
{
    public function index()
    {
        $featured = Property::with(['type', 'category'])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->take(6)->get();

        $types = PropertyType::withCount(['properties' => fn($q) => $q->where('status','published')])
            ->having('properties_count', '>', 0)
            ->take(8)->get();

        $testimonials = Testimonial::where('status', 'active')->take(6)->get();
        $blog = BlogPost::where('status', 'published')->latest('published_at')->take(3)->get();

        return view('frontend.home', compact('featured', 'types', 'testimonials', 'blog'));
    }
}
