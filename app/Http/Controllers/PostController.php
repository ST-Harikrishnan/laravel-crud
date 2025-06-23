<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required',
            'content'    => 'required',
            'post_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('post_image')) {
            $imageName = time() . '.' . $request->post_image->extension();
            $request->post_image->move(public_path('images'), $imageName);
        }

        Post::create([
            'title'      => $request->title,
            'content'    => $request->content,
            'post_image' => $imageName,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'      => 'required',
            'content'    => 'required',
            'post_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('post_image')) {
            if ($post->post_image && file_exists(public_path('images/' . $post->post_image))) {
                unlink(public_path('images/' . $post->post_image));
            }

            $imageName = time() . '.' . $request->post_image->extension();
            $request->post_image->move(public_path('images'), $imageName);

            $data['post_image'] = $imageName;
        }

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
