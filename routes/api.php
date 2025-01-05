<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

// Test routes without authentication
Route::prefix('cart')->group(function () {
    Route::post('/', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/', [CartController::class, 'viewCart'])->name('cart.view');
});

Route::prefix('orders')->group(function () {
    Route::post('/', [OrderController::class, 'placeOrder'])->name('orders.place');
    Route::get('/', [OrderController::class, 'viewOrders'])->name('orders.view');
});

Route::prefix('products')->group(function () {
    // Retrieve all products with pagination
    Route::get('/', [ProductController::class, 'getAllProducts'])->name('products.list');
    
    // Retrieve a single product by ID
    Route::get('{id}', [ProductController::class, 'getProductById'])->name('products.view');
    
    // Admin: Create a new product
    // Route::post('/', [ProductController::class, 'createProduct'])->middleware('auth', 'admin')->name('products.create');
    
    // // Admin: Update a product
    // Route::put('{id}', [ProductController::class, 'updateProduct'])->middleware('auth', 'admin')->name('products.update');
    
    // // Admin: Delete a product
    // Route::delete('{id}', [ProductController::class, 'deleteProduct'])->middleware('auth', 'admin')->name('products.delete');
});

