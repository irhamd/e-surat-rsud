<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  DB;

class TimelineController extends Controller
{
   public function getTimeline( Request $req )
   {

    try {
        //code...

        $hari = DB::table("historyesurat_t as his")
            ->select( DB::raw(" format( his.tglinput,'yyyy-MM-dd') as tanggalinput"));

        $data = DB::table("historyesurat_t as his")
        
        ->leftJoin("pegawai_m as pg","pg.id","=","his.pegawaifk")
        ->join("esurat_t as es","es.norec","=","his.suratfk")
        ->leftJoin("jabatan_m as jb","pg.jabatansuratfk","=","jb.id")
        ->select("pg.namalengkap","es.asalsurat","es.perihal","es.tanggal","his.*","jb.namajabatansurat","es.nosurat",
            DB::raw(" format( his.tglinput,'yyyy-MM-dd') as tanggalinput"));
        
        
        $suratfk = $req['suratfk'];

        if($suratfk){
            $data = $data->where("his.suratfk","=",$suratfk);
            $hari = $hari->where("his.suratfk","=",$suratfk);
        }
        $hari = $hari->groupBy(DB::raw(" format( his.tglinput,'yyyy-MM-dd')"))->get();
        $single = $data->first();
        $data = $data->orderBy("his.tglinput")->limit(300)->get();

        // dd($data);
        if(count($data) == 0){
            return redirect()->back();
        } else{
            return view("Timeline/Timeline", compact("data","hari","single"));
        }

    } catch (\Throwable $th) {
       return redirect()->back();
    }

   }
}
