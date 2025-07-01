@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container py-5">
    <h2>Edit Category</h2>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Important for edit/update -->
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

