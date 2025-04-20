<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Administrator Vega',
            'email' => 'administrator@gmail.com',
            'password' => 'dominic',
            'role' => 'Administrator',
        ]);
        User::create([
            'id' => 2,
            'name' => 'User Vega',
            'email' => 'user@gmail.com',
            'password' => 'dominic',
            'role' => 'User',
        ]);
    }
}
