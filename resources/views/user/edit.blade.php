@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mt-5">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Name --}}
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control">
        </div>

        {{-- Role --}}
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select">
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
            </select>
        </div>

        {{-- Profile Image --}}
        <div class="mb-3">
            <label>Profile Image</label>
            <input type="file" name="profile_image" class="form-control">
            @if($user->profile_image)
                <img src="{{ asset('images/profiles/' . $user->profile_image) }}" alt="Profile" width="80" class="mt-2">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection
