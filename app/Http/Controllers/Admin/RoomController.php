<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Room, Property};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller {
    public function index(Request $request) {
        $query = Room::with('property');
        if ($request->property_id) $query->where('property_id', $request->property_id);
        $rooms = $query->latest()->paginate(20);
        $properties = Property::where('status','published')->get();
        return view('admin.rooms.index', compact('rooms','properties'));
    }
    
    public function create() {
        $properties = Property::where('status','published')->get();
        return view('admin.rooms.create', compact('properties'));
    }
    
    public function store(Request $request) {
        $request->validate(['name' => 'required','property_id' => 'required|exists:properties,id','price_per_night' => 'required|numeric']);
        $data = $request->except(['_token','image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms','public');
        }
        Room::create($data);
        return redirect()->route('admin.rooms.index')->with('success','Room created.');
    }
    
    public function edit(Room $room) {
        $properties = Property::where('status','published')->get();
        return view('admin.rooms.edit', compact('room','properties'));
    }
    
    public function update(Request $request, Room $room) {
        $data = $request->except(['_token','_method','image']);
        if ($request->hasFile('image')) {
            if ($room->image) Storage::disk('public')->delete($room->image);
            $data['image'] = $request->file('image')->store('rooms','public');
        }
        $room->update($data);
        return redirect()->route('admin.rooms.index')->with('success','Room updated.');
    }
    
    public function destroy(Room $room) {
        if ($room->image) Storage::disk('public')->delete($room->image);
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success','Room deleted.');
    }
}
