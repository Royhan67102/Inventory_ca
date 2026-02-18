<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Tim Desain',
            'email' => 'desain@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'tim_desain',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Tim Produksi',
            'email' => 'produksi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'tim_produksi',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Driver',
            'email' => 'driver@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'driver',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Logistik',
            'email' => 'logistik@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'logistik',
            'email_verified_at' => now(),
        ]);
    }
}
