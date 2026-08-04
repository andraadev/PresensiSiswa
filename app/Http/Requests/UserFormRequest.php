<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserFormRequest extends FormRequest
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
        $user = $this->route('user');

        // Dalam mode create, is update berisi null
        $isUpdate = $user !== null;

        // Dalam mode update, guru menggunakan role yang tersedia--sementara admin dan BK menggunakan role dari input
        $role = $this->input('role') ?? $user?->role;

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
                    Rule::unique('users', 'guru_id'),
                ],

                'password' => $passwordRule,
            ];
        }

        // ADMIN / BK
        $usernameRules = ['required', 'string', 'max:50'];

        if ($isUpdate) {
            $usernameRules[] = Rule::unique('user', 'username')->ignore($user);
        } else {
            $usernameRules[] = Rule::unique('users', 'username');
        }

        return [
            'role' => 'required|in:Admin,BK',
            'nama_lengkap' => 'required|string|max:100',
            'username' => $usernameRules,
            'password' => $passwordRule,
        ];
    }
}
