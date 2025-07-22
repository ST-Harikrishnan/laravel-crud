@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Register</h2>
  <a href="{{ route('google.login') }}" class="btn btn-danger">
    <i class="bi bi-google me-2"></i> Login with Google
</a>
<a href="{{ route('github.login') }}" class="btn btn-dark">
    Login with GitHub
</a>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name">Name</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone_number">Phone Number</label>
            <input id="phone_number" type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="profile_image">Profile Image</label>
            <input id="profile_image" type="file" name="profile_image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>

    
    </form>
</div>
@endsection
