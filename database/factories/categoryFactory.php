<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel:Category>
 */
class categoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => 'active',
            'name' => fake()->word(),
            'parentId' => NULL,
            //'parentId' => fake()->randomElement(Category::all())
        ];
    }
    public function child()
    {
        return $this->state(function (array $attributes) {
    $parentCategory = Category::whereNull('parentId')
        ->inRandomOrder()
        ->first();

    return [
        'parentId' => $parentCategory ? $parentCategory->id : null,
    ];
});
    }
}
