<?php

namespace Database\Factories;

use App\Models\Bag;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=bagItem>
 */
class bagItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quantity' => fake()->numberBetween(1, 20),
            'bag_id' => fake()->randomElement(Bag::all()),
            'product_id' => fake()->randomElement(Product::whereHas('magasin', function ($query) {
                $query->where('status', 'active');
            })->limit(6)->get())
        ];
    }
}
