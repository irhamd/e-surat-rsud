<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paraf;
use Auth;
use App\ManageSurat;
use App\Http\Controllers\NotifikasiController as Notif; 
use DB;
use App\Http\Controllers\SuratController;


class ParafController extends Controller
{

    public static function setFirstparaf($norec){

        $getNoUrut ="
        UPDATE parafby_t set nourut = (
            SELECT jb.nourut from pegawai_m as pg
            join jabatan_m as jb on jb.id = pg.jabatansuratfk
            WHERE pg.id='22431')
        WHERE pegawaifk = '22431'
        and suratfk ='2020032306505221iSD0gF65Savd1'
        ";

        $data = DB::update  ("

        UPDATE parafby_t set status ='rq' WHERE id in ( 
            SELECT top 1  pf.id from esurat_t as es 
            JOIN parafby_t as pf on pf.suratfk = es.norec
            join pegawai_m as pg on pg.id = pf.pegawaifk
            JOIN jabatan_m as jb on jb.id = pg.jabatansuratfk
            
            WHERE es.norec ='$norec'
            ORDER BY jb.nourut asc
            )

        ");

        if(!$data){
            return 'Gagal update first paraf';
        } else{
            return $data;
        }

    }

    public function requestParaf(Request $req){
        
        $paraf = DB::table("esurat_t as es")
        ->join("parafby_t as pf","pf.suratfk","=","es.norec")
        ->join("statusesurat_m as stt","stt.kdstatus","pf.status")
        ->select("es.norec","es.perihal","es.tujuan","es.nosurat","es.created_at","es.updated_at","es.tanggal","es.isread as read"
        ,"pf.isread ","pf.isparaf","pf.status","stt.ket", "pf.updated_at as updateparaf","pf.created_at as created_atParaf",
             DB::raw("case when pf.isparaf=1 then 'Paraf' else 'Request' end as rstatus"),
             DB::raw("case when pf.isparaf=1 then 'Paraf' else 'Request' end as rstatus1"),
             DB::raw("case when (pf.isparaf=0 and pf.status='RJ') then 'red' when (pf.isparaf=0 and pf.status='RV') then 'aqua' 
              when pf.isparaf=1 then 'green' when pf.isparaf=0 then 'yellow'  end as class")
             )
        ->where("pf.pegawaifk","=",Auth::user()->pegawaifk)
        ->whereIn("pf.status",['rq','rv','rj','pf']);
        
        if( isset($req->nomorsurat)){
            $paraf = $paraf->where('es.nosurat','like','%'.$req->nomorsurat.'%');
        }

        if( isset($req->perihal)){
            $paraf = $paraf->where('es.perihal','like','%'.$req->perihal.'%');
        }

        if( isset($req->tanggal)){
            $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
            $paraf = $paraf->whereRaw("es.tanggal between ". $tgl);
        }


        if( isset($req->approve) && $req->approve!=""){
            $paraf = $paraf->where('es.statussurat','=',"TTD");
        }
                
        if( isset($req->requ) && $req->requ!=""){
                $paraf = $paraf
                ->where('pf.status','=','rq');
        }          
        
        if( isset($req->revisi) && $req->revisi!=""){
                $paraf = $paraf
                ->where('pf.status','=','rv');
        }

        if( isset($req->reject) && $req->reject!=""){
                $paraf = $paraf
                ->where('pf.status','=','rj');
        }
       


        $paraf = $paraf->orderBy("es.updated_at","desc")
        // ->whereIn("pf.isparaf",['0','1'])
        // ->where("pf.status", true)
        // ->get();
        ->limit(1000)
        ->paginate(16)
        ->appends(request()->query());

        // dd($paraf);

        // dd($paraf);
        // $this->setSession();
        // dd($paraf);
        return view("Surat/RequestParaf",compact("paraf"));
   } 

    public function revisiByParaf( Request $req, $suratfk){
        // try {
            $st ="RV";
            Paraf::where("suratfk",$suratfk)
            ->where("pegawaifk",Auth::user()->pegawaifk)
            ->update([
                "status"=> $st,
                "komentar"=> $req->komentar
                ]);
                ManageSurat::Updated_statusSurat($suratfk,$st);

                $title = "Revisi Surat";
                $message = $req->nomorsurat ." ".$req->perihalsurat." Komentar : ". $req->komentar;
                $tokenTujuan = OutboxController::getToken($suratfk);
                Notif::sentNotificationByParam($tokenTujuan,$title,$message);


                // ManageSurat::Updated_atSurat($suratfk);
                // return "berhasil";
            SuratController::setSession();
            ManageSurat::saveHistory($suratfk, "Revisi Surat","rv");

            return redirect()->back()->with("sukses","Berhasil ...");

        // } catch (\Throwable $th) {
        //     return redirect()->back()->with("errorr","Gagal revisi surat ...");
            
        // }

   }

   

    public function rejectByParaf( Request $req, $suratfk){
        try {
            $st ="RJ";
            Paraf::where("suratfk",$suratfk)
            ->where("pegawaifk",Auth::user()->pegawaifk)
            ->update([
                "status"=> $st,
                "komentar"=> $req->komentar
                ]);
                ManageSurat::Updated_statusSurat($suratfk,$st);


                $title = "Reject Surat ";
                $message = $req->nomorsurat ." ".$req->perihalsurat." Komentar : ". $req->komentar;
                $tokenTujuan = OutboxController::getToken($suratfk);
                Notif::sentNotificationByParam($tokenTujuan,$title,$message);


                ManageSurat::saveHistory($suratfk, "Reject Surat","rj");

                // return "berhasil";
            SuratController::setSession();
            return redirect()->back()->with("sukses","Berhasil ...");

        } catch (\Throwable $th) {
            return redirect()->back()->with("errorr","Gagal ...");
            
        }
   }


  public function parafRes( Request $req){
    try {
       $paraf = DB::select("
            SELECT es.perihal, 'paraf' as request ,pf.isparaf, es.nosurat ,pf.isread, pf.suratfk from parafby_t as pf
            join esurat_t as es on es.norec = pf.suratfk 
            where pf.pegawaifk =". $req['tujuanfk']);
            
    } catch (\Exception $th) {
        $paraf = [];       
    }
        return response()->json(["record" =>$paraf]);
 }

 public function cekParaf( Request $req){
    try {
       $paraf = DB::select("
             SELECT top 1 pf.isparaf from parafby_t as pf where pf.pegawaifk = ".$req['pegawaifk']
                ." and pf.suratfk ='".$req["suratfk"]."'");

                // dd($paraf);

        if($paraf[0]->isparaf == "1"){
            $result = true;
        } else{
            $result = false;
        }
            
    } catch (\Exception $th) {
        $result = $th->getMessage()  ;
    }
        return response()->json($result);
 }



   public function setParaf($suratfk){

    try {
        //code...


        DB::beginTransaction();
        $pegawaifk = Auth::user()->pegawaifk;
        // store procedures di database
        DB::update("exec setNextparaf '".$suratfk."',".$pegawaifk);

        $token = DB::table("parafby_t as x")
        ->join("pegawai_m as pg","pg.id","x.pegawaifk")
        ->join("esurat_t as es","x.suratfk","=","es.norec")
        ->where("x.isparaf","=",0)
        ->where("x.status","=","rq")
        ->where("x.suratfk","=",$suratfk)
        ->select("pg.tokenfirebase","es.perihal","es.nosurat")
        ->first();

        // $tes=DB::select("select [pg].[tokenfirebase], [es].[perihal], [es].[nosurat] from [parafby_t] as [x] inner join [pegawai_m] as [pg] on [pg].[id] = [x].[pegawaifk] inner join [esurat_t] as [es] on [x].[suratfk] = [es].[norec] 
        // where [x].[isparaf] ='0' and [x].[status] ='rq' and [x].[suratfk] = '3MwSYcTsnJzv6ET09082020033219'");

        $title = "Request Paraf";
        $getNextoken ="";

        // dd($tes);

        if($token == null){
            // JIKA SEMUA PARAF SUDAH STATUS 1 MAKA KIRIM NOTIFIKASI KE REQUEST TANDA TANGAN
            $title = "Request Tanda Tangan";

            $token = DB::table("tandatanganby_t as x")
            ->join("pegawai_m as pg","pg.id","x.pegawaifk")
            ->join("esurat_t as es","x.suratfk","=","es.norec")
            ->where("x.isttd","=","0")
            ->where("x.status","=","RQ")
            ->where("x.suratfk","=",$suratfk)
            ->select("pg.tokenfirebase","es.perihal","es.nosurat")
            ->first();
        }
        
        $getNextoken = $token->tokenfirebase;
        // dd($token);
        
        $message = "No.".$token->nosurat ." Hal : ".$token->perihal;

        Notif::sentNotificationByParam($getNextoken,$title,$message);

        DB::commit();

        // Paraf::where("suratfk",$suratfk)
        // ->where("pegawaifk", $pegawaifk)
        // ->update(["isparaf"=> 1,"status"=>'0']);



        // DB::update("
        //      UPDATE parafby_t set nourut = (
        //           SELECT jb.nourut from pegawai_m as pg
        //           join jabatan_m as jb on jb.id = pg.jabatansuratfk
        //           WHERE pg.id='$pegawaifk')
        //      WHERE pegawaifk = '$pegawaifk'
        //      and suratfk ='$suratfk'
        // ");

        ManageSurat::saveHistory($suratfk, "Paraf Surat","pf");
        SuratController::setSession();


        return redirect()->back()->with("success","Paraf sukses ...");

    } catch (\Exception $th) {
        DB::rollback();

        return redirect()->back()->with("errorr","Gagal Paraf ..." .$th->getMessage());
       
    
    }

    }


    public function setParafRes($suratfk ,$pegawaifk){
        try {
            DB::beginTransaction();
            DB::update("exec setNextparaf '".$suratfk."',".$pegawaifk);
    
            $token = DB::table("parafby_t as x")
            ->join("pegawai_m as pg","pg.id","x.pegawaifk")
            ->join("esurat_t as es","x.suratfk","=","es.norec")
            ->where("x.isparaf","=",0)
            ->where("x.status","=","rq")
            ->where("x.suratfk","=",$suratfk)
            ->select("pg.tokenfirebase","es.perihal","es.nosurat")
            ->first();
    
            $title = "Request Paraf";
            $getNextoken ="";
    
    
            if($token == null){
                // JIKA SEMUA PARAF SUDAH STATUS 1 MAKA KIRIM NOTIFIKASI KE REQUEST TANDA TANGAN
                $title = "Request Tanda Tangan";
    
                $token = DB::table("tandatanganby_t as x")
                ->join("pegawai_m as pg","pg.id","x.pegawaifk")
                ->join("esurat_t as es","x.suratfk","=","es.norec")
                ->where("x.isttd","=","0")
                ->where("x.status","=","RQ")
                ->where("x.suratfk","=",$suratfk)
                ->select("pg.tokenfirebase","es.perihal","es.nosurat")
                ->first();
          
            }
            
            $getNextoken = $token->tokenfirebase;
            // dd($token);
            
            $message = "No.".$token->nosurat ." Hal : ".$token->perihal;
    
            Notif::sentNotificationByParam($getNextoken,$title,$message);
    
            DB::commit();
    
            ManageSurat::saveHistoryRes($suratfk, "Paraf Surat","pf",$pegawaifk);
    
            $msg = "Suksess.";
            $status = 400;
    
        } catch (\Exception $th) {
            DB::rollback();
            $msg = "Gagal Paraf surat.".$th->getMessage();
            $status = 200;
        }

        return response()->json(["status"=> $status, "msg"=>$msg]);
    
        }



}
