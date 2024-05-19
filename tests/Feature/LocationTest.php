<?php

namespace Tests\Feature;

use App\Models\Like;
use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationTest extends TestCase
{
    use RefreshDatabase;

    const LOCATION_ID = 3;
    const LOCATION_TWO_ID = 55;
    const LOCATION_THREE_ID = 3030;
    const USER_ID = 1;
    const TEST_STORE_LOCATION_DETAILS = [
        'name' => 'Test Location Name',
        'description' => 'Test Location Description',
        'rating' => 2,
    ];

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

        $this->createLocation(self::LOCATION_THREE_ID, self::USER_ID);
    }

    public function test_index_returns_locations(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/location');

        $response->assertStatus(200);
    }

    public function test_create_view_loads(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/location/create');

        $response->assertStatus(200);
    }

    public function test_store_creates_new_location_in_database(): void
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/location', self::TEST_STORE_LOCATION_DETAILS);

        $response->assertStatus(302);

        $this->assertDatabaseHas('locations', self::TEST_STORE_LOCATION_DETAILS);
    }

    public function test_shows_correct_location(): void
    {
        $location = $this->createLocation(3993, self::USER_ID);
        $response = $this
            ->actingAs($this->user)
            ->get('/location/' . $location->id);

        $response->assertStatus(200);
        $response->assertSee($location->name);
        $response->assertSee($location->description);
        $response->assertSee($location->rating);
    }

    public function test_edit_does_not_load_if_user_not_authenticated(): void
    {
        $response = $this
            ->get('/location' . self::LOCATION_ID . '/edit');
        $response->assertStatus(403);
    }

    public function test_edit_shows_correct_location(): void
    {
        $location = $this->createLocation(3993, self::USER_ID);

        $response = $this
            ->actingAs($this->user)
            ->put('/location' . $location->id);
        $response->assertStatus(200);
        $response->assertSee($location->name);
        $response->assertSee($location->description);
        $response->assertSee($location->rating);
    }


    public function createLocation(int $locationId, $userId): Location
    {
        return Location::factory()->create([
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
            '_fk_user' => $userId,
            '_fk_location' => $locationId,
            'like_active' => $likeActive,
            'created_at' => '2024-05-12 07:05:00',
            'updated_at' => '2024-05-12 07:05:00',
        ]);
    }
}
