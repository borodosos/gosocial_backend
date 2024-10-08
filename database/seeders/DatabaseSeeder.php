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
        // \App\Models\User::factory(2)->create();

        // \App\Models\Tag::factory()->create([
        //     'tag_text' => '11',
        // ]);

        $this->call(UserTableSeeder::class);
        $this->call(PostTableSeeder::class);
    }
}
