@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Create New Post</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Category Select --}}
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
        {{-- Title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        {{-- Content --}}
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea name="content" id="content" rows="5" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label for="post_image" class="form-label">Post Image:</label>
            <input type="file" name="post_image" id="post_image" class="form-control">
        </div>

        {{-- Submit --}}
        <div class="d-flex justify-content-between">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection