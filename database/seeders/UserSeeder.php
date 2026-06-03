<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Rene',
            'email' => 'rene@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Alice',
            'email' => 'alice@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Bob',
            'email' => 'bob@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Charlie',
            'email' => 'charlie@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'System',
            'email' => 'system@chat.com',
            'password' => Hash::make('password'),
        ]);


    }
}
