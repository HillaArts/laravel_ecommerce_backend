<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;

/**
 * Feature test suite for Cart functionality.
 */
class CartTest extends TestCase
{
    /**
     * Test adding a product to the cart.
     *
     * @return void
     */
    public function test_add_product_to_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/cart', [
                'product_id' => $product->id,
                'quantity' => 2
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product added to cart.']);

        $cart = json_decode(Redis::get("cart:{$user->id}"), true);
        $this->assertNotNull($cart, 'Cart should not be empty.');
        $this->assertEquals(2, $cart[0]['quantity'], 'Product quantity mismatch in cart.');
    }

    /**
     * Test removing a product from the cart.
     *
     * @return void
     */
    public function test_remove_product_from_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100]);

        // Add product to cart
        Redis::set("cart:{$user->id}", json_encode([
            ['product_id' => $product->id, 'quantity' => 1, 'price' => $product->price]
        ]));

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson("/api/cart/{$product->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Product removed from cart.']);

        $cart = json_decode(Redis::get("cart:{$user->id}"), true);
        $this->assertEmpty($cart, 'Cart should be empty after removal.');
    }

    /**
     * Test viewing the cart.
     *
     * @return void
     */
    public function test_view_cart()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 50]);

        Redis::set("cart:{$user->id}", json_encode([
            ['product_id' => $product->id, 'quantity' => 2, 'price' => $product->price]
        ]));

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/cart');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [['product_id', 'quantity', 'price']]
            ]);
    }
}
