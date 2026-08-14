<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ImportDataGuruSheet implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsFailures;

    public function collection(Collection $collection)
    {

        // dd($collection->first()->toArray());

        foreach ($collection as $row) {

            Guru::create([
                'nip'           => $row['nip'],
                'nama_lengkap'  => $row['nama_lengkap'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'no_telepon'    => $row['no_telepon'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.nip'           => 'required|digits:18|distinct|unique:guru,nip',
            '*.nama_lengkap'  => 'required|max:100',
            '*.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            '*.no_telepon'    => 'required|regex:/^08[0-9]{10,11}$/|distinct|unique:guru,no_telepon',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nip.required'           => 'NIP tidak boleh kosong.',
            '*.nip.unique'             => 'NIP yang Anda masukkan sudah terdaftar.',
            '*.nip.digits'             => 'NIP harus terdiri dari 18 digit angka.',
            '*.nip.distinct'             => 'NIP ganda/duplikat ditemukan di dalam file Excel ini.',

            '*.nama_lengkap.required'  => 'Nama lengkap tidak boleh kosong.',
            '*.nama_lengkap.max'       => 'Nama lengkap tidak boleh lebih dari 100 karakter.',

            '*.jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong.',
            '*.jenis_kelamin.in'       => 'Jenis kelamin tidak valid ditemukan di dalam file excel ini.',

            '*.no_telepon.required'    => 'Nomor telepon tidak boleh kosong.',
            '*.no_telepon.digits_between' => 'Nomor telepon harus diantara 10-13 digit.',
            '*.no_telepon.distinct' => 'Nomor telepon ganda ditemukan di dalam file Excel ini.',
            '*.no_telepon.regex'  => 'Nomor telepon harus diawali 08 dan berjumlah 10-13 digit.',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data = array_map(fn($value) => is_string($value) ? trim($value) : $value, $data);

        if (!empty($data['jenis_kelamin'])) {
            $jk = strtolower($data['jenis_kelamin']);

            if (in_array($jk, ['laki-laki', 'laki laki', 'l', 'pria'])) {
                $data['jenis_kelamin'] = 'Laki-laki';
            } elseif (in_array($jk, ['perempuan', 'p', 'wanita'])) {
                $data['jenis_kelamin'] = 'Perempuan';
            }
        }

        return $data;
    }
}
