<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pejabat;
use DB;
use App\Surat;
use App\Paraf;
use App\SuratExternal;
use App\TTD;
use App\Lampiran;
use App\Pegawai;
 
use Auth;
use App\User;
use Session;
use App\ManageSurat;
use App\Http\Controllers\ParafController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Validation\ValidationException as ValidationException;
 

use Illuminate\Support\Str;

class SuratController extends Controller
{
     public static function setSession()
     {
          Session::put("jlhparaf", ManageSurat::jlhBelumParaf());
          Session::put("totalParaf",ManageSurat::totalParaf());
          Session::put("jlhTTD",ManageSurat::jlhBelumTTD());
          Session::put("totalTTD",ManageSurat::totalTTD());          
          Session::put("totalReject",ManageSurat::getJumlahReject());          
          Session::put("totalRequest",ManageSurat::getJumlahRequest());   
          Session::put("jlhDisposisi",ManageSurat::jlhDisposisi());   
          
          Session::put("getApprove",ManageSurat::getApprove());          
          Session::put("getReject",ManageSurat::getReject());          
          Session::put("getRevisi",ManageSurat::getRevisi());          
          Session::put("getInbox",ManageSurat::getInbox());          
     }

     public function formatIndo($tgl){
          $bln = array (
               1 =>   'Januari',
               'Februari',
               'Maret',
               'April',
               'Mei',
               'Juni',
               'Juli',
               'Agustus',
               'September',
               'Oktober',
               'November',
               'Desember'
          );
          $x = array();
          $x = explode('-', $tgl);
          return $x[2] . ' ' . $bln[ (int)$x[1] ] . ' ' . $x[0];
     }

     public function getLogin( Request $req  ){
          $log = Auth::attempt([
               'name'=> $req->username,
               'password' => $req->password,
               'kodeprofile'=>'esurat',
               'statusenabled'=>true
          ]);
          // $cek = Auth::attempt(['kodeprofile'=>'esurat','password' => $req->password]); 
          // dd($cek, $log);
          
          if ($log  ) {      
               Session::put("userfk",Auth::user()->pegawaifk);         
               $this->setSession();
              return redirect("/home");  
         } else{
               return redirect()->back()->with("error","Gagal login ...");  
         }
     }

     public function login(){
          return view("Login/Login");
     }
     public function home(){
          $this->setSession();
          return view("Dashboard");
     }

     public function getPejabat(){
          return DB::table("pegawai_m as pg")
          ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
          ->where("jb.esurat", true)
          ->select("pg.id","pg.namalengkap","jb.namajabatan")
          ->get();
     }
        
   public function buatSurat( Request $req ){
     // dd($req);
     try{
          $editsurat ="";
          $pejabatTTD ="";
          $pejabatParaf = "";
          $tembusanPejabat = "";
          
          if( isset($req->edit) && $req->edit != ""){
               $editsurat =  Surat::where("norec","=",$req->edit)->first();
               $pejabatTTD = TTD::where('suratfk',"=",$req->edit)->first();
               $parafs = Paraf::where('suratfk',"=",$req->edit)->get();

               $pejabatParaf ="1"; 
               $tembusanPejabat =$editsurat->tembusan;

               foreach($parafs as $item){
                    $pejabatParaf = "".$pejabatParaf. ",".$item->pegawaifk;
               }
             
              $pejabatParaf =  str_replace('1,','',$pejabatParaf);
              $tembusanPejabat =  str_replace('"','',$tembusanPejabat);

               // dd($editsurat);
          }

          $tamplate = DB::table("tamplateesurat_m")->where("statusenabled",true)->first();
          $tamplate = $tamplate->tamplate;
          // dd($editsurat);

          // dd($req->isisurat);



          $pejabat = ManageSurat::getPejabat();

          // dd($pejabat);

          return view("Surat/BuatSurat/BuatSurat", compact("pejabat","editsurat", "pejabatTTD","pejabatParaf","tamplate","tembusanPejabat"));
     } catch (\Exception $th) {
          return redirect()->back()->with("error",$th->getMessage());
     }

   }




   public function suratExternalRes(Request $req){
     $pejabat = ManageSurat::getPejabat();
     $data = DB::table("esuratexternal_t as es")->where("es.pegawaifk","=",Auth::user()->pegawaifk)
     ->orWhere('assignto','like','%'.Auth::user()->pegawaifk.'%');
          


     if( isset($req->nomorsurat)){
          $data = $data->where('es.nosurat','like','%'.$req->nomorsurat.'%');
      }

     if( isset($req->perihal)){
          $data = $data->where('es.perihal','like','%'.$req->perihal.'%');
     }


     if( isset($req->tanggal)){
          $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
          $data = $data->whereRaw("es.tanggal between ". $tgl);
     }


     $data = $data->orderby("es.created_at","desc")
     ->get();
     // ->toSql();
     // dd($data);
     return response()->json([
          "data"=>$data
     ]);
     // return view("Surat/SuratExternalRev", compact("pejabat","data"));

   }


   public function cekNomorSUrat($nosurat){
        $cek = DB::table("esurat_t")->where('nosurat','=',$nosurat)->count();
        
        if($cek == 0)
        { return true;} else {return false;}
   }   
   
   public function cekNomorSUratRev(Request $req){
     //    dd($req->nosurat);
        $cek = DB::table("esurat_t")->where('nosurat','=',$req->nosurat)->count();

        
        if($cek > 0)
        { 
            return response('1');
          } else 
          {
               return response('0');
          }
   }

   public function getAsalSurat($pegawaifk){
        $pg = DB::table("pegawai_m as pg") 
          ->join("departementesurat_m as dp","pg.departementesuratfk","dp.id")
          ->where("pg.id","=",$pegawaifk)
          ->select("departement")->first();
  
        return $pg->departement;
   }

   public function prosesBuatSurat( Request $req ){
        try {

          // dd($req->lampiransurat);

          if(!isset($req->isisurat)){
               return redirect()->back()->whith("error","Nomor surat sudah di pakai ...");
          }
          // $req->validate([
          //      'tujuan' => 'required',
          //      'nosurat' => 'required',
          //      'tanggal' => 'required',
          //      'bodysurat' => 'required',
          //      'perihal' => 'required',
          //      'parafby' => 'required',
          //      'ttdby' => 'required'
          //   ]);

 


          $norectEdit = "";
          $norectEdit = $req->edit;
          $tembusan = json_encode($req->tembusan);
          
          $tembusan = str_replace("[","",$tembusan); 
          $tembusan = str_replace("]","",$tembusan);
          
          
          // dd($tembusan);
          

          //  PERHATIAN : surat harus di insert belakangan setelah paraf dan tanda tangan, karena akan cek paraf dan tanda tangan di triger table esurat
          
          if( $norectEdit != "" ){
               DB::beginTransaction();
               
               Paraf::where("suratfk","=", $norectEdit)->delete();
               TTD::where("suratfk","=", $norectEdit)->delete();
               $norec = $norectEdit;
          } else{
               // if norectEdit == null
               if (!$this->cekNomorSUrat($req['nosurat'])){
                    return back()->with("error","Nomor surat sudah di pakai  ...");
               }
               DB::beginTransaction();
               
               // $now = \DateTime::createFromFormat('U.u', microtime(true));
               $norec =  Str::random(15) . date("mdYHis");
               $norecLampiran =  date("mdYHis") . Str::random(15);
               // $norecLampiran = Str::random(15) .  date('Ymdhis');
          }

          // simpan paraf
          $paraf = $req->parafby;
          $no = 0;
          if(isset($paraf)){
               foreach ($paraf as $item) {
                    $pegawaifk =$paraf[$no++];
                    $p = Paraf::insert([
                         'suratfk' =>$norec,
                         'isread' => false,
                         'isparaf' => false,
                         'status' => false,
                         'updated_at'=>date("Y-m-d h:i:s"),
                         'pegawaifk' => $pegawaifk
                    ]);
               }
          }

          $ttd = $req->ttdby;

          // dd($ttd);
          $no = 0;
          // simpan tandatangan
          if($ttd){
               foreach ($ttd as $item) {
                    $p = TTD::insert([
                              'suratfk' =>$norec,
                              'isread' => false,
                              'status' => !$paraf ?'RQ': null,
                              'isttd' => false,
                              'pegawaifk' => $ttd[$no++]
                    ]);
               }
          }

               
          $obj =[
               "norec" => $norec,
               "statusenabled" => 1,
               "tujuan" => $req->tujuan,
               "nosurat" => $req->nosurat,
               "lamp" => $req->lamp,
               "lembarlampiran" => $req->lampiransurat,
               "tanggal" => $req->tgl,
               "bodysurat" => $req->isisurat,
               "perihal" => $req->perihal,
               "tembusan" => $tembusan,
               "isread" => 1,
               "pegawaifk" => Auth::user()->pegawaifk,
               "asalsurat" => $this->getAsalSurat(Auth::user()->pegawaifk)
               // "created_at" => date('Y-m-d h:i:s')
          ];


          if( $norectEdit != "" ){
               $simpan = Surat::where("norec",$norectEdit)->update($obj);
               $keterangan = "Melakukan revisi surat";
               // $simpan = Surat::firstOrFail()->where('norec', $norectEdit) ;
          } else{
               $simpan = Surat::create($obj);
               $keterangan = " Proses Buat surat ";
          }
          
          $lampiran = $req->file('lampiran');

          if ($lampiran) {
               $no =1;
               foreach($lampiran as $image)
               {
                    $ext = $image->getClientOriginalExtension();
                    $lampiranname = "L" .$no++. $norec . "." . $ext;
                    $originalName = $image->getClientOriginalName();
                    $image->move(public_path("/Lampiran/"), $lampiranname);

                    Lampiran::insert([
                         'id' =>$lampiranname,
                         'suratfk' =>$norec,
                         'filename' => $lampiranname,
                         'originalname' => $originalName
                    ]);
               }
          }

          ParafController::setFirstparaf($norec);
          ManageSurat::Updated_statusSurat($norec,"RQ");
          ManageSurat::saveHistory($norec, $keterangan,"bs");



// PUSH NOTIFIKASI KE ANDROID ===================================================================================================================================================================================================================================================
          $title = "Request Paraf";
          $message= "No. ".$req->nosurat." Hal : ".$req->perihal;

          $token =  DB::select(DB::raw("
               SELECT top 1  pg.id, pg.tokenfirebase from esurat_t as es 
               JOIN parafby_t as pf on pf.suratfk = es.norec
               join pegawai_m as pg on pg.id = pf.pegawaifk
               JOIN jabatan_m as jb on jb.id = pg.jabatansuratfk

               WHERE es.norec ='".$norec."'
               ORDER BY jb.nourut asc
          "));

          $tokenTujuan = $token[0]->tokenfirebase;
          // $notif =  NotifikasiController::sentNotificationByParam($tokenTujuan,$title,$message);
          // $notif =  NotifikasiController::sentNotificationFromApache($tokenTujuan,$title,$message);
          // $notif = json_encode($notif);

          DB::commit();

          $this->setSession();
          return back()->with("success","Berhasil ...");
          
        } catch (\Exception $th) {
          DB::rollback();
          // dd($th);
          return back()->with("error","Gagal simpan data ..." . $th->getMessage());
          
        }
     }

     public function previewSurat($suratfk, $t, Request $req){
          // dd($t, Auth::user()->key);
     try {
               //code...
          $pejabat = ManageSurat::getPejabat();
          $pegawaifk = Auth::user()->pegawaifk;
          $parafSingle = array();
          $TTDSingle = array();


          if($t==Auth::user()->key){
               TTD::where("suratfk",$suratfk)
               ->where("pegawaifk",$pegawaifk)    

               // update is read = 1 dengan user yang login 
               ->update(["isread"=>  Session::get('userfk') == $pegawaifk ? "1":"0"]);
               $TTDSingle = ManageSurat::getTTDSingle($suratfk, $pegawaifk);
          }else{
               Paraf::where("suratfk",$suratfk)
               ->where("pegawaifk",$pegawaifk)     
               ->update(["isread"=> 1]);
               $parafSingle = ManageSurat::getParafSingle($suratfk, $pegawaifk);
          }

          $data = DB::table("esurat_t as es")
          ->join("pegawai_m as pg","pg.id","es.tujuan")
          ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
          ->leftJoin("disposisiesurat_t as dis","es.norec","=","dis.suratfk")
          ->select("es.*","namajabatansurat","dis.norec as disNorec")
          ->where("es.norec",$suratfk)
          ->first();

          // dd($data);


          $ttd = ManageSurat::getTTD($suratfk);
          // dd($ttd);
          $paraf = ManageSurat::getParaf($suratfk);
          $statusttd = ManageSurat::getStatusTandaTangan($suratfk);
          $statusparaf = ManageSurat::getStatusParaf($suratfk);
          $lampiran = Lampiran::where("suratfk","=",$suratfk)->get();

          $getWadirForDisposisi = ManageSurat::getWadirForDisposisi();

          // update isread menjadi 1
          Surat::where("norec","=",$suratfk)->update(["isread"=>"1"]);
          $back = $req->back;
          $obj =[];
          if($back){
               Session::put("back",$back);
               switch ($back) {
                    case 'Inbox':
                         $obj =[ "isreadinbox"=>"1"];
                    break;                    
                    
                    case 'Outbox':
                         $obj =[ "isreadoutbox"=>"1"];
                    break;
               }

               Surat::where("norec","=",$suratfk)->update($obj);
          } else{
               Session::put("back","home");
          }

          InboxController::setReadInbox();

          
          
          // $sections = explode(',', $data->tembusan);
          // $tembusan = Pegawai::whereIn("id",$sections)->toSql();

          // $tembusan = DB::select("select namalengkap from pegawai_m where id in (".$data->tembusan.")");

           $in = str_replace('"','',$data->tembusan);
           
         
          $tembusan = DB::table("pegawai_m as pg")
                    ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
                    ->whereRaw("pg.id in (".$in.")")
                    ->select("pg.namalengkap","jb.namajabatansurat")
                    ->get();
           
          
          // dd($data->tembusan);

          // $ada = $data->tembusan == 'null' ? 'kosong':'berisi';

          // $tembusan = $data->tembusan == 'null' ? null: $tembusan;

          if( $data->tembusan == 'null' ||  $data->tembusan == null){
               $tembusan = null;
          }  


          // dd($getWadirForDisposisi);
          
          // dd($TTDSingle);
          $tanggal = $this->formatIndo($data->tanggal);
          // dd($ttd);
          return view("Surat/PreviewSurat/PreviewSurat",
               compact("data","tanggal","ttd","paraf","parafSingle","TTDSingle", 
               "statusparaf","lampiran","pejabat","getWadirForDisposisi","tembusan"));
     } catch (\Exception $th) {
          return $th->getMessage();
          // return redirect()->back()->with("error",$th->getMessage());
     }
     }


     public function suratMasuk(){

          return view("Surat/SuratMasuk");

     }     

     public function previewSuratRes($suratfk){
     try {
          $data = DB::table("esurat_t as es")
          ->join("pegawai_m as pg","pg.id","=","es.tujuan")
          ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
          ->leftJoin("disposisiesurat_t as dis","es.norec","=","dis.suratfk")
          ->leftJoin("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
          ->leftJoin("parafby_t as pf","pf.suratfk","=","es.norec")
          ->select("es.*","pg.namalengkap","dis.norec as disNorec","ttd.tandatangankey",
               "ttd.pegawaifk as ttdby","pf.pegawaifk as tujuanparaf","pf.isparaf","jb.namajabatansurat"
          )
          ->where("es.norec",$suratfk)
          // ->orderBy("pf.isparaf","asc")
          ->first();

          $ttd = DB::table("tandatanganby_t as ttd")
          ->join("pegawai_m as pg","pg.id","ttd.pegawaifk")
          ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
          ->select("jb.namajabatan","pg.namalengkap","pg.nippns")
          ->where("ttd.suratfk","=", $suratfk )
          ->first();

          $paraf = ManageSurat::getParaf($suratfk);
 
          $in = str_replace('"','',$data->tembusan);
          $tembusan = DB::table("pegawai_m as pg")
                    ->join("jabatan_m as jb","jb.id","=","pg.jabatansuratfk")
                    ->whereRaw("pg.id in (".$in.")")
                    ->select("pg.namalengkap","jb.namajabatansurat")
                    ->get();
                     
          if( $data->tembusan == 'null' ||  $data->tembusan == null){
               $tembusan = null;
          }  


          $tanggal = $this->formatIndo($data->tanggal);

          return response()->json([
               "data"=>$data,
               "tanggal"=>$tanggal,
               "tembusan"=>$tembusan,
               "res"=>1,
               "ttd"=>$ttd,
               "msg"=>"ok",
               "paraf"=>$paraf
          ]);
     } catch (\Exception $th) {
          return response()->json([
               "res"=>0,
               "msg"=>$th->getMessage()
          ]);
     }



     

     }
}
