<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
        ]);

        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('user_image'), $imageName);
            $user->image = 'user_image/' . $imageName;
        }

        $user->save();

        $redirectTo = route('admin.dashboard');
        if ($user->role == 'Kasir') {
            $redirectTo = route('kasir.dashboard');
        }

        return redirect($redirectTo)->with('success', 'Profile updated successfully');
    }
}
