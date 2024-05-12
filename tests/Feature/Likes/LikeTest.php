<?php

namespace Tests\Feature\Likes;

use App\Models\Like;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    const LOCATION_ID = 3;
    const LOCATION_TWO_ID = 55;
    const USER_ID = 1;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'id' => self::USER_ID,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $this->createLocation(self::LOCATION_ID, self::USER_ID);
        $this->createLike(self::LOCATION_ID, self::USER_ID, 1);

        $this->createLocation(self::LOCATION_TWO_ID, self::USER_ID);
        $this->createLike(self::LOCATION_TWO_ID, self::USER_ID, 0);
    }

    public function test_like_can_be_made_inactive(): void
    {
        $this->freezeTime(function (Carbon $time) {
            $response = $this
                ->actingAs($this->user)
                ->from('/location')
                ->patch('/likes/'.self::LOCATION_ID.'/0');

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect('/location');

            $this->assertDatabaseHas('likes', [
                '_fk_user' => self::USER_ID,
                '_fk_location' => self::LOCATION_ID,
                'like_active' => 0,
                'created_at' => '2024-05-12 07:05:00',
                'updated_at' => $time,
            ]);
        });
    }

    public function test_like_can_be_made_active(): void
    {
        $this->freezeTime(function (Carbon $time) {
            $response = $this
                ->actingAs($this->user)
                ->from('/location')
                ->patch('/likes/'.self::LOCATION_TWO_ID.'/1');

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect('/location');

            $this->assertDatabaseHas('likes', [
                '_fk_user' => self::USER_ID,
                '_fk_location' => self::LOCATION_TWO_ID,
                'like_active' => 1,
                'created_at' => '2024-05-12 07:05:00',
                'updated_at' => $time,
            ]);
        });
    }

    public function createLocation(int $locationId, $userId): void
    {
        Location::factory()->create([
            'id' => $locationId,
            'name' => fake()->streetName(),
            'description' => fake()->text(50),
            'rating' => fake()->numberBetween(1, 5),
            '_fk_user' => $userId,
            'created_at' => '2024-05-12 07:00:00',
            'updated_at' => '2024-05-12 07:00:00',
        ]);
    }

    public function createLike(int $locationId, int $userId, int $likeActive): void
    {
        Like::factory()->create([
            'id' => fake()->randomDigitNotNull(),
            '_fk_user' => $userId,
            '_fk_location' => $locationId,
            'like_active' => $likeActive,
            'created_at' => '2024-05-12 07:05:00',
            'updated_at' => '2024-05-12 07:05:00',
        ]);
    }
}
