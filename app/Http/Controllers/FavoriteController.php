<?php
namespace App\Http\Controllers;

use App\Models\{Property, Favorite};
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $request->validate(['property_id' => 'required|exists:properties,id']);
        $user = auth()->user();
        $exists = $user->favorites()->where('property_id', $request->property_id)->exists();

        if ($exists) {
            $user->favorites()->where('property_id', $request->property_id)->delete();
            return response()->json(['favorited' => false]);
        } else {
            $user->favorites()->create(['property_id' => $request->property_id]);
            return response()->json(['favorited' => true]);
        }
    }
}
