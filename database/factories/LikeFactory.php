<?php

namespace Database\Factories;

use App\Models\Like;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Like>
 */
class LikeFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            '_fk_user' => fake()->numberBetween(1, 10),
            '_fk_location' => fake()->numberBetween(1, 10),
        ];
    }
}
