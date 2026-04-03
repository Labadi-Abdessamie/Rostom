<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
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
        $locations = [
            ['name' => 'Algiers City Center', 'lat' => 36.7372, 'lng' => 3.0869],
            ['name' => 'Oran Downtown', 'lat' => 35.7404, 'lng' => -0.6455],
            ['name' => 'Constantine Central', 'lat' => 36.3650, 'lng' => 6.6301],
            ['name' => 'Annaba Port Area', 'lat' => 36.9055, 'lng' => 7.7671],
            ['name' => 'Tlemcen Old City', 'lat' => 35.2952, 'lng' => -0.6438],
            ['name' => 'Sétif Market', 'lat' => 36.1909, 'lng' => 5.4083],
            ['name' => 'Béjaïa Coastal', 'lat' => 36.7538, 'lng' => 5.0841],
            ['name' => 'Tiaret Commercial', 'lat' => 35.3697, 'lng' => 1.3147],
            ['name' => 'Médéa Downtown', 'lat' => 36.2668, 'lng' => 2.7589],
            ['name' => 'Souk Ahras Market', 'lat' => 36.2806, 'lng' => 7.6570],
        ];

        $location = fake()->randomElement($locations);

        return [
            'name' => fake()->sentence(2),
            'phoneNumber' => '06' . fake()->randomNumber(8, true),
            'email' => fake()->unique()->email(),
            'bio' => fake()->paragraph(),
            'rate' => fake()->randomFloat(1, 0, 5),
            'rate_count' => fake()->randomNumber(3),
            'location' => $location['name'],
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
            'magasinOpen' => fake()->boolean(80), // 80% open
            'status' => fake()->randomElement(['active', 'firstOpening', 'inactive']),
            'balance' => fake()->randomFloat(2, 0, 10000),
            'facebookLink' => 'https://facebook.com/' . fake()->word(),
            'instagramLink' => 'https://instagram.com/' . fake()->word(),
            'tiktokLink' => 'https://tiktok.com/@' . fake()->word(),
            'whatsupLink' => 'https://wa.me/213' . fake()->randomNumber(8, true),
            'category_id' => fake()->randomElement(Category::whereNull('parentId')->pluck('id')->toArray() ?: [1]),
            'user_id' => fake()->randomElement(User::where('role', 'vendor')->where('status', 'active')->pluck('id')->toArray() ?: [1]),
        ];
    }
}

