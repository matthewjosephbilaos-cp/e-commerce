<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand_ids = Brand::pluck('id')->toArray();
        $category_ids = Category::pluck('id')->toArray();
        return [
            'category_id' => fake()->randomElement($category_ids),
            'brand_id' => fake()->randomElement($brand_ids),
            'title' => fake()->unique()->realText(20),
            'quantity' => fake()->randomNumber(4),
            'description' => fake()->realText(),
            'published' => fake()->boolean(),
            'inStock' => fake()->boolean(),
            'price' => fake()->randomFloat(2, 0, 6),
        ];
    }
}
