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
        return [
            'name' => fake()->sentence(1),
            'short_description' => fake()->text(),
            'actual_quantity' => fake()->randomNumber(3),
            'price' => fake()->randomFloat(2, 10, 500), // Price between 10 and 500
            'principalImage' => "pro3.jpg",
            'category_id' => fake()->randomElement(Category::all('id')),
            'magasin_id' => fake()->randomElement(Magasin::where('status', 'active')->get('id'))
        ];
    }
}
