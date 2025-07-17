<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        // ambil data login dari form login
        $data_user = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi!',
            'password.required' => 'Password wajib diisi!',
        ]);

        // Generate session ID baru
        $request->session()->regenerate();
        if (Auth::attempt($data_user)) {
            if (Auth::user()->role == 'Admin') {
                return redirect()->intended('admin/beranda');
            } elseif (Auth::user()->role == 'Guru') {
                return redirect()->intended('guru/absensi');
            } else {
                return redirect()->intended('/bk/beranda');
            }
        } else {
            return redirect('/')->with('Gagal', 'Username atau password yang kamu masukkan salah')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
