<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CartController extends Controller
{
    /**
     * Add an item to the cart.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'product_id' => 'required|integer|exists:products,id',
        'quantity' => 'required|integer|min:1',
    ]);

    try {
        // Use session ID or user ID as cart key
        $cartKey = "cart:" . (auth()->id() ?? session()->getId());

        // Check if the product exists in the cart
        $product = Redis::hGet($cartKey, $request->product_id);
        $quantity = $product ? json_decode($product, true)['quantity'] + $request->quantity : $request->quantity;

        // Update or remove the product based on quantity
        if ($quantity <= 0) {
            Redis::hDel($cartKey, $request->product_id);
            return response()->json(['message' => 'Product removed from cart'], 200);
        }

        // Update the product in the cart
        Redis::hSet($cartKey, $request->product_id, json_encode([
            'product_id' => $request->product_id,
            'quantity' => $quantity,
        ]));

        return response()->json(['message' => 'Product added to cart'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Error adding to cart: ' . $e->getMessage()], 500);
    }
}
    /**
     * Remove an item from the cart.
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart($productId)
    {
        // Get the current user's cart key in Redis
        $cartKey = "cart:" . auth()->id();

        // Remove the product from the cart
        Redis::hDel($cartKey, $productId);

        return response()->json(['message' => 'Product removed from cart'], 200);
    }

    /**
     * View the cart contents.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function viewCart()
    {
        // Get the current user's cart key in Redis
        $cartKey = "cart:" . auth()->id();

        // Fetch all cart items from Redis
        $cart = Redis::hGetAll($cartKey);

        // Map the cart items to an array of decoded JSON
        $items = array_map(fn($item) => json_decode($item, true), $cart);

        // Return the cart items as a JSON response
        return response()->json($items, 200);
    }
}
