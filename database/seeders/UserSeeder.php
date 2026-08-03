<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        for ($i = 1; $i <= 2; $i++) {

            $user = User::create([
                // 'id' => 'ADM-' . mt_rand(100000, 999999),
                'id' =>  mt_rand(100000, 999999),
                'name' => "Admin $i",
                'email' => "admin$i@kampus.ac.id",
                'password' => Hash::make('12345678'),
            ]);

            $user->assignRole('Admin');
        }

        // Dosen
        for ($i = 1; $i <= 8; $i++) {

            $user = User::create([
                // 'id' => 'DSN-' . mt_rand(100000, 999999),
                'id' =>  mt_rand(100000, 999999),
                'name' => "Dosen $i",
                'email' => "dosen$i@kampus.ac.id",
                'password' => Hash::make('12345678'),
            ]);

            $user->assignRole('Dosen');
        }
    }
}
