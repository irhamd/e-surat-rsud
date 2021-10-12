<?php

namespace App\Http\Controllers\Pejabat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PejabatController extends Controller
{
    public function getPejabat($var = [1,0], Request $req)
    {
            $data =  DB::table("pegawai_m as pg")
            ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
            ->where("jb.esurat", true)
            // ->whereNotIn("pg.id",[Auth::user()->pegawaifk])
            ->wherenotNull("jb.namajabatansurat")
            ->whereIn("pg.departementesuratfk", $var)
            // ->orWhere("pg.departementesuratfk", '0')
            ->select("pg.id","pg.namalengkap","jb.namajabatan","jb.namajabatansurat","pg.departementesuratfk")
            ->get();

            return response()->json($data);


    }

    public function tujuanSebar(Request $req)
    {
            $data =  DB::table("sebaran_esurat_t as seb")
            ->where("seb.statusenabled","=",true)
            ->get();

            return response()->json($data);


    }
    
}
