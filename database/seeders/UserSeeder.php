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
            'name' => 'Jhon Doe',
            'email' => 'Jhon@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Alice Malice',
            'email' => 'alice@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Bob Sponge',
            'email' => 'bob@chat.com',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'name' => 'Charlie Hunnan',
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
