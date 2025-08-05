<?php

namespace App\Http\Controllers;

use App\Models\SkpModel;
use App\Models\SkuModel;
use App\Models\SktmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{

    public function index()
    {
        $user = Auth::user();

    // Cek role staf kelurahan
    if ($user->role === 'Admin') {
        try {
            $notifikasi = collect();

            // === SKTM ===
            $sktmBaru = SktmModel::where('status', 'Diajukan')->get();
            $sktmLama = SktmModel::where('status', 'Diajukan')->where('created_at', '<=', Carbon::now()->subDays(3))->get();

            foreach ($sktmBaru as $item) {
                $notifikasi->push([
                    'id' => $item->id,
                    // 'icon' => 'bi-people text-primary',
                    'message' => "Pengajuan Surat Keterangan Tidak Mampu oleh {$item->nama}",
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at,
                    'url' => route('sktm.show', $item->id),
                ]);
            }

            foreach ($sktmLama as $item) {
                $notifikasi->push([
                    'id' => $item->id,
                    // 'icon' => 'bi-hourglass-split text-danger',
                    'message' => "<span class='text-danger'>Pengajuan Keterangan Tidak Mampu oleh {$item->nama} Belum diproses > 3 hari</span>",
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at,
                    'url' => route('sktm.show', $item->id),
                ]);
            }

            // === SKU ===
            $skuBaru = SkuModel::where('status', 'Diajukan')->get();
            $skuLama = SkuModel::where('status', 'Diajukan')->where('created_at', '<=', Carbon::now()->subDays(3))->get();

            foreach ($skuBaru as $item) {
                $notifikasi->push([
                    'id' => $item->id,
                    // 'icon' => 'bi-file-earmark-text text-success',
                    'message' => "Pengajuan Surat Keterangan Usaha oleh {$item->nama}",
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at,
                    'url' => route('sku.show', $item->id), // arahkan ke show pengajuan
                ]);
            }

            foreach ($skuLama as $item) {
                $notifikasi->push([
                    'id' => $item->id,
                    'icon' => 'bi-file-earmark-text text-success',
                    'message' => "<span class='text-danger'>Pengajuan Keterangan Usaha oleh {$item->nama} Belum diproses > 3 hari</span>",
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at,
                    'url' => route('sku.show', $item->id), // arahkan ke show pengajuan
                ]);
            }

            // === SKP ===
            $skpBaru = SkpModel::where('status', 'Diajukan')->get();
            $skpLama = SkpModel::where('status', 'Diajukan')->where('created_at', '<=', Carbon::now()->subDays(3))->get();

            foreach ($skpBaru as $item) {
                $notifikasi->push([
                    'id' => $item->id,
                    // 'icon' => 'bi-heart text-warning',
                    'message' => "Pengajuan Surat Pengantar Perkawinan oleh {$item->nama_lengkap}",
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at,
                    'url' => route('skp.show', $item->id),
                ]);
            }

            foreach ($skpLama as $item) {
                $notifikasi->push([
                    'id' => $item->id,
                    // 'icon' => 'bi-clock-history text-danger',
                    'message' => "<span class='text-danger'>Pengajuan Pengantar Perkawinan oleh {$item->nama} Belum diproses > 3 hari</span>",
                    'time' => $item->created_at->diffForHumans(),
                    'created_at' => $item->created_at,
                    'url' => route('skp.show', $item->id),
                ]);
            }

            // Urutkan notifikasi berdasarkan waktu terbaru
            $sorted = $notifikasi->sortByDesc('created_at')->values();

            // $notifikasi = collect($notifikasi)->map(function ($item, $index) {
            //     if (!isset($item['id'])) {
            //         $item['id'] = 'notif-' . $index; // atau pakai Str::uuid()->toString()
            //     }
            //     return $item;
            // });
            return response()->json([
                'jumlah' => $sorted->count(),
                'data' => $sorted,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
    }

    public function baca($id)
    {
        // Kalau kamu tidak pakai model notifikasi, bisa kosong
        return response()->json(['success' => true]);
    }
}
