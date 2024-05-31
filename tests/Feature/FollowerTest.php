<?php

namespace Tests\Feature;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowerTest extends TestCase
{
    use RefreshDatabase;

    const USER_ID = 1;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'id' => self::USER_ID,
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    public function test_following_a_user(): void
    {
        $user2 = User::factory()->create();
        $response = $this
            ->from('/profile/'.$user2->id)
            ->actingAs($this->user)
            ->post('/follow/'.$user2->id);

        $response
            ->assertStatus(302)
            ->assertRedirect('/profile/'.$user2->id);

        $this->assertDatabaseHas('followers',
            [
                '_fk_user' => $this->user->id,
                '_fk_user_followed' => $user2->id,
            ]);
    }

    public function test_unfollowing_a_user(): void
    {
        $user2 = User::factory()->create();
        Follower::factory()->create([
            '_fk_user' => $this->user->id,
            '_fk_user_followed' => $user2->id,
        ]);

        $response = $this
            ->from('/profile/'.$user2->id)
            ->actingAs($this->user)
            ->delete('/follow/'.$user2->id);

        $response
            ->assertStatus(302)
            ->assertRedirect('/profile/'.$user2->id);

        $this->assertDatabaseMissing('followers',
            [
                '_fk_user' => $this->user->id,
                '_fk_user_followed' => $user2->id,
            ]);
    }
}
