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

    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return redirect()->route('admin.user.index')->with('error', 'User not found.');
        }

        return view('admin.user.show', compact('user'));
    }

    public function add()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|in:Admin,Kasir',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'address' => 'nullable|string|max:255',
    ]);

    $user = new User();
    $user->username = $request->username;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->role = $request->role;
    $user->address = $request->address;

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('user_image'), $imageName);
        $user->image = 'user_image/' . $imageName;
    }

    $user->save();

    return redirect()->route('admin.user.index')->with('success', 'User added successfully');
}

    


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:Admin,Kasir'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }

}
