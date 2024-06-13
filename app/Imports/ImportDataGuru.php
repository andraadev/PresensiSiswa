<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ImportDataGuru implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Guru::create([
                'nip' => $row['NIP'],
                'nama_lengkap' => $row['Nama Lengkap'],
                'jenis_kelamin' => $row['Jenis Kelamin'],
                'no_telepon' => $row['No Telepon']
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
