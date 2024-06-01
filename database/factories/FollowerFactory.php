<?php

namespace Database\Factories;

use App\Models\Follower;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Follower>
 */
class FollowerFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            '_fk_user' => fake()->numberBetween(1, 10),
            '_fk_user_followed' => fake()->numberBetween(1, 10),
        ];
    }
}
