<?php

namespace App\Http\Controllers;

use App\Models\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // 1. Validasi Input
        $validateData = $request->validate([
            'email' => 'required|email|min:5|max:20',
            'password' => 'required|min:5|max:20',
        ]);

// 2. Mencoba Autentikasi
    if (Auth::attempt($validateData)) {
        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->user_role === 'superadmin') {
            return redirect()->intended('/dashboard');
        } elseif ($user->user_role === 'purchasing') {
            return redirect()->intended('admin/dashboard');
        } else {
            return redirect()->intended('dashboard');
        }
    }

    // --- TAMBAHKAN INI JIKA LOGIN GAGAL ---
    // Mengembalikan user ke halaman login dengan pesan error
    return back()->with('loginError', 'Login Gagal! Username atau password salah.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Login $login)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Login $login)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Login $login)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Login $login)
    {
        //
    }
}
