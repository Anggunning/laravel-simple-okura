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
    try {
    $notifikasi = collect();

    // === SKTM ===
    $sktmBaru = SktmModel::where('status', 'Diajukan')->get();
    $sktmLama = SktmModel::where('status', 'Diajukan')->where('created_at', '<=', Carbon::now()->subDays(3))->get();

    foreach ($sktmBaru as $item) {
        $notifikasi->push([
            // 'icon' => 'bi-people text-primary',
            'message' => "Pengajuan Surat Keterangan Tidak Mampu oleh {$item->nama}",
            'time' => $item->created_at->diffForHumans(),
            'created_at' => $item->created_at,
            'url' => route('sktm.show', $item->id),
        ]);
    }

    foreach ($sktmLama as $item) {
        $notifikasi->push([
            // 'icon' => 'bi-hourglass-split text-danger',
            'message' => "Pengajuan Surat Keterangan Tidak Mampu oleh {$item->nama} belum diproses > 3 hari",
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
    'message' => "<span class='text-danger'>Pengajuan SKU oleh {$item->nama} Belum Diproses</span>",
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
            // 'icon' => 'bi-heart text-warning',
            'message' => "Pengajuan Surat Pengantar Perkawinan oleh {$item->nama_lengkap}",
            'time' => $item->created_at->diffForHumans(),
            'created_at' => $item->created_at,
            'url' => route('skp.show', $item->id),
        ]);
    }

    foreach ($skpLama as $item) {
        $notifikasi->push([
            // 'icon' => 'bi-clock-history text-danger',
            'message' => "Pengajuan Pengantar Perkawinan oleh {$item->nama_lengkap} belum diproses > 3 hari",
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

public function destroy($id)
{
    // Kalau kamu tidak pakai model notifikasi, bisa kosong
    return response()->json(['success' => true]);
}
}
