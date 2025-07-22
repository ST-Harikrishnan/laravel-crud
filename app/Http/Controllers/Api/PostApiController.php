<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostApiController extends Controller
{
    public function index(Request $request)
    {
       $posts = Post::with(['images', 'category', 'tags'])->get();

        $data = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'category' => $post->category->name ?? null,
                'tags' => $post->tags->pluck('name'),
                'images' => $post->images->map(function ($image) {
                    return asset($image->image_path); 
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'Post data with images',
            'data' => $data,
        ]);
    }
}