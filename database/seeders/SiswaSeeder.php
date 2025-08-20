<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kelasIds = Kelas::pluck('id')->toArray();

        for ($i = 1; $i <= 20; $i++) {
            Siswa::create([
                // Generate 10 digits of nisn, and unique
                'nisn' => $faker->unique()->numerify('##########'),
                'nama_lengkap' => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'kelas_id' => $faker->randomElement($kelasIds),
                // Generate 13 digits of random telephone number in indonesian
                'no_telepon' => '08' . $faker->numerify('##########'),
            ]);
        }
    }
}
