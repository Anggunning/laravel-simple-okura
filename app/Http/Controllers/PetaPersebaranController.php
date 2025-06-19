<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetaPersebaranController extends Controller
{
    public function index()
    {
        return view('peta_persebaran');
    }
}
