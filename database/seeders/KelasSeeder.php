<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id-ID');
        $guruIds = Guru::pluck('id')->toArray();

        foreach (['X IPA', 'X IPS', 'XI IPA', 'XI IPS', 'XII IPA'] as $kelasNama) {
            Kelas::create([
                'nama_kelas' => $kelasNama,
                'guru_id' => $faker->randomElement($guruIds),
            ]);
        }
    }
}
