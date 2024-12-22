<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;

/**
 * Feature test suite for Order functionality.
 */
class OrderTest extends TestCase
{
    /**
     * Test placing an order from the cart.
     *
     * @return void
     */
    public function test_place_order_with_items()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['price' => 100]);

        // Add product to cart
        Redis::set("cart:{$user->id}", json_encode([
            ['product_id' => $product->id, 'quantity' => 2, 'price' => $product->price]
        ]));

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/orders');

        $response->assertStatus(201)
            ->assertJson(['message' => 'Order placed successfully.']);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 200
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 100
        ]);
    }

    /**
     * Test viewing orders with their items.
     *
     * @return void
     */
    public function test_view_orders_with_items()
    {
        $user = User::factory()->create();
        $order = Order::factory()->create(['user_id' => $user->id]);

        $product = Product::factory()->create(['price' => 100]);
        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => $product->price
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    ['id', 'total_price', 'items' => [['product_id', 'quantity', 'price']]]
                ]
            ]);
    }
}
