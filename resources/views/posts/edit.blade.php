<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .post-image-preview {
            max-height: 250px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-4">Edit Post</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $post->title) }}">
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea name="content" class="form-control" id="content" rows="5">{{ old('content', $post->content) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="post_image" class="form-label">Upload New Image:</label>
                        <input type="file" name="post_image" class="form-control" id="post_image">
                    </div>

                    @if ($post->post_image)
                        <div class="mb-3">
                            <label class="form-label">Current Image:</label>
                            <div>
                                <img src="{{ asset('images/' . $post->post_image) }}" alt="Post Image" class="img-fluid rounded post-image-preview">
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success">Update Post</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
