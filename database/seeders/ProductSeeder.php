<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

/**
 * ProductSeeder Class
 *
 * Seeds the products table with sample product data.
 * This class leverages the Product factory to generate sample products 
 * for testing or development purposes.
 */
class ProductSeeder extends Seeder
{
    /**
     * Run the product seeder.
     *
     * This method generates 10 sample products using the Product factory.
     * The `count(10)` method specifies that 10 products should be created 
     * and the `create()` method inserts them into the database.
     *
     * @return void
     */
    public function run(): void
    {
        Product::factory()->count(10)->create(); // Creates 10 sample products
    }
}