<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Guru::factory(20)->create();
        // $faker = Faker::create();

        // for ($i = 1; $i == 20; $i++) {
        //     Guru::create([
        //         'nip' => $faker->numberBetween(0000000000, 9999999999),
        //         'nama_lengkap' => $faker->name(),
        //         'jenis_kelamin' => $faker->randomElements(['Laki-laki', 'Perempuan']),
        //         'no_telepon' => $faker->numberBetween(0000000000000, 9999999999999),
        //     ]);
        // }
    }
}
