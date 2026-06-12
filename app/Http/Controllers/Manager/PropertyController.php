<?php
namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::withCount('bookings')
            ->where('user_id', auth()->id())
            ->latest()->paginate(20);
        return view('manager.properties', compact('properties'));
    }
}
