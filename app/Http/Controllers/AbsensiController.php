<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function data_absensi()
    {
        return view('guru.data-absensi', [
            'absensi' => Absensi::all(),
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all(),
            'user' => User::all(),
            'header' => 'Data Absensi'
        ]);
    }
    /**
     * Display a listing of the resource.
     * Fungsi CRUD Absensi
     */
    public function index()
    {
        return view('guru.absensi', [
            'absensi' => Absensi::all(),
            'siswa' => Siswa::all(),
            'header' => 'Absensi',
            // 'siswa' => Siswa::join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
            // ->where('kelas.slug', $slug_kelas)
            // ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guru.tambah-data-absensi', [
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all(),
            'header' => 'Tambah Data Absensi',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'guru_id' => 'required',
            'kelas_id' => 'required',
            'siswa_id' => 'required',
            'status' => 'required|array',
            'status*' => 'required|in:Hadir,Sakit,Izin,Alpa',
            'keterangan' => 'nullable|max:50'
        ]);

        foreach ($request->status as $siswa_id => $status) {
            $keterangan = null;

            // Cek apakah status adalah "Izin"
            if ($status == 'Izin' || $status == 'Sakit') {
                // Ambil keterangan dari request
                $keterangan = $request->keterangan[$siswa_id];
            }

            Absensi::create([
                'guru_id' => $request->guru_id,
                'kelas_id' => $request->kelas_id,
                'siswa_id' => $siswa_id,
                'status' => $status,
                'keterangan' => $keterangan,
            ]);
        }


        flash()->addSuccess('Absensi Berhasil!');

        return redirect()->route('absensi.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa_id = $request->siswa_id;
        foreach ($siswa_id as $id) {
            // Temukan data absensi berdasarkan siswa_id
            $absensi = Absensi::where('siswa_id', $id)->firstOrFail();

            // Lakukan update data absensi
            $absensi->status = $request->status[$id];
            $absensi->keterangan = $request->keterangan[$id];
            $absensi->save();
        }

        flash()->addSuccess('Edit Status Absensi Berhasil!');

        return redirect()->route('absensi.index');
    }
}
