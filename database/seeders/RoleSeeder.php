<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'id' => 1,
            'name' => 'Administrator'
        ]);
        Role::create([
            'id' => 2,
            'name' => 'Florist Representative'
        ]);
        Role::create([
            'id' => 3,
            'name' => 'Florist'
        ]);
    }
}
