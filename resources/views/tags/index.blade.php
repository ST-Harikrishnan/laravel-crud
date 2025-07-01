@extends('layouts.app')
@section('title', 'Tags')

@section('content')
<div class="container py-4">
    <h2>Tags</h2>
    <a href="{{ route('tags.create') }}" class="btn btn-success mb-3">Add Tag</a>
    <table class="table table-bordered">
        <thead><tr><th>Name</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this tag?')" class="btn btn-danger btn-sm ">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
