<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * OrderFactory Class
 *
 * The OrderFactory class is responsible for generating fake data for the 
 * `Order` model. It uses the Faker library to generate random data that 
 * mimics real order details for seeding purposes. This class helps create 
 * multiple order records with randomized attributes, such as the user ID, 
 * total amount, and status, for testing or development.
 */
class OrderFactory extends Factory
{
    /**
     * The name of the model the factory is for.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * This method defines the default attributes that will be used when 
     * generating a new instance of the `Order` model. The faker library 
     * is used to generate random but realistic data for attributes like 
     * `user_id`, `total_amount`, and `status`. The `user_id` is generated 
     * by calling the `UserFactory`, simulating an order placed by a user.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),                           // Generate a user ID using the UserFactory
            'total_amount' => $this->faker->randomFloat(2, 10, 500), // Random total amount between 10 and 500
            'status' => 'pending',                                   // Default order status is 'pending'
        ];
    }
}
