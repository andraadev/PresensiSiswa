<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class KelasFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Set errorBag dynamically based on HTTP method
     */
    protected function prepareForValidation()
    {
        $this->errorBag = $this->isMethod('post') ? 'storeKelas' : 'updateKelas';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // [For update data only: check if guru id on kelas table is available or not]
        $kelasID = $this->kelas?->id;
        return [
            'nama_kelas' => 'required|max:20',
            'guru_id' => [
                'required',
                'integer',
                'exists:guru,id',
                Rule::unique('kelas', 'guru_id')->ignore($kelasID)
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'nama_kelas.max' => 'Nama kelas tidak boleh lebih dari 20 karakter',
            'guru_id.required' => 'Opsi wali kelas tidak boleh kosong!',
            'guru_id.exists' => 'Silakan pilih wali kelas yang tersedia.',
            'guru_id.unique' => 'Guru ini sudah terdaftar sebagai wali kelas.',
        ];
    }

    /**
     * Insert the 'edit_kelas_id' session if the update fails
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            session()->flash('edit_kelas_id', $this->kelas?->id);
        }

        parent::failedValidation($validator);
    }
}
