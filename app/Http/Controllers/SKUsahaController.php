<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SkuModel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\RiwayatskuModel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SKUsahaController extends Controller
{
    public function index()
{
    $user = auth()->user();
    if ($user->role === 'Masyarakat') {
        $sku = SkuModel::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        // dd("User ID: " . $user->id, $sku); // Untuk cek isi data
    } else {
        $sku = SkuModel::all();
    }

    return view('sku.index', compact('sku'));
}

    // Menyimpan pengajuan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'tujuan' => 'required|string',
            'jenis_kelamin' => 'required',
            'tempatLahir' => 'required|string',
            'tanggalLahir' => 'required|date',
            'agama' => 'required|string',
            'nik' => 'required|digits:16',
            'alamat' => 'required|string',
            'pekerjaan' => 'required|string',
            'jenis_usaha' => 'required|string',
            'tempat_usaha' => 'required|string',
            'kelurahan' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'keterangan' => 'required|string',
            'foto_usaha' => 'required|file|mimes:jpg,jpeg,png',
            'pengantar_rt_rw' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'surat_pernyataan' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        try {
            $data = $request->all();
            // Upload file
            $data['foto_usaha'] = $request->file('foto_usaha')->store('sku');
            $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sku');
            $data['kk'] = $request->file('kk')->store('sku');
            $data['ktp'] = $request->file('ktp')->store('sku');
            $data['surat_pernyataan'] = $request->file('surat_pernyataan')->store('sku');
             $data['tanggal'] = now();
            $data['status'] = 'Diajukan';
            $data['user_id'] = auth()->id();
            $sku = SkuModel::create($data);

            RiwayatskuModel::create([
                'sku_id' => $sku->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diajukan',
                'peninjau' => '-', // atau sesuaikan nama peninjau jika ada login user
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
            $sku = SkuModel::findOrFail($id);

            $validated = $request->validate([
                'nama' => 'required|string',
                'tujuan' => 'required|string',
                'jenis_kelamin' => 'required',
                'tempatLahir' => 'required|string',
                'tanggalLahir' => 'required|date',
                'agama' => 'required|string',
                'nik' => 'required|string|max:16',
                'alamat' => 'required|string',
                'pekerjaan' => 'required|string',
                'jenis_usaha' => 'required|string',
                'tempat_usaha' => 'required|string',
                'kelurahan' => 'required|string',
                'kecamatan' => 'required|string',
                'kota' => 'required|string',
                'keterangan' => 'required|string',
                'foto_usaha' => 'nullable|file|mimes:jpg,jpeg,png',
            'pengantar_rt_rw' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'kk' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'surat_pernyataan' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            if ($request->hasFile('foto_usaha')) {
                $validated['foto_usaha'] = $request->file('foto_usaha')->store('dokumen');
            }
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

            $sku->update($validated);

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    public function verifikasi($id)
{
    try {
        $sku = SkuModel::findOrFail($id);
        $user = Auth::user();

        // ADMIN MEMPROSES
         if (in_array($user->role, ['Admin', 'Sekretaris'])) {
            if ($sku->status !== 'Diajukan') {
                return redirect()->back()->with('error', 'Surat tidak dalam status Diajukan.');
            }

            $sku->status = 'Diproses';
            $sku->save();

            RiwayatskuModel::create([
                'sku_id' => $sku->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diproses',
                'peninjau' => $user->name ?? 'Admin',
                'keterangan' => 'Surat telah diverifikasi oleh Admin',
                'surat_balasan' => null,
            ]);

            return redirect()->route('sku.show', $sku->id)->with('success', 'Surat berhasil diverifikasi oleh Admin.');
        }

        // LURAH MENYELESAIKAN
        elseif ($user->role === 'Lurah') {
            if ($sku->status !== 'Diproses') {
                return redirect()->back()->with('error', 'Surat belum diproses oleh Admin.');
            }

            $sku->status = 'Selesai';
            $sku->save();

            RiwayatskuModel::create([
                'sku_id' => $sku->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Selesai',
                'peninjau' => $user->name ?? 'Lurah',
                'keterangan' => 'Surat telah disahkan oleh Lurah',
                'surat_balasan' => null,
            ]);

            return redirect()->route('sku.show', $sku->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
        }

        return redirect()->back()->with('error', 'Anda tidak memiliki akses verifikasi.');
    } catch (\Exception $e) {
    dd($e->getMessage());
}
}

    public function show($id)
    {
        $sku = SkuModel::with('riwayat_sku')->findOrFail($id);
        return view('sku.detail', compact('sku'));
    }

    
    public function cetak($id)
    {
        // $sku = SkuModel::findOrFail($id);

        // // Logika untuk generate surat, bisa return view khusus cetak
        // return view('sku.cetak', compact('sku'));
         $sku = SkuModel::findOrFail($id);

    if ($sku->status !== 'Selesai') {
        abort(403, 'Surat hanya bisa dicetak jika statusnya Selesai.');
    }

    $pdf = Pdf::loadView('sku.cetak', compact('sku'));

    return $pdf->stream("SKU-{$sku->nama}.pdf"); // akan tampil di tab baru
    }

    
    public function destroy($id)
    {
        // User::findOrFail($id)->delete();
        // return redirect()->back()->with('success', 'Pengguna berhasil dihapus');
        try {
            $sku = SkuModel::findOrFail($id);
            $sku->delete();

            // $this->forgetsku();
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
