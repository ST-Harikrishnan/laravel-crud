@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="container py-5">
    <h2>Create Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" class="form-control" id="name"
                   value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Category Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <small class="text-muted">You can upload multiple images (jpg, png, jpeg, gif).</small>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
