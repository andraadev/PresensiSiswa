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
        // \App\Models\Guru::factory(20)->create();
        $faker = Faker::create('id-ID');

        for ($i = 1; $i <= 20; $i++) {
            Guru::create([
                // Generate 18 digits of nim, and unique
                'nip' => $faker->unique()->numerify('##################'),
                'nama_lengkap' => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                // Generate 13 digits of random telephone number in indonesian
                'no_telepon' => '08' . $faker->numerify('##########')
            ]);
        }
    }
}
