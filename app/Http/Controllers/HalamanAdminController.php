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

class HalamanAdminController extends Controller
{
    // public function beranda()
    // {
    //     $user =  User::count('nama_lengkap');
    //     $guru = Guru::count('nama_lengkap');
    //     $siswa = Siswa::count('nama_lengkap');
    //     $kelas = Kelas::count('nama_kelas');
    //     $jumlah_siswa = Siswa::rightJoin(DB::raw('(SELECT YEAR(created_at) AS year FROM siswa GROUP BY year) as years'), function ($join) {
    //         $join->on(DB::raw('YEAR(siswa.created_at)'), '=', 'years.year');
    //     })
    //         ->selectRaw('years.year as year, COALESCE(COUNT(siswa.id), 0) as count')
    //         ->groupBy('year')
    //         ->orderBy('year')
    //         ->get();

    //     $jumlah_user = User::select('role', DB::raw('COUNT(*) as count'))
    //         ->whereIn('role', ['guru', 'BK']) // Filter hanya untuk role 'guru' dan 'BK'
    //         ->groupBy('role')
    //         ->get()
    //         ->pluck('count', 'role')
    //         ->toArray();

    //     // Konversi nilai menjadi bilangan bulat
    //     $jumlah_siswa = array_map('intval', $jumlah_siswa);

    //     // Siapkan data untuk grafik
    //     $labels = $jumlah_siswa->pluck('year')->toArray(); // Label sumbu X berdasarkan tahun
    //     $data = $jumlah_siswa->pluck('count')->toArray(); // Data jumlah siswa

    //     // Kirim data grafik ke tampilan
    //     return view('admin.beranda', compact('labels', 'data', 'user', 'guru', 'siswa', 'kelas', 'jumlah_user'));
    // }
    public function beranda()
    {
        $user =  User::count('nama_lengkap');
        $guru = Guru::count('nama_lengkap');
        $siswa = Siswa::count('nama_lengkap');
        $kelas = Kelas::count('nama_kelas');
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

        $jumlah_user = User::select('role', DB::raw('COUNT(*) as count'))
            ->whereIn('role', ['guru', 'BK']) // Filter hanya untuk role 'guru' dan 'BK'
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        // Siapkan data untuk grafik pie
        $pieLabels = array_keys($jumlah_user);
        $pieData = array_values($jumlah_user);

        // Kirim data grafik ke tampilan
        return view('admin.beranda', compact('labels', 'data', 'user', 'guru', 'siswa', 'kelas', 'pieLabels', 'pieData'));
    }

    /**
     * Display a listing of the resource.
     */
    public function data_absensi()
    {
        return view('admin.data-absensi', [
            'header' => 'Data Absensi',
            'absensi' => Absensi::all(),
            'siswa' => Siswa::all(),
            'kelas' => Kelas::all()
        ]);
    }

    public function filter_data_absensi(Request $request)
    {
        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');
        $kelas = Kelas::all();
        $header = "Data Absensi";

        $kelas_id = $request->input('kelas_id');

        // Query untuk mengambil data absensi dengan filter tanggal mulai, tanggal selesai, dan kelas
        $absensi = Absensi::whereDate('created_at', '>=', $tanggal_mulai)
            ->whereDate('created_at', '<=', $tanggal_selesai)
            ->when($kelas_id, function ($query) use ($kelas_id) {
                return $query->where('kelas_id', $kelas_id);
            })
            ->get();
        return view('admin.data-absensi', compact('absensi', 'kelas', 'header'));
    }
}
