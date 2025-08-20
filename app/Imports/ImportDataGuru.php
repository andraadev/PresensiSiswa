<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class ImportDataGuru implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            // $sanitized = array_map('trim', $row->toArray());
            // dd($sanitized);
            Guru::create([
                'nip' => trim($row['NIP']),
                'nama_lengkap' => trim($row['Nama Lengkap']),
                'jenis_kelamin' => trim($row['Jenis Kelamin']),
                'no_telepon' => trim($row['No Telepon'])
            ]);
        }
    }
}
