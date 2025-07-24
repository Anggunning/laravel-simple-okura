<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\SktmModel;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\RiwayatsktmModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\RiwayatPengajuanModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SKTidakMampuController extends Controller
{
    public function index(Request $request)
    {

        $user = auth()->user();
        $drafToLoad = null;

        if ($request->has('draf')) {
            $drafToLoad = SktmModel::where('id', $request->get('draf'))
                ->where('status', 'draf')
                ->where('user_id', $user->id)
                ->first();
        }



        if ($user->role === 'Masyarakat') {
            // Untuk user masyarakat: hanya data mereka sendiri
            $sktmBelumSelesai = SktmModel::whereNotIn('status', ['Selesai', 'Ditolak', 'draf'])
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


            $sktmSelesai = SktmModel::with(['riwayat_sktm'])
                ->where('status', 'Selesai')
                ->orderBy('created_at', 'desc')
                ->get();
            // dd($sktmSelesai);

            $sktmDitolak = SktmModel::with(['riwayat_sktm'])->where('status', 'Ditolak')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role === 'Lurah') {
            // Lurah: hanya lihat Diproses, Selesai, Ditolak
            $sktmBelumSelesai = SktmModel::where('status', 'Diproses')->orderBy('created_at', 'desc')->get();
            $sktmSelesai = SktmModel::where('status', 'Selesai')->orderBy('created_at', 'desc')->get();
            $sktmDitolak = SktmModel::where('status', 'Ditolak')->orderBy('created_at', 'desc')->get();
        } else {
            $sktmBelumSelesai = SktmModel::whereNotIn('status', ['Selesai', 'Ditolak', 'draf'])->get()
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


            $sktmSelesai = SktmModel::where('status', 'Selesai')
                ->orderBy('created_at', 'desc')
                ->get();

            $sktmDitolak = SktmModel::with(['riwayat_sktm'])
                ->where('status', 'Ditolak')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return view('sktm.index', compact('sktmBelumSelesai', 'sktmSelesai', 'sktmDitolak', 'drafToLoad'));
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
            'pekerjaan' => 'required',
            'rt' => 'required|max:3',
            'rw' => 'required|max:3',
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
                'alasan' => null,
            ]);
            // Hapus draf
            SktmModel::where('user_id', auth()->id())->where('status', 'draf')->delete();

            return redirect()->back()->with('success', 'Data berhasil disimpan');
        } catch (\Exception $e) {
            logger()->error('Gagal menyimpan SKTM: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
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

            $draf = SktmModel::updateOrCreate(
                ['user_id' => $userId, 'status' => 'draf'],
                $request->except(['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan']) + ['status' => 'draf']
            );

            foreach (['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'] as $file) {
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
        $draf = SktmModel::where('status', 'draf')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        return response()->json($draf);
    }





    public function previewDrafFile($field)
    {
        $allowed = ['ktp', 'kk', 'pengantar_rt_rw', 'surat_pernyataan'];
        if (!in_array($field, $allowed)) abort(403);

        $draf = SktmModel::where('user_id', auth()->id())->where('status', 'draf')->firstOrFail();
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
        $sktm = SktmModel::with('riwayat_sktm')->findOrFail($id);

        return view('sktm.detail', compact('sktm'));
    }
    public function verifikasi(Request $request, $id)
    {
        try {
            $sktm = SktmModel::findOrFail($id);
            $user = Auth::user();

            // === JIKA ADMIN MEMPROSES ===
            if (in_array($user->role, ['Admin', 'Sekretaris']) && $sktm->status === 'Diajukan') {
                $sktm->status = 'Diproses';
                $sktm->save();

                RiwayatsktmModel::create([
                    'sktm_id' => $sktm->id,
                    'tanggal' => now()->toDateString(),
                    'waktu' => now(),
                    'status' => 'Diproses',
                    'peninjau' => $user->role,
                    'keterangan' => 'Surat telah diverifikasi oleh Admin',
                    'alasan' => null,
                ]);

                return redirect()->route('sktm.show', $sktm->id)->with('success', 'Surat berhasil diverifikasi oleh Admin.');
            }

            // === JIKA LURAH MENGESAHKAN ===
            elseif ($user->role === 'Lurah' && $sktm->status === 'Diproses') {
                $sktm->status = 'Selesai';
                $sktm->save();

                RiwayatsktmModel::create([
                    'sktm_id' => $sktm->id,
                    'tanggal' => now()->toDateString(),
                    'waktu' => now(),
                    'status' => 'Selesai',
                    'peninjau' => $user->name ?? 'Lurah',
                    'keterangan' => 'Surat telah disahkan oleh Lurah',
                    'alasan' => 'Surat sudah selesai. Silahkan datang ke kantor lurah untuk mengambil surat',
                ]);

                return redirect()->route('sktm.show', $sktm->id)->with('success', 'Surat berhasil disahkan oleh Lurah.');
            }

            return redirect()->back()->with('error', 'Akses verifikasi tidak valid.');
        } catch (\Exception $e) {
            logger()->error('Verifikasi SKTM error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat verifikasi.');
        }
    }
    public function tolak(Request $request, $id)
    {
        $sktm = SktmModel::with('riwayat_sktm')->findOrFail($id);
        $user = Auth::user();
        if ($request->status === 'Ditolak') {
            $sktm->status = 'Ditolak';
            $sktm->save();

            RiwayatsktmModel::create([
                'sktm_id' => $sktm->id,
                'waktu' => now(),
                'tanggal' => now()->toDateString(),
                'status' => 'Ditolak',
                'peninjau' => $user->role ?? '-',
                'keterangan' => 'Surat ditolak oleh Admin',
                'alasan' => $request->alasan,
            ]);

            return redirect()->route('sktm.show', $sktm->id)->with('success', 'Surat berhasil ditolak.');
        }
    }


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
