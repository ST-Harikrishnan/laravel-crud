<?php
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PostImageController;

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
use App\Http\Controllers\UserCreateController;
use App\Http\Controllers\Auth\RegisterController;
//user post create
use App\Http\Controllers\UserPostController;
//google socialite
use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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




Route::get('/', [PostController::class, 'welcome'])->name('posts.welcome');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('posts', PostController::class);
    
});


Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/userdetails', [AdminDashboardController::class, 'index'])->name('userdetails');
});
Route::post('/admin/users/{id}/make-admin', [AdminDashboardController::class, 'makeAdmin'])->name('admin.make-admin');


// Route::get('/posts/{post}', [PostController::class, 'show'])->name('user.posts.show');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/users/{user}/send-email', [UserController::class, 'sendWelcomeEmail'])->name('admin.send-welcome-email');
    Route::post('/users/{user}/make-admin', [AdminDashboardController::class, 'makeAdmin'])->name('admin.make-admin');
    Route::get('/users/data', [AdminDashboardController::class, 'getUsersData'])->name('admin.users.data');
});
    // Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');


Route::get('/user/create', [UserCreateController::class, 'create'])->name('user.create');
Route::post('/user/create', [UserCreateController::class, 'store'])->name('user.store');

Route::middleware(['auth'])->prefix('user')->name('user.posts.')->group(function () {
    Route::get('/posts', [UserPostController::class, 'index'])->name('index');         // List posts
    Route::get('/posts/create', [UserPostController::class, 'create'])->name('create'); // Show create form
    Route::post('/posts', [UserPostController::class, 'store'])->name('store');         // Handle store
    Route::get('/posts/{post}/edit', [UserPostController::class, 'edit'])->name('edit'); // Show edit form
    Route::put('/posts/{post}', [UserPostController::class, 'update'])->name('update');  // Handle update
    Route::delete('/posts/{post}', [UserPostController::class, 'destroy'])->name('destroy'); // Handle delete
    Route::get('/posts/{post}', [UserPostController::class, 'show'])->name('show');     // Optional: view single post
});




Route::post('/posts/{post}/approve', [PostController::class, 'approve'])->name('posts.approve');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
});
// Route::get('user/posts', [UserPostController::class, 'index'])->name('user.posts.index');

Route::delete('/post-images/{image}', [PostImageController::class, 'destroy'])->name('post-images.destroy');

// registration route
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


use App\Http\Controllers\UserProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', [UserProfileController::class, 'index'])->name('user.profile.index');
    Route::get('/my-profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::post('/my-profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');
    Route::delete('/my-profile/delete', [UserProfileController::class, 'destroy'])->name('user.profile.destroy');
});

Route::post('/posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
Route::post('/posts/{post}/comment', [PostController::class, 'comment'])->name('posts.comment');

Route::get('/user/{user}/edit', [UserCreateController::class, 'edit'])->name('user.edit');
Route::put('/user/{user}', [UserCreateController::class, 'update'])->name('user.update');
Route::delete('/user/{user}', [UserCreateController::class, 'destroy'])->name('user.destroy');


Route::get('/users/create', [UserCreateController::class, 'create'])->name('user.create');
Route::post('/users', [UserCreateController::class, 'store'])->name('user.store');
Route::get('/users', [UserCreateController::class, 'index'])->name('user.index');
Route::get('/users/{user}/edit', [UserCreateController::class, 'edit'])->name('user.edit');
Route::put('/users/{user}', [UserCreateController::class, 'update'])->name('user.update');
Route::delete('/users/{user}', [UserCreateController::class, 'destroy'])->name('user.destroy');


Route::get('/posts/trashed', [PostController::class, 'trashed'])->name('posts.trashed');
Route::post('/posts/restore/{id}', [PostController::class, 'restore'])->name('posts.restore');

//google socialite
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Route::get('auth/google', function () {
//     return Socialite::driver('google')->redirect();
// })->name('google.login');

// Route::get('auth/google/callback', function () {
//     $googleUser = Socialite::driver('google')->user();

//     // You can now register/login the user
//     });

Route::get('auth/github', function () {
    return Socialite::driver('github')->redirect();
})->name('github.login');

Route::get('auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->stateless()->user();

    // Find or create user
    $user = User::updateOrCreate(
        ['email' => $githubUser->getEmail()],
        [
            'name' => $githubUser->getName() ?? $githubUser->getNickname(),
            'provider_id' => $githubUser->getId(),
            'avatar' => $githubUser->getAvatar(),
        ]
    );

    Auth::login($user);
    return redirect('/dashboard'); // Or wherever
});