<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class ImportDataGuru implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function collection(Collection $collection)
    {
        // dd($collection->first()->toArray());

        foreach ($collection as $row) {
            if (empty($row['nip'])) {
                continue;
            }

            Guru::create([
                'nip'           => trim($row['nip']),
                'nama_lengkap'  => trim($row['nama_lengkap']),
                'jenis_kelamin' => trim($row['jenis_kelamin']),
                'no_telepon'    => trim($row['nomor_telepon']),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.nip'           => 'required|digits:18|unique:guru,nip',
            '*.nama_lengkap'  => 'required|max:100',
            '*.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            '*.nomor_telepon'    => 'required|digits_between:10,13|unique:guru,no_telepon',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.nip.required'           => 'NIP tidak boleh kosong.',
            '*.nip.unique'             => 'NIP yang Anda masukkan sudah terdaftar.',
            '*.nip.digits'             => 'NIP harus terdiri dari 18 digit angka.',
            '*.nama_lengkap.required'  => 'Nama lengkap tidak boleh kosong.',
            '*.nama_lengkap.max'       => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
            '*.jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong.',
            '*.jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
            '*.nomor_telepon.required'    => 'Nomor telepon tidak boleh kosong.',
            '*.nomor_telepon.unique'      => 'Nomor telepon yang Anda masukkan sudah terdaftar.',
            '*.nomor_telepon.digits_between' => 'Nomor telepon harus diantara 10-13 digit.',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        if (isset($data['jenis_kelamin'])) {
            $data['jenis_kelamin'] = ucfirst(strtolower(trim($data['jenis_kelamin'])));
        }

        return $data;
    }
}
