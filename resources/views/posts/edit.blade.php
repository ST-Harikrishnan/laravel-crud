@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Edit Post</h2>

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

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category:</label>
                    <select name="category_id" id="category_id" class="form-select select2-single" required>
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                {{ (old('category_id', $post->category_id) == $category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Tags:</label>
                    <select class="js-example-basic-multiple js-example-tags" name="tags[]" id="tags" multiple="multiple"
                        style="width: 100%;" required>
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" 
                                {{ (collect(old('tags', $post->tags->pluck('name')))->contains($tag->name)) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $post->title) }}">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea name="content" class="form-control" id="content" rows="5">{{ old('content', $post->content) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="post_image" class="form-label">Upload New Image:</label>
                        <input type="file" name="post_image" class="form-control" id="post_image">
                    </div>

                    @if ($post->post_image)
                        <div class="mb-3">
                            <label class="form-label">Current Image:</label>
                            <div>
                                <img src="{{ asset('images/' . $post->post_image) }}" alt="Post Image" class="img-fluid rounded post-image-preview">
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">Update Post</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection