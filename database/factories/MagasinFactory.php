<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=magasin>
 */
class MagasinFactory extends Factory
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
            'phoneNumber' => '06' . fake()->randomNumber(8, true),
            'email' => fake()->email(),
            'rate' => fake()->randomFloat(1, 0, 5),
            'location' => fake()->sentence(3),
            'magasinOpen' => '1',
            'status' => fake()->randomElement(['active', 'firstOpening', 'inactive', 'blocked']),
            'user_id' => fake()->randomElement(User::where('role', 'vendor')->where('status', 'active')->get('id')),
        ];
    }
}
