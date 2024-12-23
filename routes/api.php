<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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
