<?php

namespace Tests\Feature;

use App\Http\Controllers\LikeController;
use App\Models\Like;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
{
    use RefreshDatabase;
    const LOCATION_ID = 3;
    const LOCATION_TWO_ID = 55;
    const USER_ID = 1;

    private User $user;
    private LikeController $likeController;

    public function setUp(): void
    {
        parent::setUp();
        $this->likeController = new LikeController();
        $this->user = User::factory()->create([
            'id' => self::USER_ID,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        $this->createLocation(self::LOCATION_ID, self::USER_ID);
        $this->createLike(self::LOCATION_ID, self::USER_ID);

        $this->createLocation(self::LOCATION_TWO_ID, self::USER_ID);
    }

    public function test_like_exists_returns_true_if_like_found(): void
    {
        $this->actingAs($this->user);
        $this->assertTrue($this->likeController->likeExists(self::LOCATION_ID));
    }

    public function test_like_exists_returns_false_if_no_like_found(): void
    {
        $this->actingAs($this->user);
        $this->assertFalse($this->likeController->likeExists(self::LOCATION_TWO_ID));
    }

    public function test_likes_count_returns_correct_count(): void
    {
        $this->assertEquals(1, $this->likeController->getLikesCount(self::LOCATION_ID));
    }

    public function test_like_can_be_created(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->from('/location')
            ->post('/likes/'.self::LOCATION_TWO_ID);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/location');

        $this->assertDatabaseHas('likes', [
            '_fk_user' => self::USER_ID,
            '_fk_location' => self::LOCATION_TWO_ID,
        ]);
    }

    public function test_like_is_not_created_if_it_already_exists(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->from('/location')
            ->post('/likes/'.self::LOCATION_ID);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/location');

        $this->assertDatabaseCount('likes', 1);
    }

    public function test_user_is_redirected_if_like_does_not_exist(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->from('/location')
            ->delete('/likes/'.self::LOCATION_TWO_ID);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/location');
    }

    public function test_like_can_be_deleted(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->from('/location')
            ->delete('/likes/'.self::LOCATION_ID);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/location');

        $this->assertDatabaseMissing('likes',[
            '_fk_user' => self::USER_ID,
            '_fk_location' => self::LOCATION_ID
        ]);
    }

    public function test_show_displays_likes(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->from('/location')
            ->get('/likes/'.self::LOCATION_ID);

        $response
            ->assertSessionHasNoErrors()
            ->assertSee($this->user->name)
            ->assertSee($this->user->id);
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

    public function createLike(int $locationId, int $userId): void
    {
        Like::factory()->create([
            '_fk_user' => $userId,
            '_fk_location' => $locationId,
            'created_at' => '2024-05-12 07:05:00',
            'updated_at' => '2024-05-12 07:05:00',
        ]);
    }
}
