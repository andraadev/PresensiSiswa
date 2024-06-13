<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(GuruSeeder::class);
        $DataDummyUser = [
            [
                'nama_lengkap' => 'Admin',
                'username' => 'Admin123',
                'password' => bcrypt('Admin123'),
                'role' => 'Admin',
            ],
            [
                'nama_lengkap' => 'User',
                'username' => 'User123',
                'password' => bcrypt('User123'),
                'role' => 'Guru',
            ],
            [
                'nama_lengkap' => 'User2',
                'username' => 'User678',
                'password' => bcrypt('User678'),
                'role' => 'BK',
            ],
        ];
        foreach ($DataDummyUser as $key => $value) {
            User::create($value);
        }
    }
}
