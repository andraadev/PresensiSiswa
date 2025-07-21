<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.data-kelas', [
            'header' => 'Data Kelas',
            'kelas' => Kelas::latest()->get(),
            'guru' => Guru::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nama_kelas' => 'required|max:15',
            'guru_id' => 'required|numeric'
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'nama_kelas.max' => 'Nama kelas tidak boleh lebih dari 15',
        ]);

        $slug_kelas = str_replace(' ', '-', $request->nama_kelas);

        Kelas::create([
            'slug_kelas' => $slug_kelas,
            'nama_kelas' => $validated_data['nama_kelas'],
            'guru_id' => $validated_data['guru_id'],
        ]);

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Kelas Berhasil');

        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validated_data = $request->validate([
            'nama_kelas' => 'required|max:15',
            'guru_id' => 'required|numeric'
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'nama_kelas.max' => 'Nama kelas tidak boleh lebih dari 15',
        ]);

        // jika nama kelas yang dimasukkan tidak sama dengan nama kelas yang ada di database
        if ($validated_data['nama_kelas'] !== $kelas->nama_kelas) {

            $slug_kelas = str_replace(' ', '-', $request->nama_kelas);

            $kelas->update([
                'slug_kelas' => $slug_kelas,
                'nama_kelas' => $validated_data['nama_kelas'],
                'guru_id' => $validated_data['guru_id'],
            ]);
        }

        flash()->option('timeout', 3000)->addSuccess('Edit Data Kelas Berhasil');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kelas = Kelas::findOrFail($id);

        $kelas->delete();

        // flash message jika datanya berhasil dihapus
        flash()->option('timeout', 3000)->addSuccess('Hapus Data Kelas Berhasil');

        return back();
    }
}
