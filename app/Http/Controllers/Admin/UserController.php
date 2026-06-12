<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index(Request $request) {
        $query = User::query();
        if ($request->role) $query->where('role', $request->role);
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name','like','%'.$request->search.'%')
                  ->orWhere('email','like','%'.$request->search.'%');
            });
        }
        $users = $query->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }
    
    public function create() {
        return view('admin.users.create');
    }
    
    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manager,client',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => $request->boolean('is_active', true),
        ]);
        return redirect()->route('admin.users.index')->with('success','User created.');
    }
    
    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);
        $data = $request->except(['_token','_method','password']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','User updated.');
    }
    
    public function destroy(User $user) {
        if ($user->id === auth()->id()) {
            return back()->with('error','Cannot delete yourself.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
    
    public function toggleStatus(User $user) {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success','Status updated.');
    }
}
