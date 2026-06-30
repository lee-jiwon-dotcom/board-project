<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentLikeController;


Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('posts', PostController::class);


        // 👇 추가! 댓글 라우트
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
         ->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
         ->name('comments.destroy');

    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])
    ->name('posts.like');    

    Route::post('/comments/{comment}/like', [CommentLikeController::class, 'toggle'])
     ->name('comments.like');
});

require __DIR__.'/auth.php';
