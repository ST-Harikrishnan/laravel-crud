<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index(Request $request)
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'phone_number'  => 'required|string|max:20',
            'password'      => 'nullable|string|min:6|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('profile_image')) {
    $image = $request->file('profile_image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();

    // Save image to /public/images/profiles/
    $image->move(public_path('images/profiles'), $imageName);

    // Optional: Delete old image if needed
    if ($user->profile_image && file_exists(public_path('images/profiles/' . $user->profile_image))) {
        unlink(public_path('images/profiles/' . $user->profile_image));
    }

    $user->profile_image = $imageName;
}


        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.profile.index')->with('success', 'Profile updated successfully!');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Account deleted.');
    }
}
