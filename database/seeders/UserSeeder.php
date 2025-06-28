<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User (Pak Gilberth)
        User::create([
            'nama' => 'Pak Gilberth',
            'email' => 'admin@mykost.com',
            'password' => Hash::make('password'),
            'no_hp' => '081234567890',
            'role' => 'Admin',
            'email_verified_at' => now(),
        ]);

        // Create Sample Users
        $users = [
            [
                'nama' => 'John Doe',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '082345678901',
                'role' => 'User',
                'email_verified_at' => now(),
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '083456789012',
                'role' => 'User',
                'email_verified_at' => now(),
            ],
            [
                'nama' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '084567890123',
                'role' => 'User',
                'email_verified_at' => now(),
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '085678901234',
                'role' => 'User',
                'email_verified_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@example.com',
                'password' => Hash::make('password'),
                'no_hp' => '086789012345',
                'role' => 'User',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
