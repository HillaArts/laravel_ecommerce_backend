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
     * @param int $userId
     * @param int $productId
     * @param int $quantity
     * @param float $price
     * @return void
     */
    public function addToCart(int $userId, int $productId, int $quantity, float $price): void
    {
        $cartKey = "cart:{$userId}";

        // Get the existing cart from Redis
        $cart = json_decode(Redis::get($cartKey), true) ?? [];

        // Check if the product already exists in the cart
        $productIndex = collect($cart)->search(fn($item) => $item['product_id'] === $productId);

        if ($productIndex !== false) {
            // Update the quantity if the product exists
            $cart[$productIndex]['quantity'] += $quantity;
        } else {
            // Add a new product entry
            $cart[] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $price,
            ];
        }

        // Save the updated cart back to Redis
        Redis::set($cartKey, json_encode($cart));
    }

    /**
     * Remove a product from the cart.
     *
     * @param int $userId
     * @param int $productId
     * @return void
     */
    public function removeFromCart(int $userId, int $productId): void
    {
        $cartKey = "cart:{$userId}";

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
     * @param int $userId
     * @return array
     */
    public function getCart(int $userId): array
    {
        $cartKey = "cart:{$userId}";

        // Get the cart from Redis
        return json_decode(Redis::get($cartKey), true) ?? [];
    }
}
