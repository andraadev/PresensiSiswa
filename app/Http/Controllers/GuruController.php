<?php

namespace App\Http\Controllers;

use App\Imports\ImportDataGuru;
use App\Models\Guru;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.data-guru.index', [
            'guru' => Guru::latest()->get(),
        ]);
    }

    public function create(){
        return view('admin.data-guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate(
            [
                'nip' => 'required|unique:guru,nip',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
                'no_telepon' => 'required|unique:guru,no_telepon',
            ],
            [
                'nip.required' => 'NIP Tidak Boleh Kosong!',
                'nip.unique' => 'NIP yang Anda Masukkan Telah Ada!',
                'nama_lengkap.required' => 'Nama Lengkap Tidak Boleh Kosong!',
                'jenis_kelamin.required' => 'Jenis Kelamin Tidak Boleh Kosong!',
                'jenis_kelamin.in' => 'Jenis Kelamin Tidak Valid!',
                'no_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong!',
                'no_telepon.unique' => 'Nomor Telepon yang Anda Masukkan Telah Ada!',
            ]
        );

        Guru::create($validated_data);

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Guru Berhasil');

        return redirect()->route('data-guru.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);

        $validated_data = $request->validate([
            'nip' => 'required',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_telepon' => 'required',
        ], [
            'nip.required' => 'NIP Tidak Boleh Kosong!',
            'nama_lengkap.required' => 'Nama Lengkap Tidak Boleh Kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin Tidak Boleh Kosong!',
            'jenis_kelamin.in' => 'Jenis Kelamin Tidak Valid!',
            'no_telepon.required' => 'Nomor Telepon Tidak Boleh Kosong!',
        ]);

        $guru->update($validated_data);

        flash()->option('timeout', 3000)->addSuccess('Edit Data Guru Berhasil');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        $guru->delete();

        flash()->addSuccess('Hapus Data Guru Berhasil');

        return back();
    }

    public function import_excel(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:xlsx,xls',
        ], [
            'file.mimes' => 'File harus berupa file Excel dengan ekstensi xlsx atau xls'
        ]);

        Excel::import(new ImportDataGuru, $request->file('file'));

        flash()->addSuccess('Tambah Data Guru Berhasil');

        return back();
    }
}
