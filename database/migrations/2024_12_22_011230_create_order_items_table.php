<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the order_items table.
 *
 * This table links orders to products, capturing details like:
 * - order_id: The order associated with the items.
 * - product_id: The product being ordered.
 * - quantity: The quantity of the product ordered.
 * - price: The price per unit of the product at the time of the order.
 * - timestamps: Automatically generated 'created_at' and 'updated_at' columns.
 */
class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations to create the order_items table.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            // Auto-incrementing primary key
            $table->id();

            // Foreign key referencing the 'orders' table with cascading delete
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Foreign key referencing the 'products' table
            $table->foreignId('product_id')->constrained();

            // Quantity of the product ordered
            $table->integer('quantity');

            // Price per unit of the product at the time of order
            $table->decimal('price', 10, 2);

            // Timestamps for 'created_at' and 'updated_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the order_items table.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
}