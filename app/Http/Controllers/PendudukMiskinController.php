<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PendudukMiskinModel;
use Illuminate\Support\Facades\Log;

class PendudukMiskinController extends Controller
{
    public function index()
    {
        // return view('penduduk_miskin');
        // $data = PendudukMiskinModel::orderBy('created_at', 'desc')->paginate(8);
    $data = PendudukMiskinModel::orderBy('created_at', 'desc')->get();
        return view('pendudukMiskin.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'nama_kepala_keluarga' => 'nullable|string',
            'jml_agt_keluarga' => 'required|integer',
            'kelompokPKH' => 'nullable|string',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'foto_rumah' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();
        
        

        if ($request->hasFile('foto_rumah')) {
            $data['foto_rumah'] = $request->file('foto_rumah')->store('pendudukMiskin', 'local');
        }

        PendudukMiskinModel::create($data);
        return redirect()->route('pendudukMiskin.peta')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
{
    try {
        $data = PendudukMiskinModel::findOrFail($id);

        $data->nama = $request->nama;
        $data->nama_kepala_keluarga = $request->nama_kepala_keluarga;
        $data->jml_agt_keluarga = $request->jml_agt_keluarga;
        $data->kelompokPKH = $request->kelompokPKH;
        $data->alamat = $request->alamat;

        if ($request->hasFile('foto_rumah')) {
            $file = $request->file('foto_rumah')->store('pendudukMiskin', 'local');
            $data->foto_rumah = $file;
        }

        $data->save();

        return redirect()->route('pendudukMiskin.index')->with('success', 'Data berhasil diperbarui');
    } catch (\Exception $e) {
        // Log jika perlu

        return redirect()->route('pendudukMiskin.index')->with('error', 'Terjadi kesalahan saat memperbarui data.');
    }
}

    public function show($id)
    {
        $pendudukMiskin = PendudukMiskinModel::findOrFail($id);
        return view('pendudukMiskin.detail', compact('pendudukMiskin'));
    }
    public function destroy($id)
    {
        // User::findOrFail($id)->delete();
        // return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
        try {
            $pendudukMiskin = pendudukMiskinModel::findOrFail($id);
            $pendudukMiskin->delete();

            // $this->forgetpendudukMiskin();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Delete Surat Keterangan Usaha',
                'text' => 'Data berhasil dihapus!'
            ]);

        } catch (Exception $e) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Delete Pengajuan',
                'text' => $e -> getMessage()
            ]);
        }
    }
    
}
