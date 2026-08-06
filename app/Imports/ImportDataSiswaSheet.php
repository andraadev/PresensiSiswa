<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Support\Str;

class ImportDataSiswaSheet implements ToCollection, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Siswa::create([
                'nisn' => $row['nisn'],
                'nama_lengkap' => $row['nama_lengkap'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'kelas_id' => $row['kelas_id'],
                'no_telepon' => $row['no_telepon'],
                'status' => $row['status']
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.nisn'          => 'required|digits:10|distinct|unique:siswa,nisn',
            '*.nama_lengkap'  => 'required|max:100',
            '*.jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            '*.kelas_id'      => 'required|exists:kelas,id',
            '*.no_telepon'    => 'required|regex:/^08[0-9]{8,11}$/|distinct|unique:siswa,no_telepon',
            '*.status'        => 'nullable|in:Aktif,Lulus,Mutasi,Keluar',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            '*.nisn.required'          => 'NISN tidak boleh kosong.',
            '*.nisn.digits'            => 'NISN harus terdiri dari 10 digit angka.',
            '*.nisn.distinct'          => 'NISN duplikat ditemukan di dalam file Excel.',
            '*.nisn.unique'            => 'NISN sudah terdaftar di sistem.',
            '*.nama_lengkap.required'  => 'Nama lengkap tidak boleh kosong.',
            '*.nama_lengkap.max'       => 'Nama lengkap maksimal 100 karakter.',
            '*.jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong.',
            '*.jenis_kelamin.in'       => 'Jenis kelamin harus Laki-laki atau Perempuan.',
            '*.kelas_id.required'      => 'Nama kelas di Excel tidak ditemukan di database.',
            '*.kelas_id.exists'        => 'Kelas tidak valid.',
            '*.no_telepon.required'    => 'Nomor telepon tidak boleh kosong.',
            '*.no_telepon.distinct'    => 'Nomor telepon duplikat ditemukan di dalam file Excel.',
            '*.no_telepon.unique'      => 'Nomor telepon sudah terdaftar di sistem.',
            '*.no_telepon.regex'       => 'Nomor telepon harus diawali 08 dan berjumlah 10-13 digit.',
            '*.status.in'              => 'Status hanya boleh berisi: Aktif, Lulus, Mutasi, atau Keluar.',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        // dd($index, $data);
        // Trim all data
        $data = array_map(function ($value) {
            return is_string($value) ? trim($value) : $value;
        }, $data);

        // Get kelas_id based on slug
        $rawKelas = $data['kelas'] ?? null;
        $data['kelas_id'] = $rawKelas
            ? Kelas::where('slug_kelas', Str::slug($rawKelas))->value('id')
            : null;

        // Convert NISN to string
        if (isset($data['nisn'])) {
            $data['nisn'] = (string) $data['nisn'];
        }

        if (!empty($data['status'])) {
            $data['status'] = Str::ucfirst(Str::lower($data['status']));
        } else {
            $data['status'] = 'Aktif';
        }

        return $data;
    }
}
