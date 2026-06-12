<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('property')->latest()->paginate(12);
        return view('client.favorites', compact('favorites'));
    }

    public function remove(Request $request)
    {
        $request->validate(['property_id' => 'required|exists:properties,id']);
        auth()->user()->favorites()->where('property_id', $request->property_id)->delete();
        return back()->with('success', 'Removed from favorites.');
    }
}
