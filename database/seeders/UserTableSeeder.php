<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::factory()->count(4)->create();
        DB::table('users')->insertOrIgnore([
            'first_name' => 'Giga',
            'second_name' => 'Gigach',
            'email' => 'user@mail.ru',
            'password' => bcrypt('123456789'),
            'role' => 'moderator'
        ]);
    }
}
