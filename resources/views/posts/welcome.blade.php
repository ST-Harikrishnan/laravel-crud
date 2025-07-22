@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-5 fw-bold">Latest Posts</h1>
            <p class="text-muted">Browse through our latest articles and insights</p>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            @if (in_array(auth()->user()?->role, ['admin', 'editor']))
                <a href="{{ route('user.posts.create') }}" class="btn btn-primary shadow">+ Create Post</a>
            @endif
        </div>

        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <form method="GET" action="{{ route('posts.welcome') }}"
                    class="row g-3 align-items-center justify-content-center">
                    <div class="col-auto">
                        <label for="categoryFilter" class="fw-semibold mb-0">Category:</label>
                        <select id="categoryFilter" name="category_id" class="form-select form-select-sm"
                            onchange="this.form.submit()">
                            <option value="">All</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

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
                            <img src="{{ asset('images/' . ($post->post_image ?? 'unnamed.jpg')) }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="Post Image">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-semibold">{{ $post->title }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($post->content, 100) }}</p>

                                <p class="mb-2">
                                    <strong class="text-primary">Category:</strong>
                                    {{ $post->category->name ?? 'Uncategorized' }}
                                </p>

                                <div class="mb-3">
                                    @forelse ($post->tags as $tag)
                                        <span class="badge bg-light text-dark border">{{ $tag->name }}</span>
                                    @empty
                                        <span class="text-muted small">No tags</span>
                                    @endforelse
                                </div>
                                <div class="mt-auto d-flex flex-wrap gap-2">
                                    <a href="{{ route('user.posts.show', $post->id) }}"
                                        class="btn btn-sm btn-outline-primary">View</a>

                                    @if (auth()->check() && auth()->id() === $post->user_id && in_array(auth()->user()->role, ['editor', 'admin']))
                                        <a href="{{ route('user.posts.edit', $post->id) }}"
                                            class="btn btn-sm btn-outline-warning">Edit</a>

                                        <form action="{{ route('user.posts.destroy', $post->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
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
                                            <input type="text" name="body" class="form-control" placeholder="Add a comment..."
                                                required>
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
                No posts available right now.
            </div>
        @endif
    </div>
@endsection