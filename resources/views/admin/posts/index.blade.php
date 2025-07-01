@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">All Posts</h1>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Create Post</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($posts->count())
            <div class="row g-4">
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <div class="card post-card shadow-sm h-100">
                            @if($post->post_image)
                                <img src="{{ asset('images/' . $post->post_image) }}" class="card-img-top" alt="Post Image">
                            @else
                                <img src="{{ asset('images/unnamed.jpg') }}" class="card-img-top" alt="No Image">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($post->content, 100) }}</p>
                                
                                <div class="mt-auto d-flex justify-content-between">
                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-post-form d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-confirm-btn">Delete</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info text-center">
                No posts found. <a href="{{ route('posts.create') }}">Create your first post</a>.
            </div>
        @endif
    </div>

@endsection