<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ImportDataSiswa implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // Cari ID kelas berdasarkan nama kelas
            $kelas = Kelas::where('nama_kelas', $row['Kelas'])->first();

            // Jika kelas ditemukan, buat entri siswa
            Siswa::create([
                'nisn' => $row['NISN'],
                'nama_lengkap' => $row['Nama'],
                'jenis_kelamin' => $row['Jenis Kelamin'],
                'kelas_id' => $kelas->id, // Gunakan ID kelas yang ditemukan
                'no_telepon' => $row['No Telepon']
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
