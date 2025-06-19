<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DataPenggunaController extends Controller
{
        public function index()
    {
        // $users = User::all();
        $users = User::paginate(8);
        // $user = User::latest()->get();
        return view('dataPengguna.data_pengguna', compact('users'));
    }

    public function store(Request $request)
    {
        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan');
    }


   public function update(Request $request, $id)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role' => 'required|string',
        'password' => 'nullable|string|min:6',
    ]);

    $pengguna = User::findOrFail($id);
    $pengguna->username = $request->username;
    $pengguna->email = $request->email;
    if ($request->filled('password')) {
        $pengguna->password = Hash::make($request->password);
    }
    $pengguna->role = $request->role;
    $pengguna->save();

    return redirect()->route('data_pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
}


    public function destroy($id)
    {
        // User::findOrFail($id)->delete();
        // return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
        try {
            $user = User::findOrFail($id);
            $user->delete();

            // $this->forgetUser();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Delete Pengguna',
                'text' => 'Data berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Delete Pengguna',
                'text' => $e -> getMessage()
            ]);
        }
    }
}
