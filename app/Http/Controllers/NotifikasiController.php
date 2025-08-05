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
        if (in_array($user->role, ['Admin', 'Sekretaris'])) {

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
                        'message' => "<span class='text-danger'>Pengajuan Surat Keterangan Usaha oleh {$item->nama} Belum diproses > 3 hari</span>",
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
                        'message' => "Pengajuan Surat Pengantar Perkawinan oleh {$item->nama}",
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

        if ($user->role === 'Lurah') {
            $notifikasi = collect();
            try {
                // === SKTM ===
                $sktmDiprosesLama = SktmModel::where('status', 'Diproses')
                    ->where('created_at', '<=', Carbon::now()->subDays(3))
                    ->get();

                foreach ($sktmDiprosesLama as $item) {
                    $notifikasi->push([
                        'id' => 'sktm_' . $item->id,
                        'message' => "<span class='text-danger'>Surat Keterangan Tidak Mampu oleh {$item->nama} belum selesai > 3 hari</span>",
                        'time' => $item->created_at->diffForHumans(),
                        'created_at' => $item->created_at,
                        'url' => route('sktm.show', $item->id),
                    ]);
                }

                // === SKU ===
                $skuDiprosesLama = SkuModel::where('status', 'Diproses')
                    ->where('created_at', '<=', Carbon::now()->subDays(3))
                    ->get();

                foreach ($skuDiprosesLama as $item) {
                    $notifikasi->push([
                        'id' => 'sku_' . $item->id,
                        'message' => "<span class='text-danger'>Surat Keterangan Usaha oleh {$item->nama} belum selesai > 3 hari</span>",
                        'time' => $item->created_at->diffForHumans(),
                        'created_at' => $item->created_at,
                        'url' => route('sku.show', $item->id),
                    ]);
                }

                // === SKP ===
                $skpDiprosesLama = SkpModel::where('status', 'Diproses')
                    ->where('created_at', '<=', Carbon::now()->subDays(3))
                    ->get();

                foreach ($skpDiprosesLama as $item) {
                    $notifikasi->push([
                        'id' => 'skp_' . $item->id,
                        'message' => "<span class='text-danger'>Surat Pengantar Perkawinan oleh {$item->nama} belum selesai > 3 hari</span>",
                        'time' => $item->created_at->diffForHumans(),
                        'created_at' => $item->created_at,
                        'url' => route('skp.show', $item->id),
                    ]);
                }

                $sorted = $notifikasi->sortByDesc('created_at')->values();

                return response()->json([
                    'jumlah' => $sorted->count(),
                    'data' => $sorted,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                    'line' => $e->getLine(),
                ], 500);
            }
        }

        if ($user->role === 'Masyarakat') {
            try {
                $notifikasi = collect();
                // === SKTM ===
                $sktm = SktmModel::where('user_id', $user->id)
                    ->whereIn('status', ['Selesai', 'Ditolak'])
                    ->latest()
                    ->get();

                foreach ($sktm as $item) {
                    $notifikasi->push([
                        'id' => 'sktm_' . $item->id,
                        'message' => "Pengajuan Surat Keterangan Tidak Mampu: : <strong>{$item->status}</strong>",
                        'time' => $item->updated_at->diffForHumans(),
                        'created_at' => $item->updated_at,
                        'url' => route('sktm.show', $item->id),
                    ]);
                }

                // === SKU ===
                $sku = SkuModel::where('user_id', $user->id)
                    ->whereIn('status', ['Selesai', 'Ditolak'])
                    ->latest()
                    ->get();

                foreach ($sku as $item) {
                    $notifikasi->push([
                        'id' => 'sku_' . $item->id,
                        'message' => "Pengajuan Surat Keterangan Usaha: <strong>{$item->status}</strong>",
                        'time' => $item->updated_at->diffForHumans(),
                        'created_at' => $item->updated_at,
                        'url' => route('sku.show', $item->id),
                    ]);
                }

                // === SKP ===
                $skp = SkpModel::where('user_id', $user->id)
                    ->whereIn('status', ['Selesai', 'Ditolak'])
                    ->latest()
                    ->get();

                foreach ($skp as $item) {
                    $notifikasi->push([
                        'id' => 'skp_' . $item->id,
                        'message' => "Pengajuan Surat Pengantar Perkawinan: <strong>{$item->status}</strong>",
                        'time' => $item->updated_at->diffForHumans(),
                        'created_at' => $item->updated_at,
                        'url' => route('skp.show', $item->id),
                    ]);
                }

                $sorted = $notifikasi->sortByDesc('created_at')->values();

                return response()->json([
                    'jumlah' => $sorted->count(),
                    'data' => $sorted,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
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
