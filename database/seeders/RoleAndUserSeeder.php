<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role
        $roles = ['superadmin', 'admin', 'user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Buat user superadmin
        $superadmin = User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superadmin->assignRole('superadmin');

        // Buat user admin
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Buat user biasa
        $user = User::firstOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
            ]
        );
        $user->assignRole('user');
    }
}
