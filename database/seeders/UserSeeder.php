<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [

            // ADMIN
            [
                'name' => 'FARIDA',
                'email' => 'farida@gmail.com',
                'password' => 'faridacuantik09',
                'role' => 'admin',
            ],
            [
                'name' => 'ROYHAN',
                'email' => 'royhan@gmail.com',
                'password' => 'royhanaja14',
                'role' => 'admin',
            ],
            [
                'name' => 'MAHMUD',
                'email' => 'mahmudnia838@gmail.com',
                'password' => 'MahmudNia_838#',
                'role' => 'admin',
            ],

            // DESAIN
            [
                'name' => 'ANWAR',
                'email' => 'AnwarSanusi@gmail.com',
                'password' => 'anwarr838#',
                'role' => 'tim_desain',
            ],

            // PRODUKSI
            [
                'name' => 'JAMAL',
                'email' => 'jamal@gmail.com',
                'password' => 'jamal_838',
                'role' => 'tim_produksi',
            ],
            [
                'name' => 'JUJUN',
                'email' => 'Djunaidi@gmail.com',
                'password' => 'jujun#838',
                'role' => 'tim_produksi',
            ],

            // DRIVER1
            [
                'name' => 'UDIN',
                'email' => 'SaefudinMulia@gmail.com',
                'password' => 'udinmulia838',
                'role' => 'driver1',
            ],

            // DRIVER
            [
                'name' => 'RAFLI',
                'email' => 'RafliAndhaka@gmail.com',
                'password' => 'rafli_838!',
                'role' => 'driver',
            ],
            [
                'name' => 'AJI',
                'email' => 'ajitullah@gmail.com',
                'password' => 'aji838_!',
                'role' => 'driver',
            ],

            // LOGISTIK
            [
                'name' => 'WORO',
                'email' => 'woro@gmail.com',
                'password' => 'woro_#838',
                'role' => 'logistik',
            ],

        ];

        foreach ($users as $user) {

            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                    'email_verified_at' => now(),
                ]
            );

        }
    }
}
