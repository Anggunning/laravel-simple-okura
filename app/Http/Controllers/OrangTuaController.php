<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\OrangTuaModel;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function getByNik($nik)
{
    $data = OrangTuaModel::where('nik', $nik)->first();
    return response()->json($data);
}

}
