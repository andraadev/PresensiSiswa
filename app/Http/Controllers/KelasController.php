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

        $qr_code_kelas = QRCode::format('png')->generate('http://localhost:8000/' . $slug_kelas);

        $output_file = '/qr_code_kelas/qr-' . $slug_kelas . '.png';

        Storage::disk('public')->put($output_file, $qr_code_kelas);

        Kelas::create([
            'slug_kelas' => $slug_kelas,
            'nama_kelas' => $validated_data['nama_kelas'],
            'guru_id' => $validated_data['guru_id'],
            'qr_code' => $output_file,
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

            $qr_code_kelas = QRCode::format('png')->generate('http://localhost:8000/' . $slug_kelas);

            $output_file = '/qr_code_kelas/qr-' . $slug_kelas . '.png';

            // hapus gambar sebelumnya
            Storage::disk('public')->delete($kelas->qr_code);

            // simpan gambar baru
            Storage::disk('public')->put($output_file, $qr_code_kelas);

            $kelas->update([
                'slug_kelas' => $slug_kelas,
                'nama_kelas' => $validated_data['nama_kelas'],
                'guru_id' => $validated_data['guru_id'],
                'qr_code' => $output_file,
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

        Storage::disk('public')->delete($kelas->qr_code);

        // flash message jika datanya berhasil dihapus
        flash()->option('timeout', 3000)->addSuccess('Hapus Data Kelas Berhasil');

        return back();
    }

    // fungsi download qrcode
    public function download_qr(Kelas $kelas)
    {
        return Storage::download($kelas->qr_code);
    }
}
