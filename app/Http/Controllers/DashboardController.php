<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
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

        // 2. Hitung total untuk badge header
        $totalKelas      = $statusKelas->count();
        $totalKelasSudah = $statusKelas->where('sudah_absen', true)->count();

        $header = "Beranda";

        return view('admin.beranda', compact('labels', 'data', 'user', 'guru', 'siswa', 'kelas', 'statusKelas', 'totalKelas', 'totalKelasSudah', 'header'));
    }

    public function beranda_bk()
    {
        $header = "Beranda";
        $siswa = Siswa::count('nama_lengkap');
        $jumlah_siswa = Siswa::rightJoin(DB::raw('(SELECT YEAR(created_at) AS year FROM siswa GROUP BY year) as years'), function ($join) {
            $join->on(DB::raw('YEAR(siswa.created_at)'), '=', 'years.year');
        })
            ->selectRaw('years.year as year, COALESCE(COUNT(siswa.id), 0) as count')
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->toArray(); // Mengubah koleksi menjadi array PHP biasa

        // Siapkan data untuk grafik
        $labels = array_column($jumlah_siswa, 'year'); // Label sumbu X berdasarkan tahun
        $data = array_map('intval', array_column($jumlah_siswa, 'count')); // Data jumlah siswa (konversi ke bilangan bulat)

        // Hitung jumlah siswa yang hadir, sakit, izin, dan alpa
        $statistik_siswa = Absensi::select(
            DB::raw('COUNT(IF(status = "Hadir", 1, NULL)) as hadir'),
            DB::raw('COUNT(IF(status = "Sakit", 1, NULL)) as sakit'),
            DB::raw('COUNT(IF(status = "Izin", 1, NULL)) as izin'),
            DB::raw('COUNT(IF(status = "Alpa", 1, NULL)) as alpa')
        )->first();

        // Kirim data grafik ke tampilan
        return view('bk.beranda', compact('jumlah_siswa', 'header', 'labels', 'data', 'siswa', 'statistik_siswa'));
    }

    /**
     * Display a listing of the resource.
     */
    public function data_absensi(Request $request)
    {
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');
        $kelas_id = $request->input('kelas_id');

        $absensi =  Absensi::when($tanggal_mulai, fn($q) => $q->where("tanggal_absensi", $tanggal_mulai))
            ->when($tanggal_selesai, fn($q) => $q->where("tanggal_absensi", $tanggal_selesai))
            ->when($kelas_id, fn($q) => $q->where('kelas_id', $kelas_id))
            ->get();

        $kelas = Kelas::all();

        return view('data-absensi', compact('absensi', 'kelas'));
    }

    public function rekapitulasi_absensi(Request $request)
    {

        $bulan = $request->bulan ?? date('Y-m');
        $kelas_id = $request->kelas_id ?? null;

        [$tahun, $bulan] = explode('-', $bulan);

        $siswa = Siswa::with(['kelas'])
            ->withRekapBulan($tahun, $bulan)
            ->when($kelas_id, fn($q) => $q->where('kelas_id', $kelas_id))
            ->get();

        $kelas = Kelas::all();

        return view('rekapitulasi-absensi', compact('siswa', 'kelas'));
    }
}
