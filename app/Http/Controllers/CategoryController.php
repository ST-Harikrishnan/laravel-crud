<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::with('images')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|unique:categories,name',
            'images.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = Category::create([
            'name' => $request->name,
        ]);

        // Save multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('images/categories'), $filename);

                $category->images()->create([
                    'image_path' => 'images/categories/' . $filename,
                ]);
            }
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $category->load('images');
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'       => 'required|unique:categories,name,' . $category->id,
            'images.*'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->extension();
                $file->move(public_path('images/categories'), $filename);

                $category->images()->create([
                    'image_path' => 'images/categories/' . $filename,
                    
                ]);
            }
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {   
        // Delete associated images from disk and DB
        foreach ($category->images as $image) {
            $filePath = public_path($image->image_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $image->delete();
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted.');
    }
}
