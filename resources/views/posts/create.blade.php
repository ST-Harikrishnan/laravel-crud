<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Create New Post</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <textarea name="content" class="form-control" id="content" rows="5">{{ old('content') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="post_image" class="form-label">Post Image:</label>
                <input type="file" name="post_image" class="form-control" id="post_image">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
