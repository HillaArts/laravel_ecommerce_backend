<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

/**
 * Unit test suite for OrderService.
 */
class OrderServiceTest extends TestCase
{
    /**
     * Test calculating the total price from order items.
     *
     * @return void
     */
    public function test_calculate_total_price()
    {
        $order = Order::factory()->create(['total_price' => 0]);
        $product1 = Product::factory()->create(['price' => 50]);
        $product2 = Product::factory()->create(['price' => 30]);

        OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product1->id, 'quantity' => 2, 'price' => 50]);
        OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product2->id, 'quantity' => 1, 'price' => 30]);

        $total = $order->items->sum(fn($item) => $item->quantity * $item->price);
        $this->assertEquals(130, $total, 'Total price mismatch.');
    }
}
