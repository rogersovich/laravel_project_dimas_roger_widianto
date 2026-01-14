<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// ========================================
// PUBLIC ROUTES (User Landing Page)
// ========================================

// Home - Landing Page
Route::get('/', function () {
    $products = Product::latest()->take(8)->get();
    return view('user.home', compact('products'));
})->name('home');

// Product Detail (User-facing)
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');

// ========================================
// AUTHENTICATED USER ROUTES
// ========================================

Route::middleware('auth')->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Order History Routes
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========================================
// ADMIN ROUTES (Authenticated + Admin Role)
// ========================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    // Product Routes (Admin CRUD)
    Route::get('/admin/product', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/product/tambah', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/product/tambah', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/product/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Category Routes (Admin CRUD)
    Route::get('/admin/category', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/category/tambah', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/category/tambah', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/category/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/category/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/category/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});

require __DIR__.'/auth.php';


