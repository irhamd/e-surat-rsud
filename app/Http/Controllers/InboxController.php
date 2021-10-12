<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Surat;
use App\ManageSurat;
use App\Inbox\Inbox;
use App\Http\Controllers\SuratController;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
// use Illuminate\Pagination\Paginator;

class InboxController extends Controller
{
   private function UserId(){
      return Auth::user()->pegawaifk;
   }
    

   public function InboxRev( Request $req){
      // try {
        

         $suratExternal = DB::table("esuratexternal_t as es")
         ->join("inboxesurat_t as ib","ib.suratfk","=","es.norec")
         ->leftJoin("esuratdisktipsi_m as di","di.id","=","ib.diskripsifk")
         ->leftJoin("disposisiesurat_t as dis","dis.norec","=","ib.norec_disposisiesurat")
         ->where('ib.tujuanfk',$this->UserId())
         ->select("es.nosurat","es.tujuan","es.perihal","es.norec","es.tanggal","es.assignto",
            "ib.isread as isreadinbox","ib.ket","ib.created_at as created_atinbox","es.asalsurat","es.lampiran", 
            DB::raw(" ib.norec_disposisiesurat, dis.noagenda, 'ex' as jenissurat "), "di.diskripsi","ib.diskripsifk",
            "ib.catatandisposisi","ib.mark_pegawaifk","ib.tujuanfk","ib.isdisposisi"
         );

            if( isset($req->tanggal) && $req->tanggal!="" ){
               $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
               $suratExternal = $suratExternal->whereRaw("es.tanggal between  ". $tgl);
            }
            if( isset($req->nomorsurat) && $req->nomorsurat!=""){
                  $suratExternal = $suratExternal->where('es.nosurat','like','%'.$req->nomorsurat.'%');
            }

            if( isset($req->suratfk) && $req->suratfk!=""){
               $suratExternal = $suratExternal->where('es.norec','like','%'.$req->suratfk.'%');
            }


            if( isset($req->perihal) && $req->perihal!=""){
                  $suratExternal = $suratExternal->where('es.perihal','like','%'.$req->perihal.'%');
            }

            if( isset($req->isread) && $req->isread!=""){
               $suratExternal = $suratExternal->where('ib.isread','=','0');
            }


        $inbox = DB::table("esurat_t as es")
         ->join("inboxesurat_t as ib","ib.suratfk","=","es.norec")
         ->leftJoin("esuratdisktipsi_m as di","di.id","=","ib.diskripsifk")
         ->leftJoin("disposisiesurat_t as dis","dis.norec","=","ib.norec_disposisiesurat")
         ->select("es.nosurat","es.tujuan","es.perihal","es.norec","es.tanggal",DB::raw('null as assignto'),
            "ib.isread as isreadinbox","ib.ket","ib.created_at as created_atinbox","es.asalsurat","es.lamp", 
            "ib.norec_disposisiesurat", "dis.noagenda", DB::raw("'in' as jenissurat"),"di.diskripsi","ib.diskripsifk",
            "ib.catatandisposisi","ib.mark_pegawaifk","ib.tujuanfk","ib.isdisposisi"
            )
            ->where('ib.tujuanfk',Auth::user()->pegawaifk)
            
         ->unionAll($suratExternal);
        

         if( isset($req->tanggal) && $req->tanggal!="" ){
               $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
               $inbox = $inbox->whereRaw("es.tanggal between  ". $tgl);
         }
         if( isset($req->nomorsurat) && $req->nomorsurat!=""){
               $inbox = $inbox->where('es.nosurat','like','%'.$req->nomorsurat.'%');
         }

         if( isset($req->suratfk) && $req->suratfk!=""){
            $inbox = $inbox->where('es.norec','like','%'.$req->suratfk.'%');
         }

         if( isset($req->perihal) && $req->perihal!=""){
               $inbox = $inbox->where('es.perihal','like','%'.$req->perihal.'%');
         }
         if( isset($req->isread) && $req->isread!=""){
            $inbox = $inbox->where('ib.isread','=','0');
         }


         // ->get();
         
         
         if( isset($req['getResponse'])){
            $inbox = $inbox
            // ->wherenotnull("ib.isdisposisi")
            // ->Where("ib.tujuanfk","=",Auth::user()->pegawaifk)
            // ->whereNotNull("ib.mark_pegawaifk")
            ->limit(10)
            ->orderby("created_atinbox","asc")
            ->get();
            // dd($inbox); 

            // return $inbox;
            return response()->json($inbox);
         } else{          
            $inbox = $inbox
            ->where('ib.tujuanfk',Auth::user()->pegawaifk)
            ->get();

            // $data = DB::select($inbox);
            SuratController::setSession();
            $getWadirForDisposisi = ManageSurat::getWadirForDisposisi();
            return view("Surat/Inbox", compact("inbox","getWadirForDisposisi"));
         }



      // } catch (\Exception $th) {
      //    return redirect()->back()->with("error",$th->getMessage());
          
      // }

   }

   public static function setReadInbox(){
      Inbox::where("tujuanfk","=",Auth::user()->pegawaifk)
      ->update(["isread"=> "1"]);
   }

   public function InboxRes( Request $req){
      try {
         $inbox = DB::select("

               SELECT d.* from (
                  SELECT 'in' as jenissurat, ib.norec, ib.suratfk , ib.tujuanfk , es.perihal , es.nosurat, ib.ket, ib.created_at  
                  from inboxesurat_t as ib 
                  join esurat_t as es on es.norec = ib.suratfk 
                  UNION ALL 
                  SELECT 'ex' as jenissurat, ib.norec,ib.suratfk , ib.tujuanfk , esx.perihal , esx.nosurat, ib.ket, ib.created_at  
                  from inboxesurat_t as ib 
                  join esuratexternal_t as esx on esx.norec = ib.suratfk 
               ) as d where d.tujuanfk =". $req['tujuanfk']);
         return response()->json(["record" =>$inbox]);
         
      } catch (\Exception $th) {
         return response()->json(["record"=>[]]);          
      }
   }

   public function komentarDisposisi( Request $req )
   {
      $detail = DB::select("
      SELECT pg.namalengkap, jb.namajabatansurat, pg1.namalengkap as namalengkap1,

      case when ib.catatandisposisi is null then '-' else ib.catatandisposisi end as catatan ,

      ib.* From inboxesurat_t as ib
      join pegawai_m as pg on pg.id = ib.tujuanfk 
      left join pegawai_m as pg1 on pg1.id = ib.mark_pegawaifk 
      left join jabatan_m as jb on jb.id = pg.jabatansuratfk 
      where ib.statuscode  is  null and ib.suratfk ='".$req['suratfk']."'");

      return response()->json(["data"=>$detail]);          
   }
}