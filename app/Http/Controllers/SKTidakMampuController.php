<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SktmModel;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPengajuanModel;
use App\Models\RiwayatsktmModel;

class SKTidakMampuController extends Controller
{
    public function index()
    {
        $sktm = SktmModel::orderBy('created_at', 'desc')->paginate(8);
        // dd($sktm);
        return view('sktm.index', compact('sktm'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tujuan' => 'required',
            'jenis_kelamin' => 'required',
            'tempatLahir' => 'required',
            'tanggalLahir' => 'required|date',
            'agama' => 'required',
            'nik' => 'required',
            'alamat' => 'required',
            'keterangan' => 'required',
            'pengantar_rt_rw' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'surat_pernyataan' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        try {
            $data = $request->all();

            // $data['id'] = (string) Str::uuid(); // assign UUID karena PK string non-increment
            $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sktm');
            $data['kk'] = $request->file('kk')->store('sktm');
            $data['ktp'] = $request->file('ktp')->store('sktm');
            $data['surat_pernyataan'] = $request->file('surat_pernyataan')->store('sktm');
            $data['tanggal'] = now();
            $data['status'] = 'Diajukan';

            $sktm = SktmModel::create($data);

            RiwayatsktmModel::create([
                'sktm_id' => $sktm->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diajukan',
                'peninjau' => '-', // atau sesuaikan nama peninjau jika ada login user
                'keterangan' => 'Surat diajukan oleh pemohon',
                'surat_balasan' => null
            ]);

            return redirect()->back()->with('success', 'Data berhasil disimpan');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sktm =SktmModel::findOrFail($id);

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

            $sktm->update($validated);

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $sktm = SktmModel::with('riwayat_sktm')->findOrFail($id);
        return view('sktm.detail', compact('sktm'));
    }

    // public function verifikasi($id)
    // {
    //     try {
    //         $sktm = SktmModel::findOrFail($id);
    //         if ($sktm->status !== 'Diproses') {
    //         $sktm->status = 'Diproses';
    //         $sktm->save();
    //     }

    //         return redirect()->back()->with('success', 'Surat berhasil diverifikasi!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Gagal Verifikasi: ' . $e->getMessage());
    //     }
    // }


    // Method verifikasi
    // public function verifikasi($id)
    // {
    //     try {
    //         $sktm = SktmModel::findOrFail($id);
    //         $sktm->status = 'Diproses'; // Atau 'Diverifikasi', sesuaikan
    //         $sktm->save();

    //         // Tambah data riwayat
    //         RiwayatPengajuanModel::create([
    //             'sktm_id' => $sktm->id,
    //             'tanggal' => now()->toDateString(),
    //             'waktu' => now(),
    //             'status' => 'Diproses',
    //             'peninjau' => Auth::user()->name ?? 'Lurah',
    //             'keterangan' => 'Surat telah diverifikasi oleh Lurah',
    //             'surat_balasan' => null,
    //         ]);

    //         // return redirect()->back()->with('success', 'Surat berhasil diverifikasi.');
    //         return redirect()->route('sktm.show', $sktm->id)->with('success', 'Surat berhasil diverifikasi.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Terjadi kesalahan saat verifikasi: ' . $e->getMessage());
    //     }
    // }
public function verifikasi($id)
{
    try {
        $sktm = SktmModel::findOrFail($id);
        $user = Auth::user();

        // ADMIN MEMPROSES
         if (in_array($user->role, ['Admin', 'Sekretaris'])) {
            if ($sktm->status !== 'Diajukan') {
                return redirect()->back()->with('error', 'Surat tidak dalam status Diajukan.');
            }

            $sktm->status = 'Diproses';
            $sktm->save();

            RiwayatsktmModel::create([
                'sktm_id' => $sktm->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diproses',
                'peninjau' => $user->name ?? 'Admin',
                'keterangan' => 'Surat telah diverifikasi oleh Admin',
                'surat_balasan' => null,
            ]);

            return redirect()->route('sktm.show', $sktm->id)->with('success', 'Surat berhasil diverifikasi oleh Admin.');
        }

        // LURAH MENYELESAIKAN
        elseif ($user->role === 'Lurah') {
            if ($sktm->status !== 'Diproses') {
                return redirect()->back()->with('error', 'Surat belum diproses oleh Admin.');
            }

            $sktm->status = 'Selesai';
            $sktm->save();

            RiwayatsktmModel::create([
                'sktm_id' => $sktm->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Selesai',
                'peninjau' => $user->name ?? 'Lurah',
                'keterangan' => 'Surat telah disahkan oleh Lurah',
                'surat_balasan' => null,
            ]);

            return redirect()->route('sktm.show', $sktm->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses verifikasi.');
    } catch (\Exception $e) {
    dd($e->getMessage());
}
}


    public function cetak($id)
    {
        $sktm = SktmModel::findOrFail($id);

        // Logika untuk generate surat, bisa return view khusus cetak
        return view('sktm.cetak', compact('sktm'));
    }

    
    public function destroy($id)
    {
        // User::findOrFail($id)->delete();
        // return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
        try {
            $sktm = SktmModel::findOrFail($id);
            $sktm->delete();

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
