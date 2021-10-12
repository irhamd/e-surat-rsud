<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\ArsipSurat;

class ArsipSuratController extends Controller
{


  public function ArsipSuratBlade( Request $req)
  {
 
    $data = ArsipSurat::where("statusenabled",true);

    if( isset($req->tanggal)){
      $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
      $data = $data->whereRaw("tanggal between ". $tgl);
    } ;

    if( isset($req->nosurat)){
      $data = $data->where("nosurat", "like","%".$req->nosurat."%");
    };

    if( isset($req->perihal)){
      $data = $data->where("perihal", "like","%".$req->perihal."%");
    };

    $data = $data->paginate(10);



    return view("Surat\ArsipSurat\ArsipSurat", compact("data"));

  }

  public function hapusArsipSurat( Request $req)
  {
 
    $data = ArsipSurat::where("norec","=",$req['norec'])->delete();

    return response()->json([
      "status" => $data ? "Suksess ..." : "Gagal ...!"
    ]);

  }
  public function UploadArsipSurat( Request $req ){
      try {

        DB::beginTransaction();
        $norec = \Str::random(15).date("mdYHis");
        $lampiran = $req->file('lampiran');
      
        $ext = $lampiran->getClientOriginalExtension();
        $lampiranname = "AR-" . $norec . "." . $ext;

        $obj =[
          "norec"=>$norec,
          "statusenabled"=>true,
          "tanggal"=>$req->tanggal,
          "nosurat"=>$req->nosurat,
          "perihal"=>$req->perihal,
          "pegawaifk"=>\Auth::user()->pegawaifk,
          "tujuan"=>$req->tujuan,
          "noagenda"=>$req->noagenda,
          "lampiran"=>$lampiranname,
          "asalsurat"=>$req->asalsurat
        ];
        // $save = DB::table("arsipsurat_t")->insert($obj);
        $save = ArsipSurat::create($obj);
        $status = 1;
      
        DB::commit();

        
      } catch (\Exception $th) {
        DB::rollback();
        $status = 0;
      }

      if($status == 1){
        $lampiran->move(public_path("/SuratArsip/"), $lampiranname);
        return back()->with("success","Berhasil ...");
      } else{
        return back()->with("error","Gagal simpan data ..." . $th->getMessage());

      }
    }


    public function editArsipSurat( Request $req ){
      try {
        // dd($req);
        
        $obj =[
          "tanggal"=>$req->tanggal,
          "nosurat"=>$req->nosurat,
          "perihal"=>$req->perihal,
          "pegawaifk"=>\Auth::user()->pegawaifk,
          "tujuan"=>$req->tujuan,
          "noagenda"=>$req->noagenda,
          "asalsurat"=>$req->asalsurat
        ];

        DB::beginTransaction();
        
        if($req->file('lampiran')){
          $lampiran = $req->file('lampiran');
          $ext = $lampiran->getClientOriginalExtension();
          $lampiranname = "AR-" . $req['norec'] . "." . $ext;

          $obj =[
            "tanggal"=>$req->tanggal,
            "nosurat"=>$req->nosurat,
            "perihal"=>$req->perihal,
            "pegawaifk"=>\Auth::user()->pegawaifk,
            "tujuan"=>$req->tujuan,
            "noagenda"=>$req->noagenda,
            "asalsurat"=>$req->asalsurat,
            "lampiran"=> $lampiranname
          ];

        }


        // $save = DB::table("arsipsurat_t")->insert($obj);
        $save = ArsipSurat::where("norec","=",$req['norec'])->update($obj);
        $status = 1;
      
        DB::commit();

        
      } catch (\Exception $th) {
        DB::rollback();
        $status = 0;
      }

      if($status == 1){
        if($req->file('lampiran')){
            $lampiran->move(public_path("/SuratArsip/"), $lampiranname);
        }
        return back()->with("success","Berhasil ...");
      } else{
        return back()->with("error","Gagal simpan data ..." . $th->getMessage());

      }
    }

    


}
