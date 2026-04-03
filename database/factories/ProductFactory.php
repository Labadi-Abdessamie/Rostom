<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Magasin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Product>
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
        $productImages = [
            'pro1.jpg', 'pro2.jpg', 'pro3.jpg', 'pro4.jpg', 'pro5.jpg',
            'electronics1.jpg', 'electronics2.jpg', 'fashion1.jpg', 'fashion2.jpg',
            'home1.jpg', 'home2.jpg', 'beauty1.jpg', 'beauty2.jpg'
        ];

        return [
            'name' => fake()->words(3, true),
            'short_description' => fake()->sentence(10),
            'actual_quantity' => fake()->randomNumber(2),
            'price' => fake()->randomFloat(2, 5, 1000),
            'principalImage' => fake()->randomElement($productImages),
            'category_id' => fake()->randomElement(Category::whereNull('parentId')->pluck('id')->toArray() ?: [1]),
            'magasin_id' => fake()->randomElement(Magasin::where('status', 'active')->pluck('id')->toArray() ?: [1])
        ];
    }
}
