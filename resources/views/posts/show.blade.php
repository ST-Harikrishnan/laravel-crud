<!DOCTYPE html>
<html>
<head>
    <title>View Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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


            <div class="card-footer">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
