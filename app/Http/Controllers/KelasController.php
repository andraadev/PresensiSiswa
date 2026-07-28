<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        $validated_data = $request->validateWithBag('storeKelas', [
            'nama_kelas' => 'required|max:20',
            'guru_id' => 'required|integer|exists:guru,id'
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'nama_kelas.max' => 'Nama kelas tidak boleh lebih dari 20 karakter',
            'guru_id.required' => 'Opsi wali kelas tidak boleh kosong!',
            'guru_id.exists' => 'Silakan pilih wali kelas yang tersedia.'
        ]);

        $slug_kelas = Str::slug($request->nama_kelas);

        $qr_code_kelas = QRCode::format('png')
            ->size(500)
            ->margin(2)
            ->generate(route('absensi.index') . $slug_kelas);

        $output_file = 'qr_code_kelas/qr-' . $slug_kelas . '.png';

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
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|max:20',
            'guru_id' => 'required|integer|exists:guru,id'
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'nama_kelas.max' => 'Nama kelas tidak boleh lebih dari 20 karakter',
            'guru_id.required' => 'Opsi wali kelas tidak boleh kosong!',
            'guru_id.exists' => 'Silakan pilih wali kelas yang tersedia.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'updateKelas')
                ->withInput()
                ->with('edit_kelas_id', $id);
        }

        $validated_data = $validator->validated();

        // jika nama kelas yang dimasukkan tidak sama dengan nama kelas yang ada di database
        if ($validated_data['nama_kelas'] !== $kelas->nama_kelas) {

            $slug_kelas = Str::slug($request->nama_kelas);
            $qr_code_kelas = QRCode::format('png')
                ->size(500)
                ->margin(2)
                ->generate(route('absensi.index') . $slug_kelas);

            $output_file = 'qr_code_kelas/qr-' . $slug_kelas . '.png';

            Storage::disk('public')->delete($kelas->qr_code);

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

    public function download_qr(Kelas $kelas)
    {
        $fullPath = storage_path('app/public/' . $kelas->qr_code);

        if (!$kelas->qr_code || !file_exists($fullPath) || !is_readable($fullPath)) {
            flash()->option('timeout', 3000)->addError('File QR tidak ditemukan atau tidak dapat diakses.');
            return back();
        }

        return response()->download($fullPath);
    }
}
