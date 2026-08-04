<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
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
            'user' => User::orderBy('nama_lengkap', 'ASC')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.data-user.create', [
            'data_guru' => Guru::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        if ($request->role === 'Guru') {
            $guru = Guru::findOrFail($request->guru_id);

            $payload = [
                'role'         => 'Guru',
                'guru_id'      => $guru->id,
                'nama_lengkap' => $guru->nama_lengkap,
                'username'     => $guru->nip, // Menggunakan NIP sebagai username bawaan
                'password'     => Hash::make($request->password),
            ];
        } else {
            $payload = [
                'role'         => $request->role,
                'guru_id'      => null,
                'nama_lengkap' => $request->nama_lengkap,
                'username'     => $request->username,
                'password'     => Hash::make($request->password),
            ];
        }

        // dd($payload);

        User::create($payload);

        flash()->addSuccess('Data User baru berhasil ditambahkan');

        return redirect()->to(route('data-user.index'));
    }

    public function edit(User $user)
    {
        return view('admin.data-user.update', [
            'data_user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, User $user)
    {
        // Preventing Admins from Changing Their Own Roles
        if ($user->id === auth()->id() && $request->has('role') && $request->role !== $user->role) {
            flash()->addError('Anda tidak dapat mengubah role akun Anda sendiri!');
            return back();
        }

        $payload = [];

        if ($user->role === 'Guru') {
            if ($request->filled('password')) {
                $payload['password'] = Hash::make($request->password);
            }
        } else {
            $payload = [
                'role'         => $request->role,
                'nama_lengkap' => $request->nama_lengkap,
                'username'     => $request->username,
            ];

            if ($request->filled('password')) {
                $payload['password'] = Hash::make($request->password);
            }
        }

        if (!empty($payload)) {
            $user->update($payload);
        }

        flash()->addSuccess("Data {$user->nama_lengkap} Berhasil Diedit!");
        return redirect()->to(route('data-user.index'));
    }

    /**
     * Toggle active status of the specified user.
     */
    public function update_status(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        // Preventing the Admin from deactivating themselves
        if ($user->id === auth()->id() && !$request->is_active) {
            flash()->addError('Anda tidak dapat menonaktifkan akun Anda sendiri yang sedang digunakan!');
            return back();
        }

        $user->update($validated);
        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        flash()->option('timeout', 3000)->addSuccess("Data user {$user->nama_lengkap} berhasil {$statusText}!");
        return redirect()->route('data-user.index');
    }
}
