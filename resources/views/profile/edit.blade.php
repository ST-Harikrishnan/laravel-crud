@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container py-5">
    <h2>Edit Profile</h2>

    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
            @error('name') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            @error('email') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control">
            @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="password" class="form-control">
            @error('password') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
            <img src="{{ $user->profile_image ? asset('images/profiles/' . $user->profile_image) : asset('images/default-profile.png') }}" width="100" class="rounded-circle mb-3">
        </div>

        <button type="submit" class="btn btn-success">Update Profile</button>
        <a href="{{ route('user.profile.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
