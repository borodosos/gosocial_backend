<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::all()->random();

        $data = [
            'email' => $user->email,
            'password' => '123456789',
        ];

        $response = $this->json('post', 'api/login', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
        $response->assertCookie('refreshToken');
    }

    public function test_user_can_register_with_correct_credentials()
    {
        $data = [
            'firstName' => fake()->firstName(),
            'secondName' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '123456789',
        ];

        $response = $this->json('post', 'api/registration', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token_type',
            'expires_in',
            'access_token',
            'refresh_token',
        ]);
        $response->assertCookie('refreshToken');
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::all()->random();

        $data = [
            'email' => $user->email,
            'password' => 'invalid-password',
        ];


        $response = $this->json('post', 'api/login', $data);
        $response->assertStatus(400);
        $response->assertJsonStructure(['error']);
    }


    public function test_user_can_login_with_google()
    {
        $response = $this->json('get', 'api/google/login');

        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->original, "https://accounts.google.com"));
    }
}
