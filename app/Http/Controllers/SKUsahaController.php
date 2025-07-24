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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SKUsahaController extends Controller
{
    public function index(Request $request)
{
     $user = auth()->user();
        $drafToLoad = null;

    if ($request->has('draf')) {
    $drafToLoad = SkuModel::where('id', $request->get('draf'))
        ->where('status', 'draf')
        ->where('user_id', $user->id)
        ->first();
}


        if ($user->role === 'Masyarakat') {
            // Untuk user masyarakat: hanya data mereka sendiri
            $skuBelumSelesai = SkuModel::whereNotIn('status', ['Selesai', 'Ditolak', 'draf'])->get()
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

            $skuSelesai = SkuModel::where('status', 'Selesai')
                ->orderBy('created_at', 'desc')->get();
            // dd($skuSelesai);

            $skuDitolak = SkuModel::with(['riwayat_sku'])->where('status', 'Ditolak')
                ->orderBy('created_at', 'desc')->get();
        } elseif ($user->role === 'Lurah') {
            // Lurah: hanya lihat Diproses, Selesai, Ditolak
            $skuBelumSelesai = SkuModel::where('status', 'Diproses')->orderBy('created_at', 'desc')->get();
            $skuSelesai = SkuModel::where('status', 'Selesai')->orderBy('created_at', 'desc')->get();
            $skuDitolak = SkuModel::where('status', 'Ditolak')->orderBy('created_at', 'desc')->get();
        } else {
            $skuBelumSelesai = SkuModel::whereNotIn('status', ['Selesai', 'Ditolak', 'draf'])->get()
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

            $skuSelesai = SkuModel::where('status', 'Selesai')
                ->orderBy('created_at', 'desc')
                ->get();

            $skuDitolak = SkuModel::with(['riwayat_sku'])
                ->where('status', 'Ditolak')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('sku.index', compact('skuBelumSelesai', 'skuSelesai', 'skuDitolak', 'drafToLoad'));
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
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',   
            'foto_usaha' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'pengantar_rt_rw' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'kk' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'surat_pernyataan' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $data = $request->all();
            // Upload file
            $data['foto_usaha'] = $request->file('foto_usaha')->store('sku', 'local');
            $data['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sku', 'local');
            $data['kk'] = $request->file('kk')->store('sku', 'local');
            $data['ktp'] = $request->file('ktp')->store('sku', 'local');
            $data['surat_pernyataan'] = $request->file('surat_pernyataan')->store('sku', 'local');

            $data['tanggal'] = now();
            $data['status'] = 'Diajukan';
            $data['user_id'] = auth()->id();
            $sku = SkuModel::create($data);

            RiwayatskuModel::create([
                'sku_id' => $sku->id,
                'tanggal' => now()->toDateString(),
                'waktu' => now(),
                'status' => 'Diajukan',
                'peninjau' => '-', 
                'keterangan' => 'Surat diajukan oleh pemohon',
                'alasan' => null
            ]);

            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            dd($e->getMessage());
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

            $draf = SkuModel::updateOrCreate(
                ['user_id' => $userId, 'status' => 'draf'],
                $request->except(['ktp','surat_pernyataan', 'kk', 'pengantar_rt_rw', 'foto_usaha']) + ['status' => 'draf']
            );

            foreach (['ktp','surat_pernyataan', 'kk', 'pengantar_rt_rw', 'foto_usaha'] as $file) {
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
        $draf = SkuModel::where('status', 'draf')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return response()->json($draf);
    }


   public function previewDrafFile($field)
{
    $allowed = ['ktp','surat_pernyataan', 'kk', 'pengantar_rt_rw', 'foto_usaha'];
    if (!in_array($field, $allowed)) {
        abort(403, 'Field tidak diizinkan.');
    }

    $draf = SkuModel::where('user_id', auth()->id())
        ->where('status', 'draf')
        ->first();

    // Pastikan draf dan field-nya ada dan tidak kosong
    if (!$draf || empty($draf->$field)) {
        abort(404, 'Data draf atau file tidak ditemukan.');
    }

    $path = $draf->$field;

    // Cek keberadaan file di disk 'local'
    if (!Storage::disk('local')->exists($path)) {
        abort(404, 'File tidak ditemukan di storage.');
    }

    $mime = Storage::disk('local')->mimeType($path);
    $content = Storage::disk('local')->get($path);
\Log::info('Preview file path:', ['path' => $path]);

    return \Response::make($content, 200, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
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
                $validated['foto_usaha'] = $request->file('foto_usaha')->store('sku', 'local');
            }
            if ($request->hasFile('pengantar_rt_rw')) {
                $validated['pengantar_rt_rw'] = $request->file('pengantar_rt_rw')->store('sku', 'local');
            }
            if ($request->hasFile('kk')) {
                $validated['kk'] = $request->file('kk')->store('sku', 'local');
            }
            if ($request->hasFile('ktp')) {
                $validated['ktp'] = $request->file('ktp')->store('sku', 'local');
            }
            if ($request->hasFile('surat_pernyataan')) {
                $validated['surat_pernyataan'] = $request->file('surat_pernyataan')->store('sku', 'local');
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
                    'alasan' => 'Surat sudah selesai. Silahkan datang ke kantor lurah untuk mengambil surat',
                ]);

                return redirect()->route('sku.show', $sku->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
            }

            return redirect()->back()->with('error', 'Anda tidak memiliki akses verifikasi.');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function tolak(Request $request, $id)
    {
        $sku = SkuModel::with('riwayat_sku')->findOrFail($id);
        $user = Auth::user();
        if ($request->status === 'Ditolak') {
            $sku->status = 'Ditolak';
            $sku->save();

            RiwayatskuModel::create([
                'sku_id' => $sku->id,
                'waktu' => now(),
                'tanggal' => now()->toDateString(),
                'status' => 'Ditolak',
                'peninjau' => $user->role ?? '-',
                'keterangan' => 'Surat ditolak oleh Admin',
                'alasan' => $request->alasan,
            ]);

            return redirect()->route('sku.show', $sku->id)->with('success', 'Surat berhasil ditolak.');
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
                'text' => $e->getMessage()
            ]);
        }
    }
}
