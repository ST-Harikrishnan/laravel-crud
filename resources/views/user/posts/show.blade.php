@extends('layouts.app')

@section('title', 'Blog Details')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h2>{{ $post->title }}</h2>
            </div>
         <div class="card-body">
    <p class="card-text">{{ $post->content }}</p>

    @if($post->post_image)
        <div class="mt-3">
            <img src="{{ asset('images/' . $post->post_image) }}"
                 alt="Post Image"
                 class="img-fluid rounded"
                 style="max-width: 150px;">
        </div>
    @endif
</div>

<div class="card-footer bg-light d-flex justify-content-between align-items-center">
    <a href="{{ route('user.posts.index') }}" class="btn btn-secondary">← Back to Posts</a>
    <small class="text-muted">
        👁️ {{ $post->views }} views
    </small>
</div>
            <!-- <div class="card-footer">
                <a href="{{ route('user.posts.index') }}" class="btn btn-secondary">Back to Posts</a>
            </div> -->
        </div>
    </div>

@endsection
