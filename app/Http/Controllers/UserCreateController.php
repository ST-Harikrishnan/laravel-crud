<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserCreateController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'phone_number'  => 'required|string|max:20',
            'role'          => 'required|string|in:admin,user',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $destinationPath = public_path('images/profiles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        }

        User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'phone_number'  => $request->phone_number,
            'role'          => $request->role,
            'profile_image' => $imageName,
        ]);

        return redirect()->route('user.create')->with('success', 'User created successfully.');
    }

   public function edit(User $user)
{
    return view('user.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email,' . $user->id,
        'phone_number'  => 'required|string|max:20',
        'role'          => 'required|string|in:admin,user,editor',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'password'      => 'nullable|string|min:6|confirmed',
    ]);

    // Handle profile image
    if ($request->hasFile('profile_image')) {
        // Delete old image
        if ($user->profile_image && file_exists(public_path('images/profiles/' . $user->profile_image))) {
            unlink(public_path('images/profiles/' . $user->profile_image));
        }

        $image = $request->file('profile_image');
        $destinationPath = public_path('images/profiles');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move($destinationPath, $imageName);
        $user->profile_image = $imageName;
    }

    // Update user fields
    $user->name         = $request->name;
    $user->email        = $request->email;
    $user->phone_number = $request->phone_number;
    $user->role         = $request->role;

    // Update password if filled
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('user.index')->with('success', 'User updated successfully.');
}


public function destroy(User $user)
{
    if ($user->profile_image && file_exists(public_path('images/profiles/' . $user->profile_image))) {
        unlink(public_path('images/profiles/' . $user->profile_image));
    }

    $user->delete();

    return redirect()->route('user.index')->with('success', 'User deleted successfully.');
}
}
