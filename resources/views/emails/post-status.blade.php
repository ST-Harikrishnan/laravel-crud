<h2>Hello {{ $post->user->name }},</h2>

@if ($type == 'created')
    <p>Your post titled "<strong>{{ $post->title }}</strong>" has been submitted and is pending approval.</p>
@elseif ($type == 'approved')
    <p>Good news! Your post titled "<strong>{{ $post->title }}</strong>" has been approved and published.</p>
@endif

<p>Thank you for contributing!</p>
