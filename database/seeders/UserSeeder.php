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
            'username' => 'dvega',
            'role' => 1,
            'password' => 'Da1andonly!',
            'can_login' => 1,
            'locked' => 0,
        ]);
        User::create([
            'id' => 2,
            'username' => 'fsnadmin',
            'role' => 1,
            'password' => 'naks@32npo!NB',
            'can_login' => 1,
            'locked' => 0,
        ]);
    }
}
