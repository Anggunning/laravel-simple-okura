<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendudukMiskinModel;

class PendudukMiskinController extends Controller
{
    public function index()
    {
        // return view('penduduk_miskin');
         $pendudukMiskin = PendudukMiskinModel::latest()->get();
        return view('pendudukMiskin.penduduk_miskin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_kepala_keluarga' => 'required|string',
            'jml_agt_keluarga' => 'required|integer',
            'kelompokPKH' => 'nullable|string',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'foto_rumah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_rumah')) {
            $data['foto_rumah'] = $request->file('foto_rumah')->store('foto_rumah', 'public');
        }

        PendudukMiskinModel::create($data);
        return redirect()->route('penduduk.index')->with('success', 'Data berhasil ditambahkan.');
    }
    
}
