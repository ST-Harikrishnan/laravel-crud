<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function welcome(Request $request)
    {
        $categories = Category::all();

        $query = Post::where('is_approved', true);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest()->get();

        return view('posts.welcome', compact('posts', 'categories'));
    }
    public function index()
    { 

        $posts = Post::with('tags')->get(); 

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags       = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'content'     => 'required',
            'post_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:255',
        ]);

        $imageName = null;

        if ($request->hasFile('post_image')) {
            $imageName = time() . '.' . $request->post_image->extension();
            $request->post_image->move(public_path('images'), $imageName);
        }

        $post = Post::create([
            'title'       => $request->title,
            'content'     => $request->content,
            'post_image'  => $imageName,
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
        ]);

        
        $tagIds = [];

        foreach ($request->tags as $tagName) {
            $tag = \App\Models\Tag::firstOrCreate([
                'name' => trim($tagName),
            ]);

            $tagIds[] = $tag->id;
        }

        $post->tags()->attach($tagIds);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post       = Post::with('tags')->findOrFail($id); 
        $categories = Category::all();
        $tags       = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required',
            'content'     => 'required',
            'post_image'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $data = $request->only(['title', 'content', 'category_id']);

        // Handle image
        if ($request->hasFile('post_image')) {
            if ($post->post_image && file_exists(public_path('images/' . $post->post_image))) {
                unlink(public_path('images/' . $post->post_image));
            }

            $imageName = time() . '.' . $request->post_image->extension();
            $request->post_image->move(public_path('images'), $imageName);

            $data['post_image'] = $imageName;
        }

        $post->update($data);

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]); // Remove all if none selected
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
    public function approve(Post $post)
    {
        $post->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Post approved successfully.');
    }

}