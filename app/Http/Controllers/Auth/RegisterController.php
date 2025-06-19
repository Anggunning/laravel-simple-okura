<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Simpan user ke database
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Masyarakat',
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
