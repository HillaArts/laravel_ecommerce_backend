<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Set up the testing environment.
     *
     * This method is called before every test.
     * It ensures the database and services are properly configured for tests.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Clear configuration and cache without facades
        $this->artisan('config:clear');
        $this->artisan('cache:clear');

        // Clear the database to ensure a fresh state for each test
        $this->artisan('migrate:fresh');

        // Seed the database if needed
        $this->artisan('db:seed');

        // Clear Redis if needed
        if (app()->environment('testing')) {
            $redis = app('redis');
            $redis->flushall();
        }
    }

    /**
     * Tear down the testing environment.
     *
     * This method is called after every test.
     * Use it to clean up resources or reset states.
     */
    protected function tearDown(): void
    {
        // Additional teardown logic (if needed)
        parent::tearDown();
    }

    /**
     * Helper method to create a user with the specified attributes.
     *
     * @param array $attributes
     * @return \App\Models\User
     */
    protected function createUser(array $attributes = [])
    {
        return \App\Models\User::factory()->create($attributes);
    }

    /**
     * Helper method to authenticate a user for tests.
     *
     * @param \App\Models\User|null $user
     * @return \App\Models\User
     */
    protected function actingAsUser($user = null)
    {
        $user = $user ?? $this->createUser();
        $this->actingAs($user);

        return $user;
    }

    /**
     * Helper method to add products to the cart for a user.
     *
     * @param int $userId
     * @param array $products
     * @return void
     */
    protected function addProductsToCart(int $userId, array $products)
    {
        $cartService = app(\App\Services\CartService::class);

        foreach ($products as $product) {
            $cartService->addToCart($userId, $product['id'], $product['quantity'], $product['price']);
        }
    }
}
