<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CounselingFormRequest extends FormRequest
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
        return [
            'student_id' => 'required|exists:siswa,id',
            'action_date' => 'required|date',
            'action_type' => 'required|in:Konseling Individu,Panggilan Orang Tua,Kunjungan Rumah,Peringatan Lisan',
            'problem_notes' => 'required|string',
            'agreement_result' => 'required|string',
            'status' => 'required|in:Belum Ditangani,Sedang Dipantau,Selesai'
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.required' => 'Siswa tidak boleh kosong.',
            'student_id.exists' => 'Siswa yang dipilih tidak valid.',
            'action_date.required' => 'Tanggal penindakan tidak boleh kosong.',
            'action_date.date' => 'Format tanggal tidak valid.',
            'action_type.required' => 'Jenis tindakan tidak boleh kosong.',
            'action_type.in' => 'Jenis tindakan tidak valid.',
            'problem_notes.required' => 'Catatan masalah tidak boleh kosong.',
            'problem_notes.string' => 'Catatan masalah harus berupa teks.',
            'agreement_result.required' => 'Hasil kesepakatan tidak boleh kosong.',
            'agreement_result.string' => 'Hasil kesepakatan harus berupa teks.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
