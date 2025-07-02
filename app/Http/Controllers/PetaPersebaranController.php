<?php

namespace App\Http\Controllers;

use App\Models\PendudukMiskinModel;
use Illuminate\Http\Request;

class PetaPersebaranController extends Controller
{
    public function index()
{
    $data = PendudukMiskinModel::whereNotNull('latitude')->whereNotNull('longitude')->get();
    foreach ($data as $item) {
        if (!$item->nama_kepala_keluarga) {
            $item->nama_kepala_keluarga = 'Tidak ada kepala keluarga';
        }
    }


    $kelompokList = PendudukMiskinModel::select('kelompokPKH')
        ->whereNotNull('kelompokPKH')
        ->distinct()
        ->pluck('kelompokPKH');
        
        

    return view('pendudukMiskin.peta', compact('data', 'kelompokList'));
}
}
