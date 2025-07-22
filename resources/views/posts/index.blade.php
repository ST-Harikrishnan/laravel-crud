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

        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <form method="GET" action="{{ route('posts.welcome') }}"
                    class="row g-3 align-items-center justify-content-center">
                    

                    <div class="col-auto">
                        <label for="titleFilter" class="fw-semibold mb-0">Post Title:</label>
                        <input type="text" id="titleFilter" name="title" class="form-control form-control-sm"
                            value="{{ request('title') }}" placeholder="Search title...">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                        <a href="{{ route('posts.welcome') }}" class="btn btn-sm btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        @if ($posts->count())
            <div class="row g-4">
                @foreach ($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0">
                            @if($post->post_image)
                                <img src="{{ asset('images/' . $post->post_image) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="Post Image">
                            @else
                                <img src="{{ asset('images/unnamed.jpg') }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="No Image">
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

                                <div class="mt-3 d-flex flex-wrap align-items-center gap-2">

                                    {{-- View --}}
                                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary"
                                        title="View Post">
                                        <i class="bi bi-eye"></i> View
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary"
                                        title="Edit Post">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm-btn"
                                            title="Delete Post">
                                            <i class="bi bi-trash"></i> Delete 
                                        </button>
                                    </form>

                                    @if (!$post->is_approved && auth()->user()?->role === 'admin')
                                        <form action="{{ route('posts.approve', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Approve Post">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('posts.like', $post->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-info" title="Like this post">
                                            <i class="bi bi-hand-thumbs-up"></i> Like ({{ $post->likes->count() }})
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('posts.comment', $post->id) }}" class="mb-2">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="body" class="form-control" placeholder="Add a comment..." required>
                                            <button type="submit" class="btn btn-sm btn-outline-primary">Comment</button>
                                        </div>
                                    </form>
                                  
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