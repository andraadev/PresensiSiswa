<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Fungsi CRUD Absensi
     */
    public function index(Request $request)
    {
        $hari_ini = date('Y-m-d');
        $kelasSaya = collect();

        $slug_kelas = $request->query('kelas') ?? session('active_kelas_slug');

        $relations = ['siswa.absensi' => function ($query) use ($hari_ini) {
            $query->whereBetween('created_at', [$hari_ini . ' 00:00:00', $hari_ini . ' 23:59:59']);
        }];

        $kelasAktif = $slug_kelas ? Kelas::with($relations)->where('slug_kelas', $slug_kelas)->first() : null;
        if ($kelasAktif) {
            session(['active_kelas_slug' => $kelas->slug_kelas]);

            $kelasSaya = collect([$kelasAktif]);
            $totalSiswa = $kelasAktif->siswa()->count();
            $stats = $kelasAktif->absensi()
                ->whereDate('created_at', today())
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status');
        } else {
            session()->forget('active_kelas_slug');
            $kelasSaya = collect();
            $totalSiswa = 0;
            $stats = collect();
        }

        $semuaKelas = Kelas::with($relations)->get();

        return view('guru.absensi', [
            'kelas_saya'  => $kelasSaya,
            'semua_kelas' => $semuaKelas,
            'total_siswa' => $totalSiswa,
            'siswa_hadir' => $stats['Hadir'] ?? 0,
            'siswa_sakit' => ($stats['Sakit'] ?? 0) + ($stats['Izin'] ?? 0),
            'siswa_alpa'  => $stats['Alpa'] ?? 0,
            'header'      => 'Dashboard Presensi Siswa'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $slug = session('active_kelas_slug');
        $kelas = Kelas::where('slug_kelas', $slug)->first();
        if (!$kelas) {
            flash()->option('timeout', 3000)->addError('Sesi kelas tidak valid atau tidak ditemukan.');
            return redirect()->route('absensi.index');
        }

        $siswa = Siswa::where('kelas_id', $kelas->id)->get();
        return view('guru.tambah-data-absensi', compact('kelas', 'siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'siswa_id' => 'required|exists:siswa,id',
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
    public function update(Request $request)
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

        return redirect()->route('absensi.index');
    }

    public function data_absensi(Request $request)
    {
        $slug = session('active_kelas_slug');
        $kelas = Kelas::where('slug_kelas', $slug)->first();

        if (!$kelas) {
            flash()->option('timeout', 3000)->addError('Sesi kelas tidak valid atau tidak ditemukan.');
            return redirect()->route('absensi.index');
        }

        $bulan = $request->bulan ?? date('Y-m');
        [$tahun, $bulan] = explode('-', $bulan);

        $siswa = Siswa::where('kelas_id', $kelas->id)->withRekapBulan($tahun, $bulan)->get();

        return view('guru.data-absensi', [
            'siswa' => $siswa,
            'header' => 'Data Absensi'
        ]);
    }

    public function detailSiswa(string $siswa_id, Request $request)
    {
        $siswa = Siswa::findOrFail($siswa_id);

        $tanggalMulai = $request->tanggal_mulai;
        $tanggalSelesai = $request->tanggal_selesai;

        $riwayatAbsensi = Absensi::where('siswa_id', $siswa->id)
            ->when($tanggalMulai, function ($query, $mulai) {
                $query->whereDate('created_at', '>=', $mulai . ' 00:00:00');
            })
            ->when($tanggalSelesai, function ($query, $selesai) {
                $query->whereDate('created_at', '<=', $selesai . ' 23:59:59');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('guru.data-absensi-detail', [
            'siswa' => $siswa,
            'riwayat_absensi' => $riwayatAbsensi
        ]);
    }
}
