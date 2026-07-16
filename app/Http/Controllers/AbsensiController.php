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
    public function index(?string $id_kelas = null)
    {
        $hari_ini = date('Y-m-d');
        $kelasSaya = collect();

        $relations = ['siswa.absensi' => function ($query) use ($hari_ini) {
            $query->whereBetween('created_at', [$hari_ini . ' 00:00:00', $hari_ini . ' 23:59:59']);
        }];

        if ($id_kelas) {
            $kelasSaya = Kelas::with($relations)->where('id', $id_kelas)->get();
        } else {
            $guruIdLogin = auth()->user()->guru?->id;
            if ($guruIdLogin) {
                $kelasSaya = Kelas::with($relations)->where('guru_id', $guruIdLogin)->get();
            }
        }

        // Semua kelas untuk jaring pengaman fallback (tetap di-load relasinya biar aman)
        $semuaKelas = Kelas::with($relations)->get();

        return view('guru.absensi', [
            'kelas_saya'  => $kelasSaya,
            'semua_kelas' => $semuaKelas,
            'header'      => 'Dashboard Presensi Siswa'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(?string $id_kelas = null)
    {
        $kelas = Kelas::findOrFail($id_kelas);
        $siswa = Siswa::where('kelas_id', $id_kelas)->get();

        return view('guru.tambah-data-absensi', compact('kelas', 'siswa'));
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
            'status.*' => 'required|in:Hadir,Sakit,Izin,Alpa',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|max:50'
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

    public function edit(string $id)
    {
        $hari_ini = date('Y-m-d');
        $dataSiswa = Siswa::where('kelas_id', $id)
            ->with(['absensi' => function ($query) use ($hari_ini) {
                $query->whereBetween('created_at', [$hari_ini . ' 00:00:00', $hari_ini . ' 23:59:59']);
            }])
            ->get();
        $kelas = Kelas::findOrFail($id);

        return view('guru.edit-data-absensi', [
            'daftar_siswa' => $dataSiswa,
            'kelas' => $kelas
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kelas_id)
    {
        $this->validate($request, [
            'siswa_id' => 'required|array',
            'status' => 'required|array',
            'status.*' => 'required|in:Hadir,Sakit,Izin,Alpa',
            'keterangan' => 'nullable|array',
            'keterangan.*' => 'nullable|max:50'
        ]);

        $siswa_ids = $request->siswa_id;
        $hari_ini = date('Y-m-d');
        foreach ($siswa_ids as $siswa_id) {
            $absensi = Absensi::where('siswa_id', $siswa_id)
                ->where('created_at', '>=', $hari_ini . ' 00:00:00')
                ->where('created_at', '<=', $hari_ini . ' 23:59:59')
                ->firstOrFail();;

            $statusBaru = $request->status[$siswa_id];
            $absensi->status = $statusBaru;

            if ($statusBaru == 'Sakit' || $statusBaru == 'Izin') {
                $absensi->keterangan = $request->keterangan[$siswa_id] ?? null;
            } else {
                $absensi->keterangan = null;
            }

            $absensi->save();
        }

        flash()->addSuccess('Edit Status Absensi Berhasil!');

        return redirect()->route('absensi.index', $kelas_id);
    }
}
