<?php

namespace App\Http\Controllers\Auth;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeUserMail;
use Illuminate\Support\Facades\Mail;
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
            $image = $request->file('profile_image');

            // Create folder if not exists
            $destinationPath = public_path('images/profiles');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($destinationPath, $imageName);
        }

        $user = User::create([
            'name'          => $request->name,
            'email'         => $request->email,
            'phone_number'  => $request->phone_number,
            'password'      => Hash::make($request->password),
            'profile_image' => $imageName,
        ]);

        auth()->login($user);
        event(new UserRegistered($user));

        return redirect()->route('admin.dashboard')->with('success', 'Registered successfully!');
    }
}
