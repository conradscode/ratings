<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->realText(25),
            'description' => fake()->realText(144),
            'rating' => fake()->numberBetween(0, 5),
            '_fk_user' => fake()->numberBetween(1, 10),
        ];
    }
}
