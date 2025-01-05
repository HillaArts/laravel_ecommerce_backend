<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CartService;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;


/**
 * Unit test suite for CartService.
 */
class CartServiceTest extends TestCase
{
    /**
     * Test adding a product to the cart.
     *
     * @return void
     */
    public function test_add_to_cart()
    {
        $cartService = new CartService();
        $product = Product::factory()->create(['price' => 50]);

        $cartService->addToCart(1, $product->id, 3, $product->price);

        $cart = json_decode(Redis::get("cart:1"), true);
        $this->assertNotEmpty($cart, 'Cart should contain products.');
        $this->assertEquals(3, $cart[0]['quantity'], 'Product quantity mismatch in cart.');
    }

    /**
     * Test removing a product from the cart.
     *
     * @return void
     */
    public function test_remove_from_cart()
    {
        $cartService = new CartService();
        $product = Product::factory()->create(['price' => 50]);

        // Add product to cart
        $cartService->addToCart(1, $product->id, 3, $product->price);

        // Remove product from cart
        $cartService->removeFromCart(1, $product->id);

        $cart = json_decode(Redis::get("cart:1"), true);
        $this->assertEmpty($cart, 'Cart should be empty after product removal.');
    }

    /**
     * Test retrieving an empty cart.
     *
     * @return void
     */
    public function test_get_empty_cart()
    {
        $cartService = new CartService();
        $cart = $cartService->getCart(1);

        $this->assertEmpty($cart, 'Cart should be empty for a new user.');
    }
}
