<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'password' => Hash::make('password'), // Ubah sesuai password yang Anda inginkan
            'role' => 'superadmin'
        ]);
    }
}
