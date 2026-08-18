<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;


class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id-ID');
        $guruIds = Guru::pluck('id')->toArray();

        // delete exists qr code (for development only)
        Storage::disk('public')->deleteDirectory('qr_code_kelas');

        foreach (['X IPA', 'X IPS', 'XI IPA', 'XI IPS', 'XII IPA'] as $kelasNama) {
            $slug = Str::slug($kelasNama);
            $qrPath = 'qr_code_kelas/qr-' . $slug . '.png';

            $qrImage = QRCode::format('png')->size(500)->margin(2)->generate(
                route('absensi.index') . '?kelas=' . $slug
            );

            Storage::disk('public')->put($qrPath, $qrImage);
            Kelas::create([
                'nama_kelas' => $kelasNama,
                'slug_kelas' => Str::slug($kelasNama),
                'qr_code' => $qrPath,
                'guru_id' => $faker->randomElement($guruIds),
            ]);
        }
    }
}
