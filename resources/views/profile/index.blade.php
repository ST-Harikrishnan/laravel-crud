@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <h2>My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <img src="{{ $user->profile_image ? asset('images/profiles/' . $user->profile_image) : asset('images/default-profile.png') }}" width="100" class="rounded-circle mb-3">

            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone:</strong> {{ $user->phone_number }}</p>
            <p><strong>Joined:</strong> {{ $user->created_at->format('d M Y') }}</p>

            <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">Edit Profile</a>

            <!-- <form action="{{ route('user.profile.destroy') }}" method="POST" class="mt-3">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')">Delete Account</button>
            </form> -->
        </div>
    </div>
</div>
@endsection
