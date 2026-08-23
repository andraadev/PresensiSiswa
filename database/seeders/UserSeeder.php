<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $DataDummyUser = [
            [
                'nama_lengkap' => 'Admin',
                'username' => 'Admin123',
                'password' => bcrypt('Admin123'),
                'role' => 'Admin',
                'is_active' => 1
            ],
            [
                'nama_lengkap' => 'User',
                'username' => 'User123',
                'password' => bcrypt('User123'),
                'role' => 'Guru',
                'is_active' => 1
            ],
            [
                'nama_lengkap' => 'User2',
                'username' => 'User678',
                'password' => bcrypt('User678'),
                'role' => 'BK',
                'is_active' => 1
            ],
        ];
        foreach ($DataDummyUser as $key => $value) {
            User::create($value);
        }
    }
}
