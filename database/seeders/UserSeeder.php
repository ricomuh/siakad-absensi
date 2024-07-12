<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect(['admin', 'teacher', 'student']);

        $createdRoles = $roles->map(function ($role) {
            return \App\Models\Role::create(['name' => $role]);
        });
    }
}
