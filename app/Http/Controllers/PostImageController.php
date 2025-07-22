<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class PostImageController extends Controller
{
   public function destroy(Image $image)
    {
        // Delete image file from disk
        if (File::exists(public_path($image->image_path))) {
            File::delete(public_path($image->image_path));
        }

        // Delete image record
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
