@extends('layouts.app')

@section('title', 'Admin Post View')

@section('content')
    <div class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h2 class="mb-0">{{ $post->title }}</h2>
            </div>

            <div class="card-body">
                {{-- Post Content --}}
                <p class="card-text fs-5">{{ $post->content }}</p>

                {{-- Featured Image --}}
                @if($post->post_image)
                    <div class="my-3">
                        <img src="{{ asset('images/' . $post->post_image) }}" alt="Post Image" class="img-fluid rounded border"
                            style="max-width: 100%; max-height: 300px; object-fit: cover;">
                    </div>
                @endif

                {{-- Gallery Images --}}
                <h5 class="mt-4">Additional Images</h5>
                @if($post->images->count())
                    <div class="d-flex flex-wrap gap-3 mb-4">
                        @foreach ($post->images as $image)
                            <img src="{{ asset($image->image_path) }}" alt="Post Image" width="120" height="120"
                                class="rounded border object-fit-cover">
                        @endforeach
                    </div>
                @else
                    <span class="text-muted">No additional images available.</span>
                @endif

                <form method="POST" action="{{ route('posts.comment', $post->id) }}" class="mb-2">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="body" class="form-control" placeholder="Add a comment..." required>
                        <button type="submit" class="btn btn-sm btn-outline-primary">Comment</button>
                    </div>
                </form>

                {{-- Comments List --}}
                <h6 class="mb-3">Comments</h6>
                @forelse($post->comments as $comment)
                    <div class="border rounded p-2 mb-2">
                        <strong>{{ $comment->user->name }}</strong>
                        <p class="mb-1">{{ $comment->body }}</p>
                    </div>
                @empty
                    <p class="text-muted">No comments yet.</p>
                @endforelse
            </div>

            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">← Back to Posts</a>
                <small class="text-muted">
                    👁️ {{ $post->views }} views
                </small>
            </div>

        </div>
        @if ($previous || $next)
    <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
        @if ($previous)
            <a href="{{ route('posts.show', $previous->id) }}" class="btn btn-outline-secondary btn-sm">
                ← Previous Post
            </a>
        @else
            <span></span>
        @endif

        @if ($next)
            <a href="{{ route('posts.show', $next->id) }}" class="btn btn-outline-secondary btn-sm">
                Next Post →
            </a>
        @endif
    </div>
@endif
    </div>

@endsection