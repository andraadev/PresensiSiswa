<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.data-user.index', [
            'header' => 'Data User',
            'user' => User::orderBy('nama_lengkap', 'ASC')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.data-user.create', [
            'header' => 'Tambah Data User',
            'data_guru' => Guru::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:Admin,Guru,BK',
            'guru_id' => 'nullable|required_if:role,Guru|exists:guru,id|unique:user,guru_id',
            'nama_lengkap' => 'nullable|required_if:role,Admin,BK|string|max:100',
            'username' => 'nullable|required_if:role,Admin,BK|string|max:50|unique:user,username',
            'password' => 'required|min:8',
        ], [
            'role.required' => 'Role wajib dipilih!',
            'role.in' => 'Pilihan role tidak valid!',

            'guru_id.required_if' => 'Data guru wajib dipilih jika role adalah Guru!',
            'guru_id.exists' => 'Data guru yang dipilih tidak ditemukan di sistem!',
            'guru_id.unique' => 'Guru ini sudah memiliki akun user!',

            'nama_lengkap.required_if' => 'Nama lengkap wajib diisi!',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter!',

            'username.required_if' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah digunakan, cari username lain!',
            'username.max' => 'Username maksimal 50 karakter!',

            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal harus 8 karakter!',
        ]);

        if ($request->role === 'Guru') {
            $guru = Guru::findOrFail($request->guru_id);
            $namaLengkap = $guru->nama_lengkap;
            $username = $guru->nip;
        } else {
            $namaLengkap = $request->nama_lengkap;
            $username = $request->username;
        }

        User::create([
            'role'         => $request->role,
            'guru_id'      => $request->role === 'Guru' ? $request->guru_id : null,
            'nama_lengkap' => $namaLengkap,
            'username'     => $username,
            'password'     => Hash::make($request->password),
        ]);

        flash()->addSuccess('Tambah Data User baru berhasil');

        return redirect()->to(route('data-user.index'));
    }

    public function edit(string $id)
    {
        $guru = Guru::all();
        $user = User::findOrfail($id);
        return view('admin.data-user.update', [
            'header' => 'Edit Data User',
            'data_guru' => $guru,
            'data_user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrfail($id);

        $request->validate([
            'role' => 'required|in:Admin,Guru,BK',
            'guru_id' => 'nullable|required_if:role,Guru|exists:guru,id|unique:user,guru_id,' . $id,
            'nama_lengkap' => 'nullable|required_if:role,Admin,BK|string|max:100',
            'username' => 'nullable|required_if:role,Admin,BK|string|max:50|unique:user,username,' . $id,
            'password' => 'nullable|min:8',
        ], [
            'role.required' => 'Role wajib dipilih!',
            'role.in' => 'Pilihan role tidak valid!',

            'guru_id.required_if' => 'Data guru wajib dipilih jika role adalah Guru!',
            'guru_id.exists' => 'Data guru yang dipilih tidak ditemukan di sistem!',
            'guru_id.unique' => 'Guru ini sudah memiliki akun user!',

            'nama_lengkap.required_if' => 'Nama lengkap wajib diisi!',
            'nama_lengkap.max' => 'Nama lengkap maksimal 100 karakter!',

            'username.required_if' => 'Username wajib diisi!',
            'username.unique' => 'Username sudah digunakan, cari username lain!',
            'username.max' => 'Username maksimal 50 karakter!',

            'password.required' => 'Password wajib diisi!',
            'password.min' => 'Password minimal harus 8 karakter!',
        ]);

        if ($request->role === 'Guru') {
            $guru = Guru::findOrFail($request->guru_id);
            $namaLengkap = $guru->nama_lengkap;
            $username = $guru->nip;
        } else {
            $namaLengkap = $request->nama_lengkap;
            $username = $request->username;
        }

        $user->update([
            'role'         => $request->role,
            'guru_id'      => $request->role === 'Guru' ? $request->guru_id : null,
            'nama_lengkap' => $namaLengkap,
            'username'     => $username,
            'password'     => $request->filled('password') ? Hash::make($request->password) : $user['password'],
        ]);

        flash()->addSuccess('Edit Data User Berhasil!');

        return redirect()->to(route('data-user.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        flash()->addSuccess('Hapus Data User Berhasil');

        return redirect()->to(route('data-user.index'));
    }
}
