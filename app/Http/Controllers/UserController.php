<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.data-user.index', [
            'user' => User::orderBy('nama_lengkap', 'ASC')->get(),
        ]);
    }

    public function create() {
        return view('admin.data-user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'username' => 'required|unique:user',
            'password' => 'required',
            'role' => 'required|in:admin,guru,bk'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi!',
            'nama_lengkap.max' => 'Nama lengkap yang anda masukkan terlalu panjang!',

            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username tidak boleh sama!',

            'password.required' => 'Password wajib diisi!',

            'role.required' => 'Role wajib diisi!',
        ]);

        // jika password terisi maka enkripsikan password itu
        if ($request->password) {
            $validated_data['password'] = bcrypt($request->password);
        }

        User::create($validated_data);

        flash()->option('timeout', 3000)->addSuccess('Tambah Data User berhasil');

        return redirect()->route('data-user.index');
    }

    public function edit() {
        return view('admin.data-user.update');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrfail($id);

        $validated_data = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required|in:admin,guru,bk'
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi!',
            'nama_lengkap.max' => 'Nama lengkap yang anda masukkan terlalu panjang!',

            'username.required' => 'Username wajib diisi!',

            'password.required' => 'Password wajib diisi!',
            'role.required' => 'Role wajib diisi!',
        ]);

        if ($request->password) {
            $validated_data['password'] = bcrypt($request->password);
        }

        $user->update($validated_data);

        flash()->option('timeout', 3000)->addSuccess('Edit Data User Berhasil!');

        return redirect()->route('data-user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        flash()->option('timeout', 3000)->addSuccess('Hapus Data User Berhasil');

        return back();
    }
}
