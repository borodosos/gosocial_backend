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
    public function test_user_can_get_some_posts()
    {
        $user = User::all()->random();
        Passport::actingAs($user);

        $response = $this->json('get', 'api/posts');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'from',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
    }

    public function test_user_can_switch_between_pages()
    {
        $user = User::all()->random();
        Passport::actingAs($user);

        $response = $this->json('get', 'api/posts?page=2');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data',
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links',
            'next_page_url',
            'from',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
    }

    public function test_user_can_create_post()
    {
        $user = User::all()->random();
        Passport::actingAs($user);

        $params = [
            'keywords' => 'think',
            'selectedFilter' => 'All'
        ];

        $response = $this->json('get', 'api/posts', $params);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'filter',
            'keywords',
            'posts' => [
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'from',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
    }

    public function test_user_can_search_posts()
    {
        $user = User::all()->random();
        Passport::actingAs($user);

        $params = [
            'keywords' => 'think',
            'selectedFilter' => 'All'
        ];

        $response = $this->json('get', 'api/posts', $params);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'filter',
            'keywords',
            'posts' => [
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'from',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);
    }
}
