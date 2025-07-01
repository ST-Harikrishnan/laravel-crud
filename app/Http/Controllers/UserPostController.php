<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Tag;

class UserPostController extends Controller
{
    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        $tags       = Tag::all();
        return view('user.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'content'     => 'required|string',
        'post_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'category_id' => 'required|exists:categories,id',
        'tags'        => 'nullable|array',
        'tags.*'      => 'string|max:255',
    ]);

    if ($request->hasFile('post_image')) {
        $filename = time() . '.' . $request->post_image->extension();
        $request->post_image->move(public_path('images'), $filename);
        $validated['post_image'] = $filename;
    }

    $validated['user_id'] = auth()->id();

    $post = Post::create($validated);

    $tagIds = [];
    if ($request->has('tags')) {
        foreach ($request->tags as $tagName) {
            $tag = \App\Models\Tag::firstOrCreate([
                'name' => trim($tagName),
            ]);
            $tagIds[] = $tag->id;
        }
        $post->tags()->attach($tagIds);
    }

    return redirect()->route('user.posts.create')->with('success', 'Post submitted successfully!');
}
    public function show(\App\Models\Post $post)
    {
        return view('user.posts.show', compact('post'));
    }

}
