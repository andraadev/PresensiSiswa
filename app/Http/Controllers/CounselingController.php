<?php

namespace App\Http\Controllers;

use App\Http\Requests\CounselingFormRequest;
use App\Models\Counseling;
use App\Models\Siswa;
use Illuminate\Http\Request;

class CounselingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counseling = Counseling::with(['student', 'creator'])->get();
        return view('bk.counseling.index', compact('counseling'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $student = Siswa::all();
        return view('bk.counseling.create', compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CounselingFormRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        Counseling::create($validated);

        flash()->option('timeout', 3000)->addSuccess('Tambah Data Konseling Berhasil');

        return redirect()->route('konseling.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Counseling $counseling)
    {
        return view('bk.counseling.update', [
            'counseling' => $counseling,
            'student' => Siswa::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CounselingFormRequest $request, Counseling $counseling)
    {
        $counseling->update($request->validated());

        flash()->option('timeout', 3000)->addSuccess('Edit Data Konseling Berhasil');

        return redirect()->route('konseling.index');
    }
}
