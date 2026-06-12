<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginForm() {
        if (Auth::check()) return $this->redirectAfterLogin();
        return view('auth.login');
    }
    
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectAfterLogin();
        }
        
        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }
    
    private function redirectAfterLogin() {
        $user = Auth::user();
        if ($user->isAdmin()) return redirect()->route('admin.dashboard');
        if ($user->isManager()) return redirect()->route('manager.dashboard');
        return redirect()->route('client.dashboard');
    }
    
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
