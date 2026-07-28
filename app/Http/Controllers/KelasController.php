<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelasFormRequest;
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
    public function store(KelasFormRequest $request)
    {
        $qr_code_kelas = QRCode::format('png')
            ->size(500)
            ->margin(2)
            ->generate(route('absensi.index') . $slug_kelas);

        $output_file = 'qr_code_kelas/qr-' . $slug_kelas . '.png';

        Storage::disk('public')->put($output_file, $qr_code_kelas);

        $validated = $request->validated();

        $validated['slug_kelas'] = Str::slug($request->nama_kelas);
        $validated['qr_code'] = $output_file;

        Kelas::create($validated);

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Kelas Berhasil');
        return back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelasFormRequest $request, string $id)
    {
        $kelas = Kelas::findOrFail($id);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'updateKelas')
                ->withInput()
                ->with('edit_kelas_id', $id);
        }

        if ($validated_data['nama_kelas'] !== $kelas->nama_kelas) {
            $qr_code_kelas = QRCode::format('png')
                ->size(500)
                ->margin(2)
                ->generate(route('absensi.index') . $slug_kelas);

            $output_file = 'qr_code_kelas/qr-' . $slug_kelas . '.png';
            Storage::disk('public')->delete($kelas->qr_code);
            Storage::disk('public')->put($output_file, $qr_code_kelas);
        }

        $validated = $request->validated();

        $validated['slug_kelas'] = Str::slug($request->nama_kelas);
        $validated['qr_code'] = $output_file;

        $kelas->update($validated);

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
