@extends('layouts.app')

@section('title', 'Posts')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 fw-bold">All Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary shadow">+ Create Post</a>
    </div>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($posts->count())
        <div class="row g-4">
            @foreach ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if($post->post_image)
                            <img src="{{ asset('images/' . $post->post_image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Post Image">
                        @else
                            <img src="{{ asset('images/unnamed.jpg') }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="No Image">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">{{ $post->title }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($post->content, 100) }}</p>

                            <p class="mb-1">
                                <strong class="text-primary">Category:</strong>
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </p>

                            <div class="mb-2">
                                @foreach ($post->tags as $tag)
                                    <span class="badge bg-light text-dark border">{{ $tag->name }}</span>
                                @endforeach
                            </div>

                            <div class="mt-auto d-flex flex-wrap gap-2">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>

                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm-btn">Delete</button>
                                </form>

                                @if (!$post->is_approved && auth()->user()->is_admin)
                                    <form action="{{ route('posts.approve', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">Approve</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center mt-5">
            No posts found. <a href="{{ route('posts.create') }}">Create your first post</a>.
        </div>
    @endif
</div>
@endsection
