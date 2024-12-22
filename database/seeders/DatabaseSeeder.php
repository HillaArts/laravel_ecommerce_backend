<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder Class
 *
 * The DatabaseSeeder class is responsible for seeding the entire database
 * with initial data. It uses other seeders, such as `ProductSeeder` and 
 * `OrderSeeder`, to populate specific tables with test or development data.
 * This central seeder class ensures that all necessary data can be generated
 * with a single command.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * This method calls other seeders to populate the database with initial data.
     * It includes seeding the products table using the `ProductSeeder` and 
     * the orders table using the `OrderSeeder`. These seeders create 
     * sample data for development or testing purposes.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class, // Calls the ProductSeeder to seed the products table
            OrderSeeder::class,   // Calls the OrderSeeder to seed the orders table
        ]);
    }
}
