<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use App\TTD;
use App\ManageSurat;
use App\Surat;
use App\Http\Controllers\NotifikasiController;
use App\Pegawai;
use App\Inbox\Inbox;
use Illuminate\Support\Str;
use App\Http\Controllers\SuratController;

class TandaTanganController extends Controller
{
    public function requestttd(Request $req){
        $ttd = DB::table("esurat_t as es")
        ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        ->leftJoin("statusesurat_m as stt","stt.kdstatus","ttd.status")
        ->select("es.*","ttd.isread as isreadttd","ttd.isttd","ttd.status","stt.ket",
             DB::raw("case when ttd.isttd=1 then 'Paraf' else 'Request' end as rstatus"),
            //  DB::raw("case when ttd.isttd=1 then 'Paraf' else 'Request' end as rstatus"),
             DB::raw("case when (ttd.isttd=0 and ttd.status='RJ') then 'red' when (ttd.isttd=0 and ttd.status='RV') then 'aqua' 
              when ttd.isttd=1 then 'green' when ttd.isttd=0 then 'yellow'  end as class")
             )

            //  DB::raw("case when (ttd.isttd=0 and ttd.status='RJ') then 'red' when (ttd.isttd=0 and ttd.status='RV') then 'danger' 
            //   when ttd.isttd=1 then 'success' when ttd.isttd=0 then 'warning'  end as class")
            //  )

        ->where("ttd.pegawaifk","=",Auth::user()->pegawaifk);

        $whereIn =[];

        if($req->nomorsurat){
            $ttd = $ttd->where('es.nosurat','like','%'.$req->nomorsurat.'%');
        }
 
        if( isset($req->perihal)){
            $ttd = $ttd->where('es.perihal','like','%'.$req->perihal.'%');
        }


        if( isset($req->tanggal)){
            $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
            $ttd = $ttd->whereRaw("es.tanggal between ". $tgl);
        }

        if( isset($req->approve) && $req->approve!=""){
            // $whereIn = $whereIn .",TTD";
            array_push($whereIn,"ttd");
        }
                
        if( isset($req->requ) && $req->requ!=""){
            array_push($whereIn,"rq");
                // $ttd = $ttd->orWhere('es.statussurat','=','rq');
        }          
        
        if( isset($req->revisi) && $req->revisi!=""){
            array_push($whereIn,"rv");
                // $ttd = $ttd->orWhere('es.statussurat','=','rv');
        }

        if( isset($req->reject) && $req->reject!=""){
            array_push($whereIn,"rj");
          
                // $ttd = $ttd->orWhere('es.statussurat','=','rj');
        }

        // dd($whereIn);

        if( count($whereIn) > 0 ){
            $ttd = $ttd->whereIn("ttd.status",$whereIn);
        }

        $ttd = $ttd->orderBy("es.updated_at","desc")

        ->paginate(10)
        ->appends(request()->query());
        // $this->setSession();
        // $ttd = DB::table("esurat_t as es")
        // ->join("tandatanganby_t as ttd","ttd.suratfk","=","es.norec")
        // ->select("es.*","ttd.isread","ttd.isttd","ttd.status",DB::raw("case when ttd.isttd= 1 then 'TTD' else 'Request' end as rstatus"))
        // ->where("ttd.pegawaifk","=",Auth::user()->pegawaifk)
        // ->orderBy("ttd.isttd")
        // // ->where("ttd.status", true)
        // ->get();
        // dd($paraf);
        return view("TandaTangan/RequestTandaTangan",compact("ttd"));
    }

    public function setTTD($suratfk){
    // try {
        $st ="TTD";
        DB::beginTransaction();

        $surat = Surat::where("norec","=",$suratfk)->first();
        $pegawaiId = Auth::user()->pegawaifk;

        $pegawai = Pegawai::where("id",$pegawaiId)->first();

        $inbox = Inbox::create([
            'norec'=>ManageSurat::getRandomString(),
            "statusenabled" => true,
            "tujuanfk"=>$surat->tujuan,
            "suratfk"=>$surat->norec,
            "isread" => false,
            "ket" =>"Request Disposisi",
            "diskripsifk" =>"8",
        ]);

        $asisten = ManageSurat::getAsistenPegawai($surat->tujuan);

        DB::table("disposisiesurat_t")->insert([
            'norec' =>  Str::random(15) . date("mdYHis"),
            'statusenabled'=>true,
            'suratfk'=>$suratfk,
            'terimatgl'=>\Carbon\Carbon::now(),
            'assisten_pegawaifk'=>$asisten
        ]);

        // if($asisten){
        //     $tokenTujuan =  NotifikasiController::getTokenPegawaiById($asisten);
        //     NotifikasiController::sentNotificationByParam($tokenTujuan,"Permohonan Persetujuan Surat","Terdapat surat masuk untuk atasan anda ...");
        // } else{
        //     $tokenTujuan =  NotifikasiController::getTokenPegawaiById($asisten);
        //     NotifikasiController::sentNotificationByParam($tokenTujuan,"Permohonan Persetujuan Surat","Terdapat surat masuk untuk anda ...");
        // }

        $ttd = $surat->nosurat ."#".$surat->perihal."#".$surat->tanggal."#". $pegawai->namalengkap."#".
            \Hash::make(date('YMdHis'. $pegawaiId.Str::random(15)));
            // \Hash::make(date('YMdHis'. $pegawaiId.Str::random(5)));

        TTD::where("suratfk",$suratfk)
        ->where("pegawaifk",$pegawaiId)
        ->update([
            "isttd"=> 1,
            'status'=>$st,
            'tandatangankey'=>$ttd
            ]);
        // Surat::where("norec",$suratfk)
        // ->update([
        //     'tandatangankey'=>\Hash::make(date('YMdHis'. Auth::user()->pegawaifk.Str::random(5)))
        //     ]);
        // ManageSurat::Updated_atSurat($suratfk);
        ManageSurat::Updated_statusSurat($suratfk,$st);
        // Surat::where("norec","=",$suratfk)->update(["isread"=>"0"]);

        $sess ="success";
        $msg = "Berhasil tanda tangan ...";
        SuratController::setSession();
        DB::commit();
        ManageSurat::saveHistory($suratfk, "Tandatangan Surat","rj");

    // } catch (\Throwable $th) {
    //     $sess ="error";
    //     $msg = "Gagal tanda tangan ..."; 
    //     DB::rollback();
    // }
    // dd($th);

    return redirect()->back()->with($sess,$msg);
   }

    public function setTTDRes($suratfk, $pegawaifk){
    try {
        $st ="TTD";
        DB::beginTransaction();

        $surat = Surat::where("norec","=",$suratfk)->first();
        // $pegawaifk = Auth::user()->pegawaifk;

        // $pegawai = Pegawai::where("id",$pegawaifk)->first();
        // $pegawai = Pegawai::where("id",$pegawaifk)->first();

        $inbox = Inbox::create([
            'norec'=>ManageSurat::getRandomString(),
            "statusenabled" => true,
            "tujuanfk"=>$surat->tujuan,
            "suratfk"=>$surat->norec,
            "isread" => false,
            "ket" =>"Request Disposisi",
            "diskripsifk" =>"8",
        ]);

        $asisten = ManageSurat::getAsistenPegawai($surat->tujuan);

        DB::table("disposisiesurat_t")->insert([
            'norec' =>  Str::random(15) . date("mdYHis"),
            'statusenabled'=>true,
            'suratfk'=>$suratfk,
            'terimatgl'=>\Carbon\Carbon::now(),
            'assisten_pegawaifk'=>$asisten
        ]);

        $nosurat = $surat->nomorsurat;
        $perihal = $surat->perihal;

        $pegawai = $asisten ?  $asisten : $surat->tujuan ;
 
        $tokenTujuan =  NotifikasiController::getTokenPegawaiById($pegawai);
        NotifikasiController::sentNotificationByParam($tokenTujuan,"Permohonan Persetujuan Surat",$nosurat." ".$perihal);
        
        $ttd = $surat->nosurat ."#".$surat->perihal."#".$surat->tanggal."#"."#".
            \Hash::make(date('YMdHis'. $pegawaifk.Str::random(15)));
            // \Hash::make(date('YMdHis'. $pegawaifk.Str::random(5)));

        TTD::where("suratfk",$suratfk)
        ->where("pegawaifk",$pegawaifk)
        ->update([
            "isttd"=> 1,
            'status'=>$st,
            'tandatangankey'=>$ttd
            ]);
        // Surat::where("norec",$suratfk)
        // ->update([
        //     'tandatangankey'=>\Hash::make(date('YMdHis'. Auth::user()->pegawaifk.Str::random(5)))
        //     ]);
        // ManageSurat::Updated_atSurat($suratfk);
        ManageSurat::Updated_statusSurat($suratfk,$st);
        // Surat::where("norec","=",$suratfk)->update(["isread"=>"0"]);

        $sess ="1";
        $msg = "Berhasil tanda tangan ...";
        // SuratController::setSession();
        ManageSurat::saveHistoryRes($suratfk, "Tandatangan Surat","ttd", $pegawaifk);
        DB::commit();

    } catch (\Exception $th) {
        DB::rollback();
        $sess ="0";
        $msg = "Gagal tanda tangan ...".$th->getMessage(); 
    }
    // dd($th);

    return response()->json(["ses"=> $sess, "msg"=>$msg,"ttd"=>$ttd]);
   }


   public function rejectByTandaTangan( Request $req, $suratfk){
    try {
        $st ="RJ";
        DB::beginTransaction();

        $surat = Surat::where("norec","=",$suratfk)->first();
        $pegawaiId = Auth::user()->pegawaifk;

        $pegawai = Pegawai::where("id",$pegawaiId)->first();



        $ttd = "REJECT #". $surat->nosurat ."#".$surat->perihal."#".$surat->tanggal."#". $pegawai->namalengkap."#".
            \Hash::make(date('YMdHis'. $pegawaiId.Str::random(15)));
            // \Hash::make(date('YMdHis'. $pegawaiId.Str::random(5)));

        TTD::where("suratfk",$suratfk)
        ->where("pegawaifk",$pegawaiId)
        ->update([
            "isttd"=> "0",
            'status'=>$st,
            'tandatangankey'=>$ttd
            ]);

    
        // Surat::where("norec",$suratfk)
        // ->update([
        //     'tandatangankey'=>\Hash::make(date('YMdHis'. Auth::user()->pegawaifk.Str::random(5)))
        //     ]);
        // ManageSurat::Updated_atSurat($suratfk);
        ManageSurat::Updated_statusSurat($suratfk,$st);
        Surat::where("norec","=",$suratfk)->update(["isread"=>"0"]);
        ManageSurat::saveHistory($suratfk, "Reject Tandatangan","rjttd");

        $sess ="success";
        $msg = "Reject tanda tangan ...";
        SuratController::setSession();
        DB::commit();
    } catch (\Throwable $th) {
        $sess ="error";
        $msg = "Gagal tanda tangan ..."; 
        DB::rollback();
    }

    return redirect()->back()->with($sess,$msg);

    
    }


    public function setDisposisiRes(Request $req){
        try {
            DB::beginTransaction();
            $attempt =  Surat::where("norec","=",$req->suratfk)->update([
                'disposisi'=>$req->pegawaifk,
                'isread'=>"0"
            ]);

            $stt = 1; 
            $sess ="success";
            $msg = "Suksess ...";
    
            SuratController::setSession();
            DB::commit();
        } catch (\Exception $th) {
            $stt = 0; 
            $sess ="error";
            $msg = "Gagal ..."; 
            DB::rollback();
        }
    
        return response()->json([
            'stt' => $stt,
            'msg' => $msg,
            'sess' => $sess
        ]);
       }

       public function tandaTanganRes( Request $req )
       {
            try {
               $ttd = DB::select("
               SELECT es.perihal , es.nosurat ,ttd.isread,ttd.status, ttd.suratfk from tandatanganby_t as ttd
               join esurat_t as es on es.norec = ttd.suratfk 
               where ttd.pegawaifk= ". $req['tujuanfk']." 
               order by es.created_at desc" );
                    
            } catch (\Exception $th) {
                $ttd = [];       
            }
                return response()->json(["record" =>$ttd]);
        }
}

