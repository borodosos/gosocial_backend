<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_posts()
    {
        $user = User::all()->random();
        Passport::actingAs($user);

        $response = $this->json('get', 'api/posts')->assertStatus(200);
    }
}
