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
            'no_hp' => 'required|string|unique:users,no_hp',
            'password' => 'required|string|min:6',
        ]);

        // Simpan user ke database
        User::create([
            'username' => $request->username,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'Masyarakat',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');

    }
}
