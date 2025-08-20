<?php

namespace App\Http\Controllers;

use App\Imports\ImportDataSiswa;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.data-siswa', [
            'header' => 'Data Siswa',
            'siswa' => Siswa::orderBy('nama_lengkap', 'asc')->with('kelas')->get(),
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nisn' => 'required|max_digits:10|numeric|unique:siswa,nisn',
            'nama_lengkap' => 'required|max:100',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required',
            'no_telepon' => 'required|max:20|unique:siswa,no_telepon',
        ], [
            // Validasi input NISN
            'nisn.required' => 'NISN wajib diisi!',
            'nisn.max_digits' => 'Panjang NISN yang anda masukkan tidak boleh lebih dari 10 karakter!',
            'nisn.numeric' => 'NISN harus berupa angka!',
            'nisn.unique' => 'NISN yang anda masukkan telah ada!',

            // Validasi input Nama
            'nama_lengkap.required' => 'Nama wajib diisi!',
            'nama_lengkap.max' => 'Panjang Nama yang anda masukkan tidak boleh lebih dari 100 karakter!',

            // Validasi input No Telepon
            'no_telepon.required' => 'No Telepon wajib diisi!',
            'no_telepon.max' => 'Panjang No Telepon yang anda masukkan tidak boleh lebih dari 20 karakter!',

        ]);

        Siswa::create($validatedData);

        flash()->addSuccess('Tambah Data Siswa Berhasil');

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $validatedData = $request->validate([
            'nisn' => 'required|max_digits:10|numeric',
            'nama_lengkap' => 'required|max:100',
            'jenis_kelamin' => 'required',
            'kelas' => 'required',
            'no_telepon' => 'required|max:20',
        ], [
            // Validasi input NISN
            'nisn.required' => 'NISN wajib diisi!',
            'nisn.max_digits' => 'Panjang NISN yang anda masukkan tidak boleh lebih dari 10 karakter!',
            'nisn.numeric' => 'NISN harus berupa angka!',

            // Validasi input Nama
            'nama_lengkap.required' => 'Nama wajib diisi!',
            'nama_lengkap.max' => 'Panjang Nama yang anda masukkan tidak boleh lebih dari 100 karakter!',

            // Validasi input No Telepon
            'no_telepon.required' => 'No Telepon wajib diisi!',
            'no_telepon.max' => 'Panjang No Telepon yang anda masukkan tidak boleh lebih dari 20 karakter!',
        ]);

        $siswa->update($validatedData);

        flash()->addSuccess('Edit Data Siswa Berhasil');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        flash()->addSuccess('Hapus Data Siswa Berhasil');

        return back();
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xlsx,xls',
        ], [
            'file.mimes' => 'File harus berupa file Excel dengan ekstensi xlsx atau xls'
        ]);

        Excel::import(new ImportDataSiswa, $request->file('file'));

        flash()->addSuccess('Tambah Data Siswa Berhasil');

        return back();
    }
}
