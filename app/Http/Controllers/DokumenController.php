<?php

namespace App\Http\Controllers;

use File;
use App\Models\SkuModel;
use App\Models\SktmModel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
     public function sktm($tipe, $filename)
    {
        $path = "sktm/{$filename}";

        if (!Storage::exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        // Validasi: cek file memang milik user (opsional, kalau ada user_id)
        $sktm = SktmModel::where($tipe, $path)->first();
        if (!$sktm) {
            abort(403, 'Anda tidak memiliki akses ke file ini.');
        }

        return response()->file(storage_path('app/' . $path));
    }
    public function sku($id)
{
    $sku = SkuModel::findOrFail($id);

    if ($sku->status !== 'Selesai') {
        abort(403, 'Surat hanya bisa dicetak jika statusnya Selesai.');
    }

    $pdf = Pdf::loadView('sku.cetak', compact('sku'));

    return $pdf->stream("SKU-{$sku->nama}.pdf"); // akan tampil di tab baru
    // return $pdf->download("SKU-{$sku->nama}.pdf"); // kalau mau langsung download
}

 public function show($folder, $filename)
    {
       // Cek folder valid
    if (!in_array($folder, ['sku', 'sktm', 'skp','pendudukMiskin'])) {
        abort(403, 'Folder tidak valid');
    }

    // Akses dari path private
    $path = storage_path("app/private/{$folder}/{$filename}");

    if (!\File::exists($path)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->file($path);
}

}
