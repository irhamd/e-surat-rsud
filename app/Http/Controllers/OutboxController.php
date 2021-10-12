<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\Surat;

class OutboxController extends Controller
{
             
     public function Outbox( Request $req ){

          // dd($req);

          SuratController::setSession();

        $outbox = DB::table("esurat_t as es")
        ->join("pegawai_m as pg","pg.id","es.tujuan")
        ->join("jabatan_m as jb","jb.id","pg.jabatansuratfk")
        ->select("es.*","pg.namalengkap","jb.namajabatansurat",
               DB::raw("case 
                    when es.statussurat='RJ' then 'reject' 
                    when es.statussurat='RQ' then '' 
                    when es.statussurat='RV' then 'revisi' 
                    when es.statussurat='TTD' then 'approve' 
                    end as class"
               )
          );


          if( isset($req->tanggal) && $req->tanggal!="" ){
               $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
               $outbox = $outbox->whereRaw("es.tanggal between  ". $tgl);
          }
          if( isset($req->nomorsurat) && $req->nomorsurat!=""){
               $outbox = $outbox->where('es.nosurat','like','%'.$req->nomorsurat.'%');
          }

          if( isset($req->perihal) && $req->perihal!=""){
               $outbox = $outbox->where('es.perihal','like','%'.$req->perihal.'%');
          }

          if( isset($req->approve) && $req->approve!=""){
               $outbox = $outbox->where('es.statussurat','=',"TTD");
          }
               
          if( isset($req->requ) && $req->requ!=""){
               $outbox = $outbox
               ->where('es.statussurat','=','rq');
          }          
          
          if( isset($req->revisi) && $req->revisi!=""){
               $outbox = $outbox
               ->where('es.statussurat','=','rv');
          }

          if( isset($req->reject) && $req->reject!=""){
               $outbox = $outbox
               ->where('es.statussurat','=','rj');
          }
          
          $outbox = $outbox->where("es.pegawaifk","=",Auth::user()->pegawaifk)
               // ->where("es.tanggal","=",date('Y-m-d'))
               ->orderBy("es.created_at","desc") 


               // dd($outbox);
               ->limit(120)
               ->paginate(15);

        return view("Surat/Outbox", compact("outbox"));

   }

   public static function getToken($suratfk){
        
     $data =  DB::table("esurat_t as x")
     ->join("pegawai_m as pg","pg.id","x.pegawaifk")
     // ->where("x.isttd","=","0")
     // ->where("x.status","=","RQ")
     ->where("x.norec","=",$suratfk)
     ->select("pg.tokenfirebase")
     ->first();

     // dd($data);

     return $data->tokenfirebase;
   }

   

   public function outboxRes( Request $req )
   {
        try {
           $outbox = DB::select("
           SELECT norec as suratfk, nosurat , perihal from esurat_t et where pwgawaifk =". $req['tujuanfk']);
        } catch (\Exception $th) {
            $outbox = [];       
        }
            return response()->json(["record" =>$outbox]);
    }
     
}
