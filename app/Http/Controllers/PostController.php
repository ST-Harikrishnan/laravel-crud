<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Like;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Mail\PostStatusMail;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function welcome(Request $request)
    {
        $query = Post::with(['category', 'tags', 'likes', 'user'])
             ->where('is_approved', true);

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        $posts = $query->latest()->paginate(9);
        $categories = Category::all();

        return view('posts.welcome', compact('posts', 'categories'));
    }

    public function index(Request $request)
    {
        $query = Post::with(['category', 'tags', 'likes', 'user']);

        if ($request->filled('title')) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        $posts = $query->latest()->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'content'     => 'required',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'string|max:255',
        ]);

        $post = Post::create([
            'title'       => $request->title,
            'content'     => $request->content,
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'is_approved' => false,
        ]);

        // Save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('images/posts'), $imageName);

                $post->images()->create([
                    'image_path' => 'images/posts/' . $imageName,
                ]);
            }
        }

        // Attach tags
        $tagIds = [];
        if ($request->has('tags')) {
            foreach ($request->tags as $tagName) {
                $tag = Tag::firstOrCreate([
                    'name' => trim($tagName),
                ]);
                $tagIds[] = $tag->id;
            }
            $post->tags()->attach($tagIds);
        }

        // Send email
        Mail::to($post->user->email)->send(new PostStatusMail($post, 'created'));

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        $post->increment('views');
        $previous = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $next = Post::where('id', '>', $post->id)->orderBy('id')->first();

        return view('posts.show', compact('post', 'previous', 'next'));
    }

    public function edit($id)
    {
        $post = Post::with('tags')->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required',
            'content'     => 'required',
            'images.*'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'tags'        => 'nullable|array',
            'tags.*'      => 'exists:tags,id',
        ]);

        $post->update([
            'title'       => $request->title,
            'content'     => $request->content,
            'category_id' => $request->category_id,
        ]);

        // Save new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                $image->move(public_path('images/posts'), $imageName);

                $post->images()->create([
                    'image_path' => 'images/posts/' . $imageName,
                ]);
            }
        }

        // Sync tags
        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->sync([]); // Remove all if none selected
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete(); // soft delete
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }

    public function approve(Post $post)
    {
        $post->update(['is_approved' => true]);

        Mail::to($post->user->email)->send(new PostStatusMail($post, 'approved'));

        return redirect()->back()->with('success', 'Post approved successfully.');
    }

    public function like(Post $post)
    {
        $user = auth()->user();
        $existingLike = $post->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $message = 'Post unliked.';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $message = 'Post liked!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function comment(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return redirect()->back()->with('success', 'Comment added!');
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->with('category', 'tags')->paginate(10);
        return view('posts.trashed', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()->route('posts.index')->with('success', 'Post restored successfully!');
    }
}
