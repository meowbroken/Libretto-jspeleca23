<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
 return redirect(route('home')); 
});
Auth::routes();


Route::middleware('auth')->group(function () {
    Route::resource('books', BookController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('authors', AuthorController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('genres', GenreController::class);
});

Route::middleware('auth')->group(function () {
    Route::resource('reviews', ReviewController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
