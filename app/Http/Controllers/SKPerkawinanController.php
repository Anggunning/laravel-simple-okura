<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SkpModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrangTuaModel;
use App\Models\RiwayatskpModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusPerkawinanModel;

class SKPerkawinanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'Masyarakat') {
            $skp = SkpModel::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            // dd("User ID: " . $user->id, $skp); // Untuk cek isi data
        } else {
            $skp = SkpModel::all();
        }

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
            'status_kawin' => 'required|in:Belum Menikah,Cerai Mati,Cerai Hidup',
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

            // 1. Simpan data status perkawinan
            $statusPerkawinan = StatusPerkawinanModel::create([
                'id' => Str::uuid(),
                'status_kawin' => $request->status_kawin,
                'jenis_kelamin_psgn_dulu' => in_array($request->status_kawin, ['Cerai Hidup', 'Cerai Mati'])
                    ? ($request->jenis_kelamin === 'Laki-laki' ? 'Perempuan' : 'Laki-laki')
                    : null,
                'nama_pasangan_dulu' => in_array($request->status_kawin, ['Cerai Hidup', 'Cerai Mati'])
                    ? $request->nama_pasangan_dulu
                    : null,
            ]);

            // 2. Upload file
            $data['ktp'] = $request->file('ktp')->store('sktm');
            $data['kk'] = $request->file('kk')->store('sktm');
            $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sktm');
            $data['foto'] = $request->file('foto')->store('sktm');
            $data['user_id'] = auth()->id();
            // 3. Cek duplikat NIK
            if (SkpModel::where('nik', $request->nik)->exists()) {
                return redirect()->back()->withInput()->withErrors(['nik' => 'NIK sudah pernah digunakan.']);
            }

            // 4. Simpan data SKP (sementara belum isi orang_tua)
            $skp = SkpModel::create([
                'id' => Str::uuid(),
                'user_id' => auth()->id(),
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'kewarganegaraan' => $request->kewarganegaraan,
                'pekerjaan' => $request->pekerjaan,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'status_kawin' => $request->status_kawin,
                'ktp' => $data['ktp'],
                'kk' => $data['kk'],
                'pengantar_rt_rw' => $data['pengantar_rt_rw'],
                'foto' => $data['foto'],
                'status_perkawinan_id' => $statusPerkawinan->id,
                'status' => 'Diajukan',
                'created_at' => now(),
                'updated_at' => now(),

            ]);
            
            // 5. Simpan data orang tua dan kaitkan ke SKP
            $orangTua = OrangTuaModel::create([
                'id' => Str::uuid(),
                'nama_ayah' => $request->nama_ayah,
                'nik_ayah' => $request->nik_ayah,
                'tempat_lahir_ayah' => $request->tempat_lahir_ayah,
                'tanggal_lahir_ayah' => $request->tanggal_lahir_ayah,
                'agama_ayah' => $request->agama_ayah,
                'kewarganegaraan_ayah' => $request->kewarganegaraan_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'alamat_ayah' => $request->alamat_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                'agama_ibu' => $request->agama_ibu,
                'kewarganegaraan_ibu' => $request->kewarganegaraan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'skp_id' => $skp->id,
            ]);
            
            
            // 6. Simpan riwayat pengajuan
            RiwayatskpModel::create([
                'skp_id' => $skp->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diajukan',
                'peninjau' => '-',
                'keterangan' => 'Surat diajukan oleh pemohon',
            ]);
            
            
            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
    dd($e->getMessage()); 
        }
    }

public function update(Request $request, $id)
{
    try {
        // 1. Validasi input
        $validated = $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required',
            'pekerjaan' => 'required',
            'status_kawin' => 'required|in:Belum Menikah,Cerai Mati,Cerai Hidup',
            'alamat' => 'required',
            'kewarganegaraan' => 'required',
            'keterangan' => 'nullable',

            // Dokumen
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'pengantar_rt_rw' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Data Orang Tua
            'nama_ayah' => 'required',
            'nik_ayah' => 'required',
            'agama_ayah' => 'required',
            'kewarganegaraan_ayah' => 'required',
            'pekerjaan_ayah' => 'required',
            'alamat_ayah' => 'required',
            'nama_ibu' => 'required',
            'nik_ibu' => 'required',
            'agama_ibu' => 'required',
            'kewarganegaraan_ibu' => 'required',
            'pekerjaan_ibu' => 'required',
            'alamat_ibu' => 'required',
        ]);

        // 2. Ambil data SKP
        $skp = SkpModel::findOrFail($id);

        // 3. Update Status Perkawinan
        if ($skp->status_perkawinan_id) {
            $statusPerkawinan = StatusPerkawinanModel::find($skp->status_perkawinan_id);
            if ($statusPerkawinan) {
                $statusPerkawinan->update([
                    'status_kawin' => $request->status_kawin,
                    'jenis_kelamin_psgn_dulu' => in_array($request->status_kawin, ['Cerai Hidup', 'Cerai Mati'])
                        ? ($request->jenis_kelamin === 'Laki-laki' ? 'Perempuan' : 'Laki-laki')
                        : null,
                    'nama_pasangan_dulu' => in_array($request->status_kawin, ['Cerai Hidup', 'Cerai Mati'])
                        ? $request->nama_pasangan_dulu
                        : null,
                ]);
            }
        }

        // 4. Upload file jika ada
        foreach (['ktp', 'kk', 'pengantar_rt_rw', 'foto'] as $file) {
            if ($request->hasFile($file)) {
                $validated[$file] = $request->file($file)->store('sktm');
            }
        }

        // 5. Update SKP
        $skp->update($validated);

        // 6. Update Orang Tua (gunakan relasi atau pencarian manual)
        if ($skp->orangTua) {
            $skp->orangTua->update([
                'nama_ayah' => $request->nama_ayah,
                'nik_ayah' => $request->nik_ayah,
                'agama_ayah' => $request->agama_ayah,
                'kewarganegaraan_ayah' => $request->kewarganegaraan_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'alamat_ayah' => $request->alamat_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'agama_ibu' => $request->agama_ibu,
                'kewarganegaraan_ibu' => $request->kewarganegaraan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'alamat_ibu' => $request->alamat_ibu,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    } catch (\Exception $e) {
        \Log::error('Update SKP error: ' . $e->getMessage());
        return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
    }
}




    public function show($id)
    {
        $skp = SkpModel::with(['riwayat_skp', 'orangTua', 'status_perkawinan'])->findOrFail($id);

        return view('skp.detail', compact('skp'));
    }

    public function verifikasi($id)
    {
        try {
            $skp = skpModel::findOrFail($id);
            $user = Auth::user();

            // ADMIN MEMPROSES
            if (in_array($user->role, ['Admin', 'Sekretaris'])) {
                if ($skp->status !== 'Diajukan') {
                    return redirect()->back()->with('error', 'Surat tidak dalam status Diajukan.');
                }

                $skp->status = 'Diproses';
                $skp->save();

                RiwayatskpModel::create([
                    'skp_id' => $skp->id,
                    'tanggal' => now()->toDateString(),
                    'waktu' => now(),
                    'status' => 'Diproses',
                    'peninjau' => $user->role,
                    'keterangan' => 'Surat telah diverifikasi oleh Admin',
                    'surat_balasan' => null,
                ]);

                return redirect()->route('skp.show', $skp->id)->with('success', 'Surat berhasil diverifikasi oleh Admin.');
            }

            // LURAH MENYELESAIKAN
            elseif ($user->role === 'Lurah') {
                if ($skp->status !== 'Diproses') {
                    return redirect()->back()->with('error', 'Surat belum diproses oleh Admin.');
                }

                $skp->status = 'Selesai';
                $skp->save();

                RiwayatskpModel::create([
                    'skp_id' => $skp->id,
                    'tanggal' => now()->toDateString(),
                    'waktu' => now(),
                    'status' => 'Selesai',
                    'peninjau' => $user->name ?? 'Lurah',
                    'keterangan' => 'Surat telah disahkan oleh Lurah',
                    'surat_balasan' => null,
                ]);

                return redirect()->route('skp.show', $skp->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
            }

            return redirect()->back()->with('error', 'Anda tidak memiliki akses verifikasi.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }


    public function cetak($id)
    {
        // $sku = SkuModel::findOrFail($id);

        // // Logika untuk generate surat, bisa return view khusus cetak
        // return view('sku.cetak', compact('sku'));
         $skp = SkpModel::findOrFail($id);

    if ($skp->status !== 'Selesai') {
        abort(403, 'Surat hanya bisa dicetak jika statusnya Selesai.');
    }

    $pdf = Pdf::loadView('skp.cetak', compact('skp'));

    return $pdf->stream("skp-{$skp->nama}.pdf"); // akan tampil di tab baru
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
                'text' => $e->getMessage()
            ]);
        }
    }
}
