<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * ProductFactory Class
 *
 * The ProductFactory class is responsible for generating fake data for the 
 * `Product` model. It uses the Faker library to generate random data that 
 * mimics real product data for seeding purposes. This class helps create 
 * multiple product records with randomized attributes for testing or development.
 */
class ProductFactory extends Factory
{
    /**
     * The name of the model the factory is for.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * This method defines the default attributes that will be used when 
     * generating a new instance of the `Product` model. The faker library 
     * is used to generate random but realistic data for attributes like 
     * `name`, `description`, and `price`.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),                          
            // 'description' => $this->faker->sentence(),                
            'price' => $this->faker->randomFloat(2, 1, 100),          
        ];
    }
}
