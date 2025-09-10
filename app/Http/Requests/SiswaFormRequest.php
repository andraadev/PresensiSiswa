<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiswaFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // [For update data only: check if siswa id is available or not]
        $siswaId = $this->siswa->id ?? null;

        return [
            'nisn' => 'required|digits:10|unique:siswa,nisn,' . $siswaId,
            'nama_lengkap' => 'required|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'required',
            'no_telepon' => 'required|max:13|unique:siswa,no_telepon,' . $siswaId,
        ];
    }

    public function messages(): array {
        return[
            'nisn.required' => 'NIP tidak boleh kosong.',
            'nisn.digits' => 'NISN harus terdiri dari 10 digit angka.',
            'nisn.unique' => 'NIP yang Anda masukkan sudah terdaftar.',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'no_telepon.required' => 'Nomor telepon tidak boleh kosong.',
            'no_telepon.unique' => 'Nomor telepon yang Anda masukkan sudah terdaftar.',
            'no_telepon.max' => 'Nomor telepon tidak boleh lebih dari 13 digit.',
        ];
    }
}
