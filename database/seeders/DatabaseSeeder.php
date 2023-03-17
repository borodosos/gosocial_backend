<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'first_name' => 'Test',
        //     'email' => 'test@example.com',
        // ]);

        $tags = ['IT', 'Humor', 'Film', 'Sport'];
        foreach ($tags as $tag) {
            \App\Models\Tag::factory()->create([
                'tag_text' => $tag,
            ]);
        }
    }
}