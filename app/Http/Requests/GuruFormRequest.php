<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuruFormRequest extends FormRequest
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
        // [For update data only: check if guru id is available or not]
        $guruId = $this->guru->id ?? null;

        return [
            'nip' => 'required|digits:18|unique:guru,nip,' . $guruId,
            'nama_lengkap' => 'required|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required|digits_between:12,13|unique:guru,no_telepon,' . $guruId,
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required' => 'NIP tidak boleh kosong.',
            'nip.unique' => 'NIP yang Anda masukkan sudah terdaftar.',
            'nip.digits' => 'NIP harus terdiri dari 18 digit angka.',
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong.',
            'nama_lengkap.max' => 'Nama lengkap tidak boleh lebih dari 100 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin tidak boleh kosong.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'no_telepon.required' => 'Nomor telepon tidak boleh kosong.',
            'no_telepon.unique' => 'Nomor telepon yang Anda masukkan sudah terdaftar.',
            'no_telepon.digits_between' => 'Nomor telepon harus diantara 12-13 digit.',
        ];
    }
}
