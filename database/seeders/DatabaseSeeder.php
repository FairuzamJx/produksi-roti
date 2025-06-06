<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role-role jika belum ada
        $roles = ['superadmin', 'admin', 'user'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Buat user Superadmin
        $superadmin = User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'superadmin',  
            ]
        );
        $superadmin->assignRole('superadmin');

        // Buat user Admin
        $admin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',  // <-- tambahkan ini
            ]
        );
        $admin->assignRole('admin');

        // Buat user Biasa
        $user = User::firstOrCreate(
            ['username' => 'user'],
            [
                'name' => 'User Biasa',
                'password' => Hash::make('password'),
                'role' => 'user',  // <-- tambahkan ini
            ]
        );
        $user->assignRole('user');
    }
}
