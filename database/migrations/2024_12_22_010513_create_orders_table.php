<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration for creating the orders table.
 *
 * This table will store information about orders placed by users, including:
 * - user_id: The foreign key linking the order to a user.
 * - total_amount: The total cost of the order.
 * - status: The status of the order (default: 'pending').
 * - timestamps: Automatically generated 'created_at' and 'updated_at' columns.
 */
class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations to create the orders table.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            // Auto-incrementing primary key
            $table->id();

            // Foreign key referencing the 'users' table with cascading delete
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Total amount for the order
            $table->decimal('total_amount', 10, 2);

            // Status of the order with a default value of 'pending'
            $table->string('status')->default('pending');

            // Timestamps for 'created_at' and 'updated_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the orders table.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
