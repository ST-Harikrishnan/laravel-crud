@extends('layouts.app')
@section('title', 'Edit Tag')

@section('content')
<div class="container py-4">
    <h2>Edit Tag</h2>
    <form action="{{ route('tags.update', $tag->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control" required>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
