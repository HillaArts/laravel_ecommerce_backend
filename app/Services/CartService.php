<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

/**
 * Service class for managing cart operations.
 */
class CartService
{
    /**
     * Add a product to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @param float $price
     * @return void
     */
    public function addToCart(int $productId, int $quantity, float $price): void
    {
        // Use a session or unique identifier for the cart key
        $cartKey = "cart:" . session()->getId(); // Use session ID as a unique cart identifier

        // Get the existing cart from Redis
        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        // Simply add the new product to the cart without validation
        $cart[] = [
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $price,
        ];

        // Save the updated cart back to Redis
        Redis::set($cartKey, json_encode($cart));
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $productId
     * @return void
     */
    public function removeFromCart(int $productId): void
    {
        // Use a session or unique identifier for the cart key
        $cartKey = "cart:" . session()->getId(); // Use session ID as a unique cart identifier

        // Get the existing cart from Redis
        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        // Filter out the product to remove
        $updatedCart = array_filter($cart, fn($item) => $item['product_id'] !== $productId);

        // Save the updated cart back to Redis
        Redis::set($cartKey, json_encode(array_values($updatedCart)));
    }

    /**
     * Retrieve the cart for a user.
     *
     * @return array
     */
    public function getCart(): array
    {
        // Use a session or unique identifier for the cart key
        $cartKey = "cart:" . session()->getId(); // Use session ID as a unique cart identifier

        // Get the cart from Redis
        return json_decode(Redis::get($cartKey), true) ?? [];
    }
}
