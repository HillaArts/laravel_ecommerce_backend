<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/**
 * Group routes that require authentication middleware.
 *
 * This ensures that all the routes within this group require the user to be authenticated
 * via Sanctum before accessing the associated controller methods.
 */
Route::middleware('auth:sanctum')->group(function () {

    /**
     * Cart Routes
     *
     * These routes handle operations related to the user's cart,
     * such as adding, removing, and viewing items in the cart.
     */
    Route::prefix('cart')->group(function () {

        /**
         * Add a product to the cart.
         *
         * This route allows an authenticated user to add a product to their shopping cart.
         *
         * @param  int  $productId  The ID of the product to be added.
         * @return \Illuminate\Http\Response
         */
        Route::post('/', [CartController::class, 'addToCart'])->name('cart.add');

        /**
         * Remove a product from the cart.
         *
         * This route allows an authenticated user to remove a product from their shopping cart.
         *
         * @param  int  $productId  The ID of the product to be removed.
         * @return \Illuminate\Http\Response
         */
        Route::delete('/{productId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

        /**
         * View the current cart.
         *
         * This route allows an authenticated user to view all the products currently in their cart.
         *
         * @return \Illuminate\Http\Response
         */
        Route::get('/', [CartController::class, 'viewCart'])->name('cart.view');
    });

    /**
     * Order Routes
     *
     * These routes manage the user's order-related operations, such as placing and viewing orders.
     */
    Route::prefix('orders')->group(function () {

        /**
         * Place an order.
         *
         * This route allows an authenticated user to place an order based on the items in their cart.
         *
         * @return \Illuminate\Http\Response
         */
        Route::post('/', [OrderController::class, 'placeOrder'])->name('orders.place');

        /**
         * View user's orders.
         *
         * This route allows an authenticated user to view all of their past orders.
         *
         * @return \Illuminate\Http\Response
         */
        Route::get('/', [OrderController::class, 'viewOrders'])->name('orders.view');
    });

});