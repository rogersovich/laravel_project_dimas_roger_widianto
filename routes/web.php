<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Product Routes
    Route::get('/product', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/tambah', [ProductController::class, 'create'])->name('products.create');
    Route::post('/product/tambah', [ProductController::class, 'store'])->name('products.store');

    // Category Routes
    Route::get('/category', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/category/tambah', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/category/tambah', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/category/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/category/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';
