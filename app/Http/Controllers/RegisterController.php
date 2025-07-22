<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeUserMail;
class RegisterController extends Controller
{
   public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'phone_number'      => 'required|string|max:20',
            'password'          => 'required|string|min:6|confirmed',
            'profile_image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('profile_image')) {
            $imageName = time() . '.' . $request->profile_image->extension();
            $request->profile_image->move(public_path('images/profiles'), $imageName);
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone_number'  => $request->phone_number,
            'password'      => Hash::make($request->password),
            'profile_image' => $imageName,
        ]);

        auth()->login($user);
        Mail::to($user->email)->send(new WelcomeUserMail($user));

        return redirect()->route('dashboard')->with('success', 'Registered successfully!');
    }
}
