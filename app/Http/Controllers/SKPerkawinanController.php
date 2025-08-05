<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SkpModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\OrangTuaModel;
use App\Models\RiwayatskpModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusPerkawinanModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SKPerkawinanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $drafToLoad = null;

        if ($request->has('draf')) {
            $drafToLoad = SkpModel::where('id', $request->get('draf'))
                ->where('status', 'draf')
                ->where('user_id', $user->id)
                ->first();
        }


        if ($user->role === 'Masyarakat') {
            // Belum Selesai: status bukan 'Selesai' atau 'Ditolak' (misalnya: Diajukan, Diproses)
            $skpBelumSelesai = SkpModel::with(['statusPerkawinan', 'orangTua', 'riwayat_skp'])
                ->whereNotIn('status', ['Selesai', 'Ditolak', 'draf'])
                ->get()
                ->sort(function ($a, $b) {
                    $aPrioritas = $a->status === 'Diajukan' && \Carbon\Carbon::parse($a->created_at)->lt(now()->subDays(3)) ? 2 : 0;
                    $bPrioritas = $b->status === 'Diajukan' && \Carbon\Carbon::parse($b->created_at)->lt(now()->subDays(3)) ? 2 : 0;

                    if ($aPrioritas === 0 && $bPrioritas === 0) {
                        $aPrioritas = $a->status === 'Diajukan' ? 1 : 0;
                        $bPrioritas = $b->status === 'Diajukan' ? 1 : 0;
                    }

                    return $bPrioritas <=> $aPrioritas ?: strtotime($b->created_at) <=> strtotime($a->created_at);
                })
                ->values();

            $skpSelesai = SkpModel::with(['statusPerkawinan', 'orangTua', 'riwayat_skp'])
                ->where('status', 'Selesai')
                ->orderBy('created_at', 'desc')
                ->get();

            $skpDitolak = SkpModel::with(['statusPerkawinan', 'orangTua', 'riwayat_skp'])
                ->where('status', 'Ditolak')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'Lurah') {
            // Lurah: hanya lihat Diproses, Selesai, Ditolak
            $skpBelumSelesai = SkpModel::where('status', 'Diproses')->orderBy('created_at', 'desc')->get();
            $skpSelesai = SkpModel::where('status', 'Selesai')->orderBy('created_at', 'desc')->get();
            $skpDitolak = SkpModel::where('status', 'Ditolak')->orderBy('created_at', 'desc')->get();
        } else {
            $skpBelumSelesai = SkpModel::with(['statusPerkawinan', 'orangTua', 'riwayat_skp'])
                ->whereNotIn('status', ['Selesai', 'Ditolak', 'draf'])
                ->get()
                ->sort(function ($a, $b) {
                    $aPrioritas = $a->status === 'Diajukan' && \Carbon\Carbon::parse($a->created_at)->lt(now()->subDays(3)) ? 2 : 0;
                    $bPrioritas = $b->status === 'Diajukan' && \Carbon\Carbon::parse($b->created_at)->lt(now()->subDays(3)) ? 2 : 0;

                    if ($aPrioritas === 0 && $bPrioritas === 0) {
                        $aPrioritas = $a->status === 'Diajukan' ? 1 : 0;
                        $bPrioritas = $b->status === 'Diajukan' ? 1 : 0;
                    }

                    return $bPrioritas <=> $aPrioritas ?: strtotime($b->created_at) <=> strtotime($a->created_at);
                })
                ->values();

            $skpSelesai = SkpModel::with(['statusPerkawinan', 'orangTua', 'riwayat_skp'])
                ->where('status', 'Selesai')
                ->orderBy('created_at', 'desc')
                ->get();

            $skpDitolak = SkpModel::with(['statusPerkawinan', 'orangTua', 'riwayat_skp'])
                ->where('status', 'Ditolak')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('skp.index', compact('skpBelumSelesai', 'skpSelesai', 'skpDitolak', 'drafToLoad'));
    }

    public function store(Request $request)
    {

        $request->validate([
            // Data Pemohon
            'nama' => 'required|string',
            'nik' => 'required|digits:16',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string',
            'pekerjaan' => 'required|string',
            'status_kawin' => 'required|in:Belum Menikah,Cerai Mati,Cerai Hidup',
            'alamat' => 'required|string',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
            'kewarganegaraan' => 'required|string',
            // 'keterangan' => 'required|string',


            // Dokumen
            'pengantar_rt_rw' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'foto' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',

            // Data Orang Tua - Ayah
            'nama_ayah' => 'required|string',
            'nik_ayah' => 'required|digits:16',
            'tempat_lahir_ayah' => 'required|string',
            'tanggal_lahir_ayah' => 'required|string|date',
            'agama_ayah' => 'required|string',
            'kewarganegaraan_ayah' => 'required|string',
            'pekerjaan_ayah' => 'required|string',
            'alamat_ayah' => 'required|string',
            'rt_ayah' => 'required|max:3',
            'rw_ayah' => 'required|max:3',

            // Data Orang Tua - Ibu
            'nama_ibu' => 'required|string',
            'nik_ibu' => 'required|digits:16',
            'tempat_lahir_ibu' => 'required|string',
            'tanggal_lahir_ibu' => 'required|string|date',
            'agama_ibu' => 'required|string',
            'kewarganegaraan_ibu' => 'required|string',
            'pekerjaan_ibu' => 'required|string',
            'alamat_ibu' => 'required|string',
            'rt_ibu' => 'required|max:3',
            'rw_ibu' => 'required|max:3',
        ]);
        $existing = SkpModel::where('nik', $request->nik)
    ->whereNotIn('status', ['Ditolak', 'Selesai']) // boleh disesuaikan
    ->exists();

if ($existing) {
    return redirect()->back()->withInput()->with('error', 'Pengajuan dengan NIK ini sudah ada.');

}

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
            $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('skp', 'local');
            $data['kk'] = $request->file('kk')->store('skp', 'local');
            $data['ktp'] = $request->file('ktp')->store('skp', 'local');
            $data['foto'] = $request->file('foto')->store('skp', 'local');
            $data['user_id'] = auth()->id();

            // 3. Cek duplikat NIK
            if (SkpModel::where('nik', $request->nik)->exists()) {
                return redirect()->back()->withInput()->withErrors(['nik' => 'NIK sudah pernah digunakan.']);
            }
            // Hitung jumlah SKTM di tahun ini
            $tahun = now()->year;
            $jumlah = SkpModel::whereYear('created_at', $tahun)->count() + 1;

            // Buat nomor surat
            $nomorSurat = '474.2/TTO/' . $tahun . '/' . str_pad($jumlah, 3, '0', STR_PAD_LEFT);

            // Tambahkan ke data
            $data['nomor_surat'] = $nomorSurat;

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
                'rt' => $request->rt,
                'rw' => $request->rw,
                'keterangan' => $request->keterangan,
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
                'rt_ayah' => $request->rt_ayah,
                'rw_ayah' => $request->rw_ayah,
                'nama_ibu' => $request->nama_ibu,
                'nik_ibu' => $request->nik_ibu,
                'tempat_lahir_ibu' => $request->tempat_lahir_ibu,
                'tanggal_lahir_ibu' => $request->tanggal_lahir_ibu,
                'agama_ibu' => $request->agama_ibu,
                'kewarganegaraan_ibu' => $request->kewarganegaraan_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'alamat_ibu' => $request->alamat_ibu,
                'rt_ibu' => $request->rt_ibu,
                'rw_ibu' => $request->rw_ibu,
                'skp_id' => $skp->id,
            ]);


            // 6. Simpan riwayat pengajuan
            RiwayatskpModel::create([
                'skp_id' => $skp->id,
                'status' => 'Diajukan',
                'peninjau' => '-',
                'keterangan' => 'Surat diajukan oleh pemohon',
                'alasan' => null,
            ]);


            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            Log::error('Gagal simpan SKP: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])
                ->withInput()
                ->with('form', 'tambah');
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
                'rt' => 'required|max:3',
                'rw' => 'required|max:3',
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
                'rt_ayah' => 'required|max:3',
                'rw_ayah' => 'required|max:3',
                'nama_ibu' => 'required',
                'nik_ibu' => 'required',
                'agama_ibu' => 'required',
                'kewarganegaraan_ibu' => 'required',
                'pekerjaan_ibu' => 'required',
                'alamat_ibu' => 'required',
                'rt_ibu' => 'required|max:3',
                'rw_ibu' => 'required|max:3',
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


            // 4. Upload file jika ada, kalau tidak ada tetap gunakan nilai lama
            foreach (['ktp', 'kk', 'pengantar_rt_rw', 'foto'] as $file) {
                if ($request->hasFile($file)) {
                    // Hapus file lama jika perlu
                    if ($skp->$file && \Storage::exists($skp->$file)) {
                        Storage::delete($skp->$file);
                    }

                    // Simpan file baru
                    $validated[$file] = $request->file($file)->store('skp', 'local');
                } else {
                    // Gunakan data lama agar tidak hilang
                    $validated[$file] = $skp->$file;
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

    public function storeDraf(Request $request)
    {
        try {
            \Log::info('✅ Request masuk ke storeDraf:', $request->all());

            if (auth()->user()->role !== 'Masyarakat') {
                abort(403, 'Hanya masyarakat yang bisa menyimpan draf.');
            }
            $userId = auth()->id();

            $draf = SkpModel::updateOrCreate(
                ['user_id' => $userId, 'status' => 'draf'],
                $request->except(['ktp', 'kk', 'pengantar_rt_rw', 'foto']) + ['status' => 'draf']
            );

            foreach (['ktp', 'kk', 'pengantar_rt_rw', 'foto'] as $file) {
                if ($request->hasFile($file)) {
                    $path = $request->file($file)->store("draf/{$userId}", 'local');
                    $draf->$file = $path;
                }
            }

            $draf->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error('❌ storeDraf error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }




    public function getDraf()
    {
        $draf = SkpModel::where('status', 'draf')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return response()->json($draf);
    }





    public function previewDrafFile($field)
    {
        $allowed = ['ktp', 'kk', 'pengantar_rt_rw', 'foto'];
        if (!in_array($field, $allowed)) abort(403);

        $draf = SkpModel::where('user_id', auth()->id())->where('status', 'draf')->firstOrFail();
        $path = $draf->$field;

        if (!Storage::disk('local')->exists($path)) abort(404);

        $mime = Storage::disk('local')->mimeType($path);
        $content = Storage::disk('local')->get($path);

        return Response::make($content, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
        ]);
    }





    public function show($id)
    {
        $skp = SkpModel::with(['riwayat_skp', 'orangTua', 'statusPerkawinan'])->findOrFail($id);

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
                    'alasan' => 'Surat sudah selesai. Silahkan datang ke kantor lurah untuk mengambil surat',
                ]);

                return redirect()->route('skp.show', $skp->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
            }

            return redirect()->back()->with('error', 'Anda tidak memiliki akses verifikasi.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function tolak(Request $request, $id)
    {
        $skp = skpModel::with('riwayat_skp')->findOrFail($id);
        $user = Auth::user();
        if ($request->status === 'Ditolak') {
            $skp->status = 'Ditolak';
            $skp->save();

            RiwayatskpModel::create([
                'skp_id' => $skp->id,
                'waktu' => now(),
                'tanggal' => now()->toDateString(),
                'status' => 'Ditolak',
                'peninjau' => $user->role ?? '-',
                'keterangan' => 'Surat ditolak oleh Admin',
                'alasan' => $request->alasan,
            ]);

            return redirect()->route('skp.show', $skp->id)->with('success', 'Surat berhasil ditolak.');
        }
    }


    public function cetak($id)
    {
        // $skp = skpModel::findOrFail($id);

        // // Logika untuk generate surat, bisa return view khusus cetak
        // return view('skp.cetak', compact('skp'));
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

            // $this->forgetskp();
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
