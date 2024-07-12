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

        // create admins
        $admins = \App\Models\User::factory(5)->create(['role_id' => $createdRoles->firstWhere('name', 'admin')->id]);

        // create teachers
        $teachers = \App\Models\User::factory(10)->create(['role_id' => $createdRoles->firstWhere('name', 'teacher')->id]);

        // create students
        $students = \App\Models\User::factory(100)->create(['role_id' => $createdRoles->firstWhere('name', 'student')->id]);

        // call ClassSeeder with variable $admins, $teachers, and $students
        $this->call(ClassSeeder::class, false,  [
            'admins' => $admins,
            'teachers' => $teachers,
            'students' => $students,
        ]);
    }
}
