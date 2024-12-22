<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Run the migrations to create the products table.
 *
 * This migration will create a table for storing product information with the following columns:
 * - id: The auto-incrementing primary key for each product.
 * - name: The name of the product (string type).
 * - price: The price of the product (decimal type with 8 digits and 2 decimal places).
 * - timestamps: Automatically generated created_at and updated_at columns.
 *
 * @return void
 */
class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            // Create an auto-incrementing primary key
            $table->id();

            // Create a column for the product's name (string)
            $table->string('name'); // You may also specify length: $table->string('name', 255);

            // Create a column for the product's price (decimal with precision of 8 and scale of 2)
            $table->decimal('price', 8, 2); // The first argument is the total number of digits, and the second is the decimal places

            // Automatically add 'created_at' and 'updated_at' timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations by dropping the products table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
