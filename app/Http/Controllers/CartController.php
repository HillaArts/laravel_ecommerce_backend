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
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartKey = "cart:" . auth()->id();
        $product = Redis::hGet($cartKey, $request->product_id);

        $quantity = $product ? json_decode($product)->quantity + $request->quantity : $request->quantity;

        Redis::hSet($cartKey, $request->product_id, json_encode([
            'product_id' => $request->product_id,
            'quantity' => $quantity,
        ]));

        return response()->json(['message' => 'Product added to cart'], 200);
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart($productId)
    {
        $cartKey = "cart:" . auth()->id();
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
        $cartKey = "cart:" . auth()->id();
        $cart = Redis::hGetAll($cartKey);

        $items = array_map(fn($item) => json_decode($item, true), $cart);

        return response()->json($items, 200);
    }
}