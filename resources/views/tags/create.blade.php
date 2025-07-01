@extends('layouts.app')
@section('title', 'Create Tag')

@section('content')
<div class="container py-4">
    <h2>Create Tag</h2>
    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button class="btn btn-success">Save</button>
    </form>
</div>
@endsection
