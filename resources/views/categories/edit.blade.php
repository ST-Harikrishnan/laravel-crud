@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container py-5">
    <h2>Edit Category</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Important for update -->

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
        </div>

        {{-- Existing Images --}}
        <div class="mb-3">
            <label>Existing Images:</label>
            <div class="d-flex flex-wrap gap-2">
                @forelse($category->images as $image)
                    <div class="position-relative">
                        <img src="{{ asset($image->image_path) }}" width="80" class="border rounded">
                        {{-- Optional: Add delete logic here --}}
                    </div>
                @empty
                    <p class="text-muted">No images uploaded.</p>
                @endforelse
            </div>
        </div>

        {{-- Upload New Images --}}
        <div class="mb-3">
            <label for="images" class="form-label">Add More Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
            <small class="text-muted">You can upload multiple new images.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
