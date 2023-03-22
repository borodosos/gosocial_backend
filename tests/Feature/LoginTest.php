<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_can_login()
    {
        $user = User::all()->random();

        $data = [
            'email' => $user->email,
            'password' => '123456789',
        ];

        $this->json('post', 'api/login', $data)->assertStatus(200)->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
    }

    public function test_a_user_can_register()
    {
        $data = [
            'firstName' => fake()->firstName(),
            'secondName' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '123456789',
        ];

        $this->json('post', 'api/registration', $data)->assertStatus(200)->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
    }
}
