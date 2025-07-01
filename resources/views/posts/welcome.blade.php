@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold">Latest Posts</h1>
        <p class="text-muted">Browse through our latest articles and insights</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <form method="GET" action="{{ route('posts.welcome') }}" class="d-flex align-items-center justify-content-center gap-3">
                <label for="categoryFilter" class="fw-semibold mb-0">Select Category:</label>
                <select id="categoryFilter" name="category_id" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if ($posts->count())
       <div class="row g-4">
    @foreach ($posts as $post)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0">
                <img src="{{ asset('images/' . ($post->post_image ?? 'unnamed.jpg')) }}"
                     class="card-img-top" style="height: 200px; object-fit: cover;" alt="Post Image">

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
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">View</a>
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
