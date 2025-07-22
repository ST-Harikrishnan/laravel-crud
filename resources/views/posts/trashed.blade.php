@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Trashed Posts</h2>

    @if ($posts->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->deleted_at->diffForHumans() }}</td>
                    <td>
                        <form action="{{ route('posts.restore', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Restore</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $posts->links() }}
    @else
        <p>No trashed posts.</p>
    @endif
</div>
@endsection
