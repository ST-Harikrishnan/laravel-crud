<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\PostController;
use App\Models\Post;
//mail
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

//user post create
use App\Http\Controllers\UserPostController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';



// Route::get('/', function () {
//     $posts = Post::where('is_approved', true)->latest()->get();
//     return view('posts.welcome', compact('posts'));
// });
// Route::get('/', function () {
//     $posts = Post::where('is_approved', true)->latest()->get();
//     $categories = Category::all(); // ✅ Fetch categories

//     return view('posts.welcome', compact('posts', 'categories')); // ✅ Pass it to the view
// });

Route::get('/', [PostController::class, 'welcome'])->name('posts.welcome');
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('posts', PostController::class);
    
});
// Route::resource('posts', PostController::class);


Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});
Route::post('/admin/users/{id}/make-admin', [AdminDashboardController::class, 'makeAdmin'])->name('admin.make-admin');


// Route::get('/posts/{post}', [PostController::class, 'show'])->name('user.posts.show');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/users/{user}/send-email', [UserController::class, 'sendWelcomeEmail'])->name('admin.send-welcome-email');
    Route::post('/users/{user}/make-admin', [AdminDashboardController::class, 'makeAdmin'])->name('admin.make-admin');
    Route::get('/users/data', [AdminDashboardController::class, 'getUsersData'])->name('admin.users.data');
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/user/posts/create', [UserPostController::class, 'create'])->name('user.posts.create');
//     // Route::post('/user/posts', [UserPostController::class, 'store'])->name('user.posts.store');
//     // Route::get('/user/posts', [UserPostController::class, 'index'])->name('user.posts.show');

// });



Route::middleware(['auth'])->prefix('user')->name('user.posts.')->group(function () {
    Route::get('/posts/create', [UserPostController::class, 'create'])->name('create');  // Show form
    Route::post('/posts', [UserPostController::class, 'store'])->name('store');          // Handle form POST
});

Route::post('/posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
});