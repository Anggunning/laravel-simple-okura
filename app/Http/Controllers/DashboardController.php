<?php

namespace App\Http\Controllers;

use App\Models\PendudukMiskinModel;
use App\Models\SkpModel;
use App\Models\SktmModel;
use App\Models\SkuModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{

public function index()
{
    $tahunIni = now()->year;
    $user = auth()->user();
    $userId = $user->id;
    $isMasyarakat = $user->role === 'Masyarakat';
    

    // Jika masyarakat → filter user_id, jika admin → tidak filter
    $riwayat = collect()
        ->merge(
            SktmModel::when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->get()->map(function ($item) {
                return [
                    'tanggal' => $item->created_at->format('d-m-Y'),
                    'created_at' => $item->created_at,
                    'jenis' => 'Surat Keterangan Tidak Mampu',
                    'tujuan' => $item->tujuan ?? '-',
                    'status' => $item->status,
                    'alasan' => optional($item->riwayat_sktm->whereIn('status', ['Selesai', 'Ditolak'])->last())->alasan ?? '-',

                    'link_detail' => route('sktm.show', $item->id),
                    'link_download' => $item->status === 'Selesai' ? route('sktm.cetak', $item->id) : null,
                ];
            })
        )
        ->merge(
            SkuModel::when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->get()->map(function ($item) {
                return [
                    'tanggal' => $item->created_at->format('d-m-Y'),
                    'created_at' => $item->created_at,
                    'jenis' => 'Surat Keterangan Usaha',
                    'tujuan' => $item->tujuan ?? '-',
                    'status' => $item->status,
                    'alasan' => optional($item->riwayat_sku->whereIn('status', ['Selesai', 'Ditolak'])->last())->alasan ?? '-',

                    'link_detail' => route('sku.show', $item->id),
                    'link_download' => $item->status === 'Selesai' ? route('sku.cetak', $item->id) : null,
                ];
            })
        )
        ->merge(
            SkpModel::when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->get()->map(function ($item) {
                return [
                    'tanggal' => $item->created_at->format('d-m-Y'),
                    'created_at' => $item->created_at,
                    'jenis' => 'Surat Keterangan Perkawinan',
                    'tujuan' => $item->tujuan ?? '-',
                    'status' => $item->status,
                    'alasan' => optional($item->riwayat_skp->whereIn('status', ['Selesai', 'Ditolak'])->last())->alasan ?? '-',

                    'link_detail' => route('skp.show', $item->id),
                    'link_download' => $item->status === 'Selesai' ? route('skp.cetak', $item->id) : null,
                ];
            })
        )->sortByDesc('created_at')->take(10);

        // Ambil draf SKTM khusus user sekarang
    $draf = SktmModel::where('status', 'draf')
        ->where('user_id', $user->id)
        ->latest()
        ->get();
        


    return view('dashboard', [
        'jumlahPengguna' => User::count(),
        'jumlahPendudukMiskin' => PendudukMiskinModel::count(),

        'sktm' => [
            'total' => SktmModel::when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'diajukan' => SktmModel::whereYear('created_at', $tahunIni)->where('status', 'diajukan')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'diproses' => SktmModel::whereYear('created_at', $tahunIni)->where('status', 'diproses')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'selesai' => SktmModel::whereYear('created_at', $tahunIni)->where('status', 'selesai')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
        ],
        'sku' => [
            'total' => SkuModel::when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'diajukan' => SkuModel::whereYear('created_at', $tahunIni)->where('status', 'diajukan')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'diproses' => SkuModel::whereYear('created_at', $tahunIni)->where('status', 'diproses')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'selesai' => SkuModel::whereYear('created_at', $tahunIni)->where('status', 'selesai')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
        ],
        'skp' => [
            'total' => SkpModel::when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'diajukan' => SkpModel::whereYear('created_at', $tahunIni)->where('status', 'diajukan')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'diproses' => SkpModel::whereYear('created_at', $tahunIni)->where('status', 'diproses')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
            'selesai' => SkpModel::whereYear('created_at', $tahunIni)->where('status', 'selesai')->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),
        ],
        'totalPengajuan' =>
            SktmModel::whereYear('created_at', $tahunIni)->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count()
            + SkuModel::whereYear('created_at', $tahunIni)->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count()
            + SkpModel::whereYear('created_at', $tahunIni)->when($isMasyarakat, fn($q) => $q->where('user_id', $userId))->count(),

        'riwayat' => $riwayat,
        'drafSktm' => SktmModel::where('status', 'draf')->where('user_id', $userId)->latest()->get(),
'drafSku' => SkuModel::where('status', 'draf')->where('user_id', $userId)->latest()->get(),
'drafSkp' => SkpModel::where('status', 'draf')->where('user_id', $userId)->latest()->get(),

        
        
    ]);
}
}