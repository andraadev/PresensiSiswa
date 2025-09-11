<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaFormRequest;
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
        return view('admin.data-siswa.index', [
            'siswa' => Siswa::latest()->with('kelas')->get(),
            'kelas' => Kelas::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiswaFormRequest $request)
    {
        Siswa::create($request->validated());

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Siswa Berhasil');

        return redirect()->route('data-siswa.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiswaFormRequest $request, Siswa $siswa)
    {
        $siswa->update($request->validated());

        flash()->option('timeout', 3000)->addSuccess('Edit Data Siswa Berhasil');

        return redirect()->route('data-siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        flash()->option('timeout', 3000)->addSuccess('Hapus Data Siswa Berhasil');

        return redirect()->route('data-siswa.index');
    }

    public function import_excel(Request $request)
    {
        Excel::import(new ImportDataSiswa, $request->validated()['file']);

        flash()->options('timeout', 3000)->addSuccess('Tambah Data Siswa Berhasil');

        return back();
    }
}
