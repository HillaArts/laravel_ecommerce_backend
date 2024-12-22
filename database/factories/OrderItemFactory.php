<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * OrderItemFactory Class
 *
 * The OrderItemFactory class is responsible for generating fake data for the
 * `OrderItem` model. It uses the Faker library to generate random data that 
 * mimics real order item details for seeding purposes. This class helps create 
 * multiple order item records with randomized attributes, such as `order_id`, 
 * `product_id`, `quantity`, and `price`, for testing or development.
 */
class OrderItemFactory extends Factory
{
    /**
     * The name of the model the factory is for.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * This method defines the default attributes that will be used when 
     * generating a new instance of the `OrderItem` model. It uses the faker 
     * library to generate random values for attributes like `order_id`, 
     * `product_id`, `quantity`, and `price`. The `product_id` is generated 
     * by calling the `ProductFactory`, simulating the addition of a product 
     * to the order. The `order_id` will be set to `null`, which will be 
     * populated by the related order.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'order_id' => null,                                      // Will be set once the order is created
            'product_id' => Product::factory(),                       // Generate a product ID using the ProductFactory
            'quantity' => $this->faker->numberBetween(1, 5),          // Random quantity between 1 and 5
            'price' => $this->faker->randomFloat(2, 5, 50),           // Random price between 5 and 50
        ];
    }
}
