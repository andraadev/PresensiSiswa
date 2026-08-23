<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Database\Seeder;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ambil seluruh siswa dan acak urutan datanya
        $semuaSiswa = Siswa::where('kelas_id', 2)->get()->shuffle();

        // Ambil misal 3 siswa acak untuk disimulasikan sebagai At-Risk (>= 3 alpa)
        $jumlahSiswaAtRisk = 3;
        $siswaAtRisk = $semuaSiswa->take($jumlahSiswaAtRisk);

        // Sisanya dipakai untuk absensi normal (Hadir, Sakit, Izin)
        $siswaNormal = $semuaSiswa->slice($jumlahSiswaAtRisk)->take(10);

        $keteranganSakit = [
            'Demam',
            'Flu',
            'Sakit kepala',
            'Batuk',
        ];

        $keteranganIzin = [
            'Acara keluarga',
            'Keperluan keluarga',
            'Keperluan pribadi',
        ];

        // 2. Generate data Alpa berulang untuk masing-masing siswa At-Risk
        foreach ($siswaAtRisk as $siswa) {
            $totalAlpa = fake()->numberBetween(3, 5); // 3 sampai 5 hari alpa

            for ($i = 1; $i <= $totalAlpa; $i++) {
                Absensi::create([
                    'guru_id'         => 2,
                    'kelas_id'        => $siswa->kelas_id,
                    'siswa_id'        => $siswa->id,
                    'status'          => 'Alpa',
                    'tanggal_absensi' => now()->subDays($i)->toDateString(),
                ]);
            }
        }

        // 3. Generate data acak normal untuk siswa lainnya
        foreach ($siswaNormal as $siswa) {
            $status = fake()->randomElement(['Hadir', 'Sakit', 'Izin']);

            $keterangan = match ($status) {
                'Sakit' => fake()->randomElement($keteranganSakit),
                'Izin'  => fake()->randomElement($keteranganIzin),
                default => null,
            };

            Absensi::create([
                'guru_id'         => 2,
                'kelas_id'        => $siswa->kelas_id,
                'siswa_id'        => $siswa->id,
                'status'          => $status,
                'keterangan'      => $keterangan,
                'tanggal_absensi' => now()->subDays(fake()->numberBetween(1, 5))->toDateString(),
            ]);
        }
    }
}
