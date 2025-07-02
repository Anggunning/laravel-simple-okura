<?php

namespace App\Http\Controllers;

use App\Models\PendudukMiskinModel;
use App\Models\SkpModel;
use App\Models\SktmModel;
use App\Models\SkuModel;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tahunIni = now()->year;

        return view('dashboard', [
            'jumlahPengguna' => User::count(),
            'jumlahPendudukMiskin' => PendudukMiskinModel::count(),

            'sktm' => [
                'diajukan' => SktmModel::whereYear('created_at', $tahunIni)->where('status', 'diajukan')->count(),
                'diproses' => SktmModel::whereYear('created_at', $tahunIni)->where('status', 'diproses')->count(),
                'selesai' => SktmModel::whereYear('created_at', $tahunIni)->where('status', 'selesai')->count(),
            ],
            'sku' => [
                'diajukan' => SkuModel::whereYear('created_at', $tahunIni)->where('status', 'diajukan')->count(),
                'diproses' => SkuModel::whereYear('created_at', $tahunIni)->where('status', 'diproses')->count(),
                'selesai' => SkuModel::whereYear('created_at', $tahunIni)->where('status', 'selesai')->count(),
            ],
            'skp' => [
                'diajukan' => SkpModel::whereYear('created_at', $tahunIni)->where('status', 'diajukan')->count(),
                'diproses' => SkpModel::whereYear('created_at', $tahunIni)->where('status', 'diproses')->count(),
                'selesai' => SkpModel::whereYear('created_at', $tahunIni)->where('status', 'selesai')->count(),
            ],
            'totalPengajuan' => SktmModel::whereYear('created_at', $tahunIni)->count()
                      + SkuModel::whereYear('created_at', $tahunIni)->count()
                      + SkpModel::whereYear('created_at', $tahunIni)->count(),

        ]);
    }
}
