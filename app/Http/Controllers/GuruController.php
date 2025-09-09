<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExcelImportRequest;
use App\Http\Requests\GuruFormRequest;
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

    public function create()
    {
        return view('admin.data-guru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuruFormRequest $request)
    {
        Guru::create($request->validated());

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Guru Berhasil');

        return redirect()->route('data-guru.index');
    }

    public function edit(Guru $guru)
    {
        return view('admin.data-guru.update', compact('guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuruFormRequest $request, Guru $guru)
    {
        $guru->update($request->validated());

        flash()->option('timeout', 3000)->addSuccess('Edit Data Guru Berhasil');

        return redirect()->route('data-guru.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guru $guru)
    {
        $guru->delete();

        flash()->option('timeout', 3000)->addSuccess('Hapus Data Guru Berhasil');

        return redirect()->route('data-guru.index');
    }

    public function import_excel(ExcelImportRequest $request)
    {
        Excel::import(new ImportDataGuru, $request->validated()['file']);

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Guru Berhasil');

        return back();
    }
}
