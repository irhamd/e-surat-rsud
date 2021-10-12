<?php

namespace App\Http\Controllers\Covid;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LaporanCovidController extends Controller
{
    public function inputPasienCovid(Request $req)
    {
        return view("LaporanCovid/BodyLaporanCovid");
    }
}
