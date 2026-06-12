<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Property, PropertyType, PropertyCategory, Amenity, User};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller {
    public function index(Request $request) {
        $query = Property::with(['propertyType','propertyCategory','manager']);
        if ($request->search) {
            $query->where('name','like','%'.$request->search.'%')
                  ->orWhere('location','like','%'.$request->search.'%');
        }
        if ($request->status) $query->where('status', $request->status);
        if ($request->type_id) $query->where('property_type_id', $request->type_id);
        $properties = $query->latest()->paginate(15);
        $types = PropertyType::all();
        return view('admin.properties.index', compact('properties','types'));
    }
    
    public function create() {
        $types = PropertyType::where('is_active',true)->get();
        $categories = PropertyCategory::where('is_active',true)->get();
        $amenities = Amenity::where('is_active',true)->get();
        $managers = User::where('role','manager')->where('is_active',true)->get();
        return view('admin.properties.create', compact('types','categories','amenities','managers'));
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'location' => 'required|string',
        ]);
        
        $data = $request->except(['_token','featured_image','gallery','amenities']);
        $data['slug'] = Str::slug($request->name) . '-' . Str::random(5);
        
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('properties','public');
        }
        
        $property = Property::create($data);
        
        if ($request->amenities) {
            $property->amenities()->sync($request->amenities);
        }
        
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $i => $img) {
                $path = $img->store('properties/gallery','public');
                $property->images()->create(['image'=>$path,'sort_order'=>$i]);
            }
        }
        
        return redirect()->route('admin.properties.index')->with('success','Property created successfully.');
    }
    
    public function edit(Property $property) {
        $types = PropertyType::where('is_active',true)->get();
        $categories = PropertyCategory::where('is_active',true)->get();
        $amenities = Amenity::where('is_active',true)->get();
        $managers = User::where('role','manager')->where('is_active',true)->get();
        $selectedAmenities = $property->amenities->pluck('id')->toArray();
        return view('admin.properties.edit', compact('property','types','categories','amenities','managers','selectedAmenities'));
    }
    
    public function update(Request $request, Property $property) {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'location' => 'required|string',
        ]);
        
        $data = $request->except(['_token','_method','featured_image','gallery','amenities']);
        
        if ($request->hasFile('featured_image')) {
            if ($property->featured_image) Storage::disk('public')->delete($property->featured_image);
            $data['featured_image'] = $request->file('featured_image')->store('properties','public');
        }
        
        $property->update($data);
        
        if ($request->has('amenities')) {
            $property->amenities()->sync($request->amenities ?? []);
        }
        
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $i => $img) {
                $path = $img->store('properties/gallery','public');
                $property->images()->create(['image'=>$path,'sort_order'=>$property->images()->count() + $i]);
            }
        }
        
        return redirect()->route('admin.properties.index')->with('success','Property updated successfully.');
    }
    
    public function destroy(Property $property) {
        if ($property->featured_image) Storage::disk('public')->delete($property->featured_image);
        $property->delete();
        return redirect()->route('admin.properties.index')->with('success','Property deleted.');
    }
    
    public function show(Property $property) {
        $property->load(['propertyType','propertyCategory','amenities','images','rooms','manager','bookings','reviews']);
        return view('admin.properties.show', compact('property'));
    }
}
