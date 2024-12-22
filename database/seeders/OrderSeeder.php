<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

/**
 * OrderSeeder Class
 *
 * Seeds the orders table with sample order data, including associated order items.
 * This class utilizes the Order factory to create sample orders, with each order
 * containing a specified number of associated items for testing or development purposes.
 */
class OrderSeeder extends Seeder
{
    /**
     * Run the order seeder.
     *
     * This method generates 5 sample orders using the Order factory. 
     * Each order is created with 3 associated order items using the `hasItems(3)` method.
     * The `count(5)` method specifies the number of orders to create, and the 
     * `create()` method inserts them into the database.
     *
     * @return void
     */
    public function run(): void
    {
        Order::factory()
            ->count(5) // Creates 5 sample orders
            ->hasItems(3) // Each order has 3 associated items
            ->create();
    }
}
