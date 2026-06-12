<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('client.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update(['name' => $request->name, 'phone' => $request->phone]);

        if ($request->filled('password')) {
            $request->validate([
                'current_password'      => 'required',
                'password'              => 'required|min:6|confirmed',
            ]);
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }
}
