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
        $dataMiskin = PendudukMiskinModel::where('status', 'Miskin')->orderBy('created_at', 'desc')->get();
        $dataMenengah = PendudukMiskinModel::where('status', 'Menengah')->orderBy('created_at', 'desc')->get();

        return view('pendudukMiskin.index', compact('dataMiskin', 'dataMenengah'));
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

        $data['status'] = 'Miskin';
        // dd($data); 
        if ($request->hasFile('foto_rumah')) {
            $data['foto_rumah'] = $request->file('foto_rumah')->store('pendudukMiskin', 'local');
        }

        PendudukMiskinModel::create($data);
        return redirect()->route('pendudukMiskin.peta')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|in:Menengah,Miskin',
        ]);

        $penduduk = PendudukMiskinModel::findOrFail($id);
        $penduduk->status = $request->status;
        $penduduk->save();

        return redirect()->route('pendudukMiskin.index')->with('success', 'Status penduduk berhasil diubah menjadi ' . $request->status . '.');
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
                'text' => $e->getMessage()
            ]);
        }
    }
}
