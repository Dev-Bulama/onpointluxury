<?php
namespace App\Http\Controllers;

use App\Models\{Property, PropertyType, PropertyCategory, Amenity, Setting};
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {

        $query = Property::with(['propertyType', 'propertyCategory', 'images'])
            ->where('status', 'published');

        // Text search across name, description, location
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('short_description', 'like', "%{$term}%")
                  ->orWhere('location', 'like', "%{$term}%")
                  ->orWhere('city', 'like', "%{$term}%");
            });
        }

        // Location filter (from hero search or sidebar)
        if ($request->filled('location')) {
            $query->where(function ($q) use ($request) {
                $q->where('location', 'like', '%'.$request->location.'%')
                  ->orWhere('city', 'like', '%'.$request->location.'%')
                  ->orWhere('state', 'like', '%'.$request->location.'%');
            });
        }

        if ($request->filled('type')) {
            $type = PropertyType::where('slug', $request->type)->orWhere('id', $request->type)->first();
            if ($type) $query->where('property_type_id', $type->id);
        }

        if ($request->filled('category')) {
            $cat = PropertyCategory::where('slug', $request->category)->orWhere('id', $request->category)->first();
            if ($cat) $query->where('property_category_id', $cat->id);
        }

        if ($request->filled('guests')) {
            $query->where('max_guests', '>=', (int)$request->guests);
        }

        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->filled('amenities')) {
            $query->whereHas('amenities', function ($q) use ($request) {
                $q->whereIn('amenities.id', (array) $request->amenities);
            });
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->orderBy('price_per_night', 'asc'),
            'price_desc' => $query->orderBy('price_per_night', 'desc'),
            'rating'     => $query->orderBy('rating', 'desc'),
            'featured'   => $query->orderBy('is_featured', 'desc'),
            default      => $query->latest(),
        };

        $properties = $query->paginate(12)->withQueryString();
        $propertyTypes = PropertyType::where('is_active', true)
            ->withCount(['properties' => fn($q) => $q->where('status','published')])->get();
        $categories = PropertyCategory::withCount(['properties' => fn($q) => $q->where('status','published')])->get();
        $amenities = Amenity::orderBy('name')->get();

        return view('frontend.properties.index', compact('properties', 'propertyTypes', 'categories', 'amenities'));
    }

    public function show($slug)
    {
        $property = Property::with([
                'propertyType', 'propertyCategory', 'amenities', 'images',
                'reviews' => fn($q) => $q->latest()
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $similar = Property::with(['images'])
            ->where('property_type_id', $property->property_type_id)
            ->where('id', '!=', $property->id)
            ->where('status', 'published')
            ->take(4)->get();

        $isFavorited = auth()->check() &&
            auth()->user()->favorites()->where('property_id', $property->id)->exists();

        $whatsappNumber = Setting::get('whatsapp_number', '2348000000000');

        return view('frontend.properties.show', compact('property', 'similar', 'isFavorited', 'whatsappNumber'));
    }
}
