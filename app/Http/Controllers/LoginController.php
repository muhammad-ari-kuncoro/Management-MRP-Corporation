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
        $data['title_header'] = 'Login Page MRP System';
        return view('auth.login',$data);
    }

    public function authenticate(Request $request)
    {
       // 1. Validasi Input
       $validateData = $request->validate([
        'email' => 'required|email|min:5|max:20', // Ditambahkan 'email' rule
        'password' => 'required|min:5|max:20'
     ]);

    // 2. Mencoba Autentikasi
    if (Auth::attempt($validateData)) {
        $request->session()->regenerate();
        // Mendapatkan data pengguna yang baru login
        $user = Auth::user();
        // 3. Logika Pengalihan Berdasarkan Peran (Role)
        if ($user->user_role === 'superadmin') {
            // Jika superadmin, arahkan ke halaman khusus superadmin (misalnya, 'superadmin/dashboard')
            return redirect()->intended('/dashboard');

        } elseif ($user->user_role === 'purchasing') {
            // Jika admin biasa, arahkan ke dashboard admin standar
            return redirect()->intended('admin/dashboard');

        } else {
            // Untuk peran 'user' atau peran lainnya, arahkan ke dashboard umum
            return redirect()->intended('dashboard');
        }
    }

    // Jika autentikasi gagal
    return back()->with('loginError', 'Login Failed. Cek kembali email dan password Anda.');
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
