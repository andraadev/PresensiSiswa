<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Counseling;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function beranda_admin()
    {
        $user =  User::count('nama_lengkap');
        $guru = Guru::count('nama_lengkap');
        $siswa = Siswa::count('nama_lengkap');
        $kelas = Kelas::count('nama_kelas');

        $siswaPerKelas = Kelas::withCount('siswa')->orderBy('nama_kelas', 'asc')->get();

        $labels = $siswaPerKelas->pluck('nama_kelas')->toArray();
        $data   = $siswaPerKelas->pluck('siswa_count')->toArray();

        $today = \Carbon\Carbon::today();
        $allKelas = Kelas::orderBy('nama_kelas', 'asc')->get();

        $statusKelas = $allKelas->map(function ($kelas) use ($today) {
            $sudahAbsen = $kelas->siswa()->whereHas('absensi', function ($query) use ($today) {
                $query->whereDate('created_at', $today);
            })->exists();

            return [
                'nama_kelas'  => $kelas->nama_kelas,
                'sudah_absen' => $sudahAbsen,
            ];
        });

        $totalKelas      = $statusKelas->count();
        $totalKelasSudah = $statusKelas->where('sudah_absen', true)->count();

        return view('admin.beranda', compact('labels', 'data', 'user', 'guru', 'siswa', 'kelas', 'statusKelas', 'totalKelas', 'totalKelasSudah'));
    }

    public function beranda_bk()
    {
        $hari_ini = date('Y-m-d');
        $siswaAlpa = Siswa::where('status', 'Aktif')->withCount([
            'absensi' => function ($query) {
                $query->where('status', 'Alpa');
            }
        ])
            ->having('absensi_count', '>=', 3)
            ->get();

        $latestCounselings = Counseling::with('student')
            ->whereIn('status', ['Belum Ditangani', 'Sedang Dipantau'])
            ->with('latestCounseling')
            ->latest('action_date')
            ->take(5)
            ->get();

        $totalAlpa = Absensi::where('status', 'Alpa')->where('tanggal_absensi', $hari_ini)->count();
        return view('bk.beranda', compact('totalAlpa', 'siswaAlpa', 'latestCounselings'));
    }

    public function histori_absensi(Siswa $siswa)
    {
        $riwayatAbsensi = Absensi::where('siswa_id', $siswa->id)->orderBy('tanggal_absensi', 'desc')->get();

        $summary = (object) [
            'hadir' => $riwayatAbsensi->where('status', 'Hadir')->count(),
            'sakit' => $riwayatAbsensi->where('status', 'Sakit')->count(),
            'izin'  => $riwayatAbsensi->where('status', 'Izin')->count(),
            'alpa'  => $riwayatAbsensi->where('status', 'Alpa')->count(),
            'alpa_terakhir' => $riwayatAbsensi->firstWhere('status', 'Alpa')?->tanggal_absensi,
        ];
        return view('bk.detail-absensi', compact('siswa', 'riwayatAbsensi', 'summary'));
    }

    public function data_absensi(Request $request)
    {
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');
        $kelas_id = $request->input('kelas_id');
        $statusSelected = $request->query('status', 'Semua');

        $absensi =  Absensi::when($tanggal_mulai, fn($q) => $q->where("tanggal_absensi", '>=', $tanggal_mulai))
            ->when($tanggal_selesai, fn($q) => $q->where("tanggal_absensi", '<=', $tanggal_selesai))
            ->when($kelas_id, fn($q) => $q->where('kelas_id', $kelas_id))
            ->when($statusSelected !== 'Semua', function ($query) use ($statusSelected) {
                $query->whereHas('siswa', function ($q) use ($statusSelected) {
                    $q->where('status', $statusSelected);
                });
            })
            ->get();

        $kelas = Kelas::all();

        return view('data-absensi', compact('absensi', 'kelas'));
    }

    public function rekapitulasi_absensi(Request $request)
    {
        $bulan = $request->bulan ?? date('Y-m');
        $kelas_id = $request->kelas_id ?? null;
        $statusSelected = $request->query('status', 'Semua');

        [$tahun, $bulan] = explode('-', $bulan);

        $siswa = Siswa::with(['kelas'])
            ->withRekapBulan($tahun, $bulan)
            ->when($kelas_id, fn($q) => $q->where('kelas_id', $kelas_id))
            ->when($statusSelected !== 'Semua', function ($query) use ($statusSelected) {
                $query->where('status', $statusSelected);
            })
            ->get();

        $kelas = Kelas::all();

        return view('rekapitulasi-absensi', compact('siswa', 'kelas'));
    }
}
