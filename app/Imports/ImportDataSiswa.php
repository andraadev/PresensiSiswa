<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ImportDataSiswa implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        // Cek waktu eksekusi dalam detik dan aktifkan log query
        // DB::enableQueryLog();
        // $start = microtime(true);
        // $end = microtime(true);
        // $executionTime = $end - $start;
        // dd([
        //     'Execution time (seconds)' => $executionTime,
        //     'Total queries' => count(DB::getQueryLog()),
        //     'Query log' => DB::getQueryLog()
        // ]);
        $daftarKelas = Kelas::all()->keyBy('nama_kelas');
        foreach ($collection as $row) {
            // Cari ID kelas berdasarkan nama kelas
            $kelas = $daftarKelas[$row['Kelas']] ?? null;

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
}
