@extends('layouts.app')

@section('title', 'Edit Post')


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

                <form action="{{ route('user.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
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
                        <label for="post_image" class="form-label">Post Image:</label>
                        <input type="file" name="images[]" id="post_image" class="form-control" multiple>
                    </div>        
                    <div class="d-flex justify-content-between mt-4 mb-4">
                        <button type="submit" class="btn btn-success">Update Post</button>
                        <a href="{{ route('user.posts.index' )}}" class="btn btn-secondary">Back to Posts</a>
                    </div>
                </form>  
                  @if($post->images->count())
                <div class="mb-3">
                    <label>Blog Images:</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($post->images as $image)
                            <div class="position-relative border p-1" style="width: 100px;">
                                <img src="{{ asset($image->image_path) }}" alt="Post Image" class="img-fluid rounded">

                                <form action="{{ route('post-images.destroy', $image->id) }}" method="POST" onsubmit="return confirm('Delete this image?')" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger w-100">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            </div>
        </div>
    </div>
@endsection
