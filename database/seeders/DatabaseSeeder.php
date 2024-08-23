<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin#1234'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'User',
            'nip' => 'KRYWN001-24',
            'email' => 'user@gmail.com',
            'password' => Hash::make('user#123'),
            'role' => 'karyawan', // Sesuaikan dengan field role yang ada di database
        ]);
    }
}
