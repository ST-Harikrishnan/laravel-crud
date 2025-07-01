@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Create New Post</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="category_id" class="form-label">Category:</label>
            <select name="category_id" id="category_id" class="form-select select2-single" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Tags:</label> <br>
            <select class="js-example-basic-multiple  js-example-tags" name="tags[]" id="tags" multiple="multiple"
                style="width: 100%;" required>
                @foreach ($tags as $tag)
                <option value=" {{ $tag->name }}" {{ collect(old('tags'))->contains($tag->name) ? 'selected' : '' }}>
                    {{ $tag->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea name="content" class="form-control" id="content" rows="5">{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="post_image" class="form-label">Post Image:</label>
            <input type="file" name="post_image" class="form-control" id="post_image">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
