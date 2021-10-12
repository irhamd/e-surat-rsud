<?php

namespace App;

use DB;
use Auth;
use User;
use Illuminate\Support\Str;
use App\Inbox\Inbox;
use App\Tanggal;
use App\Master\History;

class ManageSurat 
{
    public static function getPejabat(){
        return DB::table("pegawai_m as pg")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->where("jb.esurat", true)
        ->wherenotNull("jb.namajabatansurat")
        ->whereIn("pg.departementesuratfk", ['1','0'])
        // ->orWhere("pg.departementesuratfk", '0')
        ->select("pg.id","pg.namalengkap","jb.namajabatan","jb.namajabatansurat")
        ->get();
    }

    public static function getPejabatDisposisi(){
        return DB::table("pegawai_m as pg")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->where("jb.esurat", true)
        ->wherenotNull("jb.namajabatansurat")
        ->whereIn("pg.departementesuratfk", ['1','0'])
        // ->orWhere("pg.departementesuratfk", '0')
        ->select("pg.id","pg.namalengkap","jb.namajabatan","jb.namajabatansurat")
        ->get();
    }

    public static function getDirektur(){
        return DB::table("pegawai_m as pg")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->where("pg.id","=","22361")
        ->select("pg.id","pg.namalengkap","jb.namajabatan","jb.namajabatansurat")
        ->get();
    }


    public static function jlhDisposisi(){
        return  DB::table("disposisiesurat_t as dis")
        ->where("dis.assisten_pegawaifk", Auth::user()->pegawaifk)
        ->whereNull("dis.noagenda")
        ->count();
    }
   
    
    
    public static function getTTD($norec){
        return DB::table("esurat_t as es")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->join("pegawai_m as pg","pg.id","=","ttd.pegawaifk")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->select("es.norec","ttd.tandatangankey","ttd.pegawaifk","pg.namalengkap","nippns as nip","jb.namajabatan","jb.namaexternal","ttd.status as statusttd","ttd.isttd")
        ->where("es.norec",$norec)
        ->first();
    }

    public static function getStatusTandaTangan($norec){
        return DB::table("esurat_t as es")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->join("pegawai_m as pg","pg.id","=","ttd.pegawaifk")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->select("es.norec","ttd.pegawaifk","pg.namalengkap","nippns as nip","jb.namajabatan","jb.namaexternal","ttd.status as statusttd","ttd.isttd")
        ->where("es.norec",$norec)
        ->whereIn("ttd.status",["rj","rv"])
        ->first();
    }

    public static function cekDisposisi($norecDisposisi){
        $cek = DB::table("inboxesurat_t")->where("norec_disposisiesurat","=",$norecDisposisi)->count();

        // dd(cek)
        return $cek > 0 ? false : true;
    }

    
    public static function getStatusParaf($norec){
        return DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->join("pegawai_m as pg","pg.id","=","pf.pegawaifk")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->select("es.norec","pf.komentar","pf.pegawaifk","pg.namalengkap","nippns as nip","jb.namajabatan","jb.namaexternal","pf.status as statusparaf","pf.isparaf")
        ->where("es.norec",$norec)
        ->whereIn("pf.status",["rj","rv"])
        ->first();
    }
    


    public static function getParaf($norec){
        return DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->join("pegawai_m as pg","pg.id","=","pf.pegawaifk")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->select("es.norec","pf.pegawaifk","pf.status","pf.isread","pg.namalengkap","pg.nippns as nip","jb.namaexternal","pf.isparaf")
        ->where("es.norec",$norec)
        ->orderBy("jb.nourut","desc")
        ->get();
    }

    public static function getParafSingle($norec, $pegawifk){
        return DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->select("es.norec","pf.isparaf","pf.status")
        ->where("es.norec",$norec)
        ->where("pf.pegawaifk",$pegawifk)
        ->first();
    }



    public static  function jlhBelumParaf(){
        return
        DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->where("pf.pegawaifk","=",Auth::user()->pegawaifk)
        ->where("pf.isparaf", '0')
        ->where("pf.status","=","rq" )
        ->count();
   }
   public static  function totalParaf(){
        return
        DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->where("pf.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->WhereIn("pf.status",['rj','rv','pf'] )
        ->count();
   }

   public static  function jlhBelumTTD(){
     return
     DB::table("esurat_t as es")
     ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
     ->where("ttd.pegawaifk","=",Auth::user()->pegawaifk)
     ->where("ttd.isttd", false)
     ->whereIn("ttd.status",['rq','rv'] )
     ->count();
    }
    public static  function totalTTD(){
        return
        DB::table("esurat_t as es")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->where("ttd.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("ttd.isttd", true)
        ->whereIn("ttd.status",['rj','ttd'] )

        ->count();
    }
    public static function getTTDSingle($norec, $pegawifk){
        $data = DB::table("esurat_t as es")
        ->leftJoin("disposisiesurat_t as dis","dis.suratfk","es.norec")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->select("es.norec","ttd.isttd","ttd.status","es.tujuan","ttd.tandatangankey","es.disposisi","dis.norec as disnorec")
        ->where("es.norec",$norec)
        ->where("ttd.pegawaifk",$pegawifk)
        ->first();

        // dd($data);
        return $data;
    }

    public static  function getJumlahReject(){
        $k ='rj';
        $ttd = DB::table("esurat_t as es")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->select('es.norec')
        ->where("ttd.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("ttd.isparaf", 1)
        ->WhereIn("ttd.status",[$k] );


        return
        DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->select('es.norec')
        ->where("pf.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->WhereIn("pf.status",[$k] )
        ->union($ttd)
        ->count();
    }

    public static  function getJumlahRevisi(){
        return
        DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->where("pf.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->WhereIn("pf.status",['rv'] )

        ->count();
    }


    public static  function getReject(){
        return
        DB::table("esurat_t as es")
        ->where("es.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->Where("es.statussurat","RJ")
        ->count();
    }

    public static function getRevisi(){
        return
        DB::table("esurat_t as es")
        ->where("es.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->Where("es.statussurat","RV")
        ->count();
    }

    public static function getApprove(){
        return
        DB::table("esurat_t as es")
        ->where("es.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->Where("es.statussurat","TTD")
        ->Where("es.isreadoutbox","0")
        ->count();
    }




    public static  function getJumlahRequest(){
        $k ='rq';
        $ttd = DB::table("esurat_t as es")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->select('es.norec')
        ->where("ttd.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("ttd.isparaf", 1)
        ->WhereIn("ttd.status",[$k] );


        return
        DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->select('es.norec')
        ->where("pf.pegawaifk","=",Auth::user()->pegawaifk)
        // ->where("pf.isparaf", 1)
        ->WhereIn("pf.status",[$k] )
        ->union($ttd)
        ->count();
    }

    public static function Updated_atSurat($suratfk){
        Surat::where("norec","=",$suratfk)
        ->update([
            "created_at" => \Carbon\Carbon::now()
        ]);
    }

    public static function Updated_statusSurat($suratfk, $st){
       return Surat::where("norec","=",$suratfk)
        ->update([
            "updated_at" => \Carbon\Carbon::now(),
            "statussurat" => $st,
            "isread"=>false
        ]);
    }    
    
    
    public static function getInbox(){
        $id = Auth::user()->pegawaifk;
        // $inbox = Surat::where("disposisi","like","%".$id."%")
        // ->orWhere("tembusan","like","%".$id."%")
        // ->where("isread","=","0")
        // ->toSql();

        // $inbox = Surat:: whereRaw("(disposisi like '%".$id."%' or tembusan like '%".$id."%') and isreadinbox = 0 and statussurat ='TTD' ")->count();
        $inbox = Inbox::where('isread',"=","0")->where("tujuanfk",$id)->count();
        // from esurat_t where(disposisi like '%".$id."%' or tembusan like '%".$id."%') and isread = 0");

        // dd($inbox);

        return $inbox;           
    }

    public static function UserID(){
        return Auth::user()->getId();
    }    
        
    public static function getRandomString(){
        $ip = \Request::ip();
        $ip = str_replace(".","",$ip);
        return Str::random(15).\Hash::make(date('sihdmY')).$ip;
    }

    public static function getAsistenPegawai($id){

        $data = Pegawai::where("id","=",$id)->select('assisten')->first();
        return $data->assisten;
    
    }

    public static function getWadirForDisposisi(){
        return DB::table("pegawai_m as pg")
        ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
        ->where("jb.esurat", true)
        // ->where("jb.namajabatansurat","<>","")
        ->select("pg.id","pg.namalengkap","jb.namajabatan","jb.namajabatansurat")
        ->whereIn("pg.id",[22362,22370])
        ->get();

        return $data;
    }

    public static function saveHistory($suratfk, $ket, $kode){
        // $rand = $this->getRandomString();
        $post = History::insert([
            "id"=> ManageSurat::getRandomString(),
            "suratfk"=> $suratfk,
            "statusenabled"=>true,
            "pegawaifk"=>Auth::user()->pegawaifk,
            "keterangan"=>$ket,
            "kode"=>$kode,
            "tglinput"=>Tanggal::now()
       ]);
     
    }

    public static function saveHistoryRes($suratfk, $ket, $kode, $pegawaifk){
        // $rand = $this->getRandomString();
        $post = History::insert([
            "id"=> ManageSurat::getRandomString(),
            "suratfk"=> $suratfk,
            "statusenabled"=>true,
            "pegawaifk"=>$pegawaifk,
            "keterangan"=>$ket,
            "kode"=>$kode,
            "tglinput"=>Tanggal::now()
       ]);
     
    }
 

 




    
}

