<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->route('user');
        $isUpdate = $user !== null;

        // Ensure that the fallback works properly if the 'role' is submitted as empty
        $role = $this->filled('role') ? $this->input('role') : $user?->role;

        $passwordRule = $isUpdate ? ['nullable', 'min:8'] : ['required', 'min:8'];

        if ($role === 'Guru') {
            if ($isUpdate) {
                return [
                    'password' => $passwordRule,
                ];
            }

            return [
                'role' => ['required', 'in:Admin,Guru,BK'],

                'guru_id' => [
                    'required',
                    'exists:guru,id',
                    Rule::unique('user', 'guru_id'),
                ],

                'password' => $passwordRule,
            ];
        }

        // ADMIN / BK
        $usernameRules = ['required', 'string', 'max:50'];

        if ($isUpdate) {
            $usernameRules[] = Rule::unique('user', 'username')->ignore($user);
        } else {
            $usernameRules[] = Rule::unique('user', 'username');
        }

        return [
            'role' => ['required', 'in:Admin,BK'],
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => $usernameRules,
            'password' => $passwordRule,
        ];
    }

    public function messages(): array
    {
        return [
            'role.required'         => 'Role wajib dipilih!',
            'role.in'               => 'Role tidak valid!',

            'guru_id.required'      => 'Data guru wajib dipilih untuk akun Guru!',
            'guru_id.exists'        => 'Data guru tidak ditemukan!',
            'guru_id.unique'        => 'Guru ini sudah memiliki akun user!',

            'nama_lengkap.required' => 'Nama lengkap wajib diisi!',
            'nama_lengkap.max'      => 'Nama lengkap maksimal 100 karakter!',

            'username.required'     => 'Username wajib diisi!',
            'username.unique'       => 'Username sudah digunakan, cari username lain!',
            'username.max'          => 'Username maksimal 50 karakter!',

            'password.required'     => 'Password wajib diisi!',
            'password.min'          => 'Password minimal harus 8 karakter!',
        ];
    }
}
