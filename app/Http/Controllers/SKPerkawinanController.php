<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SkpModel;
use Illuminate\Http\Request;
use App\Models\RiwayatskpModel;
use Illuminate\Support\Facades\Auth;

class SKPerkawinanController extends Controller
{
    public function index()
    {
        $skp = SkpModel::orderBy('created_at', 'desc')->paginate(8);
        // dd($skp);
        return view('skp.index', compact('skp'));
    }
    public function store(Request $request)
{
    $request->validate([
        // Data Pemohon
        'nama' => 'required',
        'nik' => 'required',
        'jenis_kelamin' => 'required',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|date',
        'agama' => 'required',
        'pekerjaan' => 'required',
        'status_kawin' => 'required',
        'alamat' => 'required',
        'kewarganegaraan' => 'required',
        'keterangan' => 'nullable',

        // Dokumen
        'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf',
        'kk' => 'required|file|mimes:jpg,jpeg,png,pdf',
        'pengantar_rt_rw' => 'required|file|mimes:jpg,jpeg,png,pdf',
        'foto' => 'required|file|mimes:jpg,jpeg,png,pdf',

        // Data Orang Tua - Ayah
        'nama_ayah' => 'required',
        'nik_ayah' => 'required',
        'agama_ayah' => 'required',
        'kewarganegaraan_ayah' => 'required',
        'pekerjaan_ayah' => 'required',
        'alamat_ayah' => 'required',

        // Data Orang Tua - Ibu
        'nama_ibu' => 'required',
        'nik_ibu' => 'required',
        'agama_ibu' => 'required',
        'kewarganegaraan_ibu' => 'required',
        'pekerjaan_ibu' => 'required',
        'alamat_ibu' => 'required',
    ]);

    try {
        $data = $request->all();

        // Upload File
        $data['ktp'] = $request->file('ktp')->store('sktm');
        $data['kk'] = $request->file('kk')->store('sktm');
        $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sktm');
        $data['foto'] = $request->file('foto')->store('sktm');

        // Tanggal dan status default
        $data['tanggal'] = now();
        $data['status'] = 'Diajukan';

        // Simpan ke database
        $skp = SkpModel::create($data);

        // Riwayat
        RiwayatSkpModel::create([
            'sktm_id' => $skp->id,
            'tanggal' => now()->toDateString(),
            'waktu' => now(),
            'status' => 'Diajukan',
            'peninjau' => '-',
            'keterangan' => 'Surat diajukan oleh pemohon',
            'surat_balasan' => null
        ]);

        return redirect()->back()->with('success', 'Data berhasil disimpan');
     } catch (\Exception $e) {
    dd($e->getMessage());
}
}


    public function update(Request $request, $id)
    {
        try {
            $skp =SkpModel::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'tujuan' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string',
                'tempatLahir' => 'required|string|max:255',
                'tanggalLahir' => 'required|date',
                'agama' => 'required|string|max:255',
                'nik' => 'required|string|max:20',
                'alamat' => 'required|string',
                'keterangan' => 'required|string',
                'pengantar_rt_rw' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'surat_pernyataan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            if ($request->hasFile('pengantar_rt_rw')) {
                $validated['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('dokumen');
            }
            if ($request->hasFile('kk')) {
                $validated['kk'] = $request->file('kk')->store('dokumen');
            }
            if ($request->hasFile('ktp')) {
                $validated['ktp'] = $request->file('ktp')->store('dokumen');
            }
            if ($request->hasFile('surat_pernyataan')) {
                $validated['surat_pernyataan'] = $request->file('surat_pernyataan')->store('dokumen');
            }

            $skp->update($validated);

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }



    public function show($id)
    {
        $skp = SkpModel::with('riwayat_skp')->findOrFail($id);
        return view('skp.detail', compact('skp'));
    }
    public function verifikasi($id)
{
    try {
        $skp = SkpModel::findOrFail($id);
        $user = Auth::user();

        // ADMIN MEMPROSES
         if (in_array($user->role, ['Admin', 'Sekretaris'])) {
            if ($skp->status !== 'Diajukan') {
                return redirect()->back()->with('error', 'Surat tidak dalam status Diajukan.');
            }

            $skp->status = 'Diproses';
            $skp->save();

            RiwayatskpModel::create([
                'sktm_id' => $skp->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diproses',
                'peninjau' => $user->name ?? 'Admin',
                'keterangan' => 'Surat telah diverifikasi oleh Admin',
                'surat_balasan' => null,
            ]);

            return redirect()->route('sktm.show', $skp->id)->with('success', 'Surat berhasil diverifikasi oleh Admin.');
        }

        // LURAH MENYELESAIKAN
        elseif ($user->role === 'Lurah') {
            if ($skp->status !== 'Diproses') {
                return redirect()->back()->with('error', 'Surat belum diproses oleh Admin.');
            }

            $skp->status = 'Selesai';
            $skp->save();

            RiwayatSkpModel::create([
                'sktm_id' => $skp->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Selesai',
                'peninjau' => $user->name ?? 'Lurah',
                'keterangan' => 'Surat telah disahkan oleh Lurah',
                'surat_balasan' => null,
            ]);

            return redirect()->route('sktm.show', $skp->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses verifikasi.');
    } catch (\Exception $e) {
    dd($e->getMessage());
}
}


    public function cetak($id)
    {
        $skp = SkpModel::findOrFail($id);

        // Logika untuk generate surat, bisa return view khusus cetak
        return view('sktm.cetak', compact('sktm'));
    }

    
    public function destroy($id)
    {
        // User::findOrFail($id)->delete();
        // return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
        try {
            $skp = SkpModel::findOrFail($id);
            $skp->delete();

            // $this->forgetsktm();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Delete Surat Keterangan Tidak Mampu',
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


