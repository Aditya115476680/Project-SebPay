<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Kalau sudah login, langsung redirect ke dashboard
        if (Session::get('login')) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        // Cek user dan password (pastikan password di-hash)
        if ($user && Hash::check($request->password, $user->password)) {
            // Simpan ke session
            Session::put('login', true);
            Session::put('user_id', $user->id_user);
            Session::put('username', $user->username);
            Session::put('nama_user', $user->nama_user);

            return redirect('/dashboard');
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
