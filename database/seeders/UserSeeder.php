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
            'name' => 'Dominic Vega',
            'username' => 'dvega',
            'email' => 'administrator@gmail.com',
            'password' => 'Da1andonly!',
            'role' => 'Administrator',
        ]);
        User::create([
            'id' => 2,
            'name' => 'FSN Admin',
            'username' => 'fsnadmin',
            'email' => 'fsnadmin@gmail.com',
            'password' => 'naks@32npo!NB',
            'role' => 'Administrator',
        ]);
    }
}
