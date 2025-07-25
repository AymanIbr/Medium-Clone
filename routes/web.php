<?php

use App\Http\Controllers\ClapController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/@{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/post', [PostController::class, 'index'])
        ->name('dashboard');

    Route::get('post/create', [PostController::class, 'create'])
        ->name('post.create');
    Route::post('post', [PostController::class, 'store'])
        ->name('post.store');

    Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('post.show');

    Route::post('/follow/{user}', [FollowController::class, 'toggle'])->name('follow.toggle');
    Route::post('/posts/{post}/clap', [ClapController::class, 'toggle'])->middleware('auth');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// https://flowbite.com/docs/getting-started/introduction/
