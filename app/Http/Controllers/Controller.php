<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
abstract class Controller
{
     public function index()
    {
        $categories = Category::all();

        $query = Post::where('is_approved', true);

        // If category filter is applied
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $posts = $query->latest()->get();

        return view('posts.welcome', compact('posts', 'categories'));
    }
}
