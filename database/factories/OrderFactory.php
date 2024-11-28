<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $customer_ids = User::pluck('id')->toArray();
        $product_ids = Product::pluck('id')->toArray();

        return [
            'customer_id' => fake()->randomElement($customer_ids),
            'product_id' => fake()->randomElement($product_ids),
            'quantity' => fake()->randomNumber(4),
            'status' => fake()->randomElement(['Pending', 'Processing', 'Out For Delivery', 'Delivered', 'Failed Delivery', 'Cancelled']),
        ];
    }
}
