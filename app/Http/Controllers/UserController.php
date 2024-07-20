<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->paginate(10);

        if ($request->has('search')) {
            $search = $request->query('search');
            $users->where('username', 'like', '%' . $search . '%');
        }

        return view('admin.user.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Admin,Kasir',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->address = $request->address;

        if($request->hasFile('user_image')){
            $imageName = time().'.'.$request->product_image->extension();  
            $request->product_image->move(public_path('user_image'), $imageName);
            $user->user_image = 'user_image/'.$imageName;
        }
        else {
            $user->user_image = 'default/employee.png';
        }

        $user->save();
        return redirect()->route('admin.user.index')->with('success', 'User added successfully');
    }

    public function edit($id)
    {
        $users = User::orderBy('id', 'DESC')->get();
        $user = User::findOrFail($id);
        return view('admin.user.index', compact('users', 'user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'role' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->role = $request->role;

        if ($request->hasFile('user_image')) {
            if ($user->user_image && $user->user_image !== 'default/employee.png') {
                Storage::disk('public')->delete($user->user_image);
            }

            $image = $request->file('user_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('user_image'), $imageName);
            $user->user_image = 'user_image/' . $imageName;
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->user_image && $user->user_image !== 'default/employee.png') {
            Storage::disk('public')->delete($user->user_image);
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }

    public function profile()
    {
        $user = auth()->user();
        return view('profile', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated');
        }

        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;

        if ($request->hasFile('user_image')) {
            if ($user->user_image && $user->user_image !== 'default/employee.png') {
                Storage::disk('public')->delete($user->user_image);
            }

            $image = $request->file('user_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('user_image'), $imageName);
            $user->user_image = 'user_image/' . $imageName;
        }

        $user->save();
        $redirectTo = route('admin.dashboard');

        if ($user->role == 'Kasir') {
            $redirectTo = route('kasir.dashboard');
        }

        return redirect($redirectTo)->with('success', 'Profile updated successfully');
    }
}
