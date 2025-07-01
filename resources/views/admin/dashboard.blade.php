@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="container py-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Admin Dashboard</h2>
        {{-- Optional: Dark mode toggle --}}
        {{-- <button class="btn btn-outline-secondary" onclick="toggleTheme()">Dark Mode</button> --}}
    </div>

    <!-- Welcome Card -->
    <div class="alert alert-primary shadow-sm rounded-3 mb-4">
        <i class="bi bi-person-circle me-2"></i> Welcome, Admin!
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter and Table Card -->
    <div class="card shadow-sm rounded-4 m-3" >
        <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">User List</h5>
            <div class="w-auto">
                <label for="roleFilter" class="form-label fw-semibold mb-0 me-2">Filter by Role:</label>
                <select id="roleFilter" class="form-select form-select-sm d-inline-block w-auto">
                    <option value="">All</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover table-bordered table-striped mb-0 align-middle" id="user-table" style="min-width: 700px;">
                <thead class="table-light text-center">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th style="width: 150px;">Role</th>
                        <th style="width: 180px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">
                            @if ($user->is_admin)
                                <span class="badge bg-success">Admin</span>
                            @else
                                <form action="{{ route('admin.make-admin', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">Make Admin</button>
                                </form>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.send-welcome-email', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-primary">Send Email</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted fst-italic py-3">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
