<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SktmModel;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RiwayatsktmModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\RiwayatPengajuanModel;

class SKTidakMampuController extends Controller
{
    public function index()
    {
        // $sktm = SktmModel::orderBy('created_at', 'desc')->paginate(6);
        //    $sktm = SktmModel::orderBy('created_at', 'desc')->get();

        //     // dd($sktm);
        //     return view('sktm.index', compact('sktm'));
        $user = auth()->user();
        if ($user->role === 'Masyarakat') {
            $sktm = SktmModel::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
            // dd("User ID: " . $user->id, $sktm); // Untuk cek isi data
        } else {
            $sktm = SktmModel::all();
        }

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
            'nik' => 'required|digits:16',
            'alamat' => 'required',
            'keterangan' => 'required',
            'pekerjaan' => 'required',
            'pengantar_rt_rw' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_pernyataan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $data = $request->all();

            $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sktm', 'local');
            $data['kk'] = $request->file('kk')->store('sktm', 'local');
            $data['ktp'] = $request->file('ktp')->store('sktm', 'local');
            $data['surat_pernyataan'] = $request->file('surat_pernyataan')->store('sktm', 'local');

            $data['user_id'] = auth()->id();
            $data['tanggal'] = now();
            $data['status'] = 'Diajukan';

            $sktm = SktmModel::create($data);

            RiwayatsktmModel::create([
                'sktm_id' => $sktm->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diajukan',
                'peninjau' => '-',
                'keterangan' => 'Surat diajukan oleh pemohon',
                'surat_balasan' => null,
            ]);

            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            logger()->error('Gagal menyimpan SKTM: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $sktm = SktmModel::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'tujuan' => 'required|string|max:255',
                'jenis_kelamin' => 'required|string',
                'tempatLahir' => 'required|string|max:255',
                'tanggalLahir' => 'required|date',
                'agama' => 'required|string|max:255',
                'nik' => 'required|string|max:16',
                'alamat' => 'required|string',
                'keterangan' => 'required|string',
                'pengantar_rt_rw' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
                'surat_pernyataan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            if ($request->hasFile('pengantar_rt_rw')) {
                $validated['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sktm', 'local');
            }
            if ($request->hasFile('kk')) {
                $validated['kk'] = $request->file('kk')->store('sktm', 'local');
            }
            if ($request->hasFile('ktp')) {
                $validated['ktp'] = $request->file('ktp')->store('sktm', 'local');
            }
            if ($request->hasFile('surat_pernyataan')) {
                $validated['surat_pernyataan'] = $request->file('surat_pernyataan')->store('sktm', 'local');
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
                    'peninjau' => $user->role,
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


    // public function cetak($id)
    // {
    //     $sktm = SktmModel::findOrFail($id);

    //     // Optional: batasi akses hanya jika status suratnya 'Selesai'
    //     if ($sktm->status !== 'Selesai') {
    //         abort(403, 'Surat belum selesai dan tidak bisa dicetak.');
    //     }

    //     $pdf = Pdf::loadView('sktm.cetak', compact('sktm'));
    //     return $pdf->stream('Surat_Keterangan_Tidak_Mampu.pdf');
    // }
    public function cetak($id)
    {
        // $sku = SkuModel::findOrFail($id);

        // // Logika untuk generate surat, bisa return view khusus cetak
        // return view('sku.cetak', compact('sku'));
         $sktm = SktmModel::findOrFail($id);

    if ($sktm->status !== 'Selesai') {
        abort(403, 'Surat hanya bisa dicetak jika statusnya Selesai.');
    }

    $pdf = Pdf::loadView('sktm.cetak', compact('sktm'));

    return $pdf->stream("sktm-{$sktm->nama}.pdf"); // akan tampil di tab baru
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
                'text' => $e->getMessage()
            ]);
        }
    }
}
