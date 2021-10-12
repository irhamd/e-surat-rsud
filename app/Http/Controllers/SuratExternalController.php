<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\SuratExternal;
use App\ManageSurat;
use App\Inbox\Inbox;
use Auth;
use App\Pejabat;
use App\Http\Controllers\NotifikasiController as Notif;


class SuratExternalController extends Controller
{

    public function suratExternalRev(Request $req){
        $pejabat = ManageSurat::getDirektur();
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
        ->paginate(10);
        // ->toSql();
        // dd($data);
        return view("Surat/SuratExternal/SuratExternalRev", compact("pejabat","data"));
   
      }

    // public function suratExternalRev( Request $req ){
    //     $pejabat = ManageSurat::getPejabat();
    //     $data = SuratExternal::where("pegawaifk","=",Auth::user()->pegawaifk)
    //         ->orWhere("assignto","like","%".Auth::user()->pegawaifk."%")
    //     ->paginate(10)
    //     ->appends(request()->query());

            
    //     // dd($data);
    //     return view("Surat/SuratExternal/SuratExternal", compact("pejabat","data"));
    // }
    
    public function simpanSuratExternal( Request $req ){
        // try {
            DB::beginTransaction();
            $norec = "EX-". date("mdYHisu").\Str::random(15);

            $notif = $req->assignto;
            // dd($req->assignto[1]);

            // $assignto = json_encode($req->assignto) ;
            $assignto = implode(',', $notif);

            // dd($assignto);

            $lampiran = $req->file('lampiran');
            // dd($lampiran);

            $ext = $lampiran->getClientOriginalExtension();
            $lampiranname = "Ex-" . $norec . "." . $ext;
            $lampiran->move(public_path("/SuratExternal/"), $lampiranname);
               

            $obj =[
                "norec"=>$norec,
                "statusenabled"=>true,
                "tanggal"=>$req->tanggal,
                "nosurat"=>$req->nosurat,
                "perihal"=>$req->perihal,
                "assignto"=>$assignto,
                "pegawaifk"=>Auth::user()->pegawaifk,
                "tujuan"=>$req->tujuan,
                "lampiran"=>$lampiranname,
                "asalsurat"=>$req->asalsurat
            ];
            $save = SuratExternal::create($obj);

            $i = 0;
            $token = "";

            // dd($notif);

            foreach ($notif as $item) {

                $norec_disposisi = null;
                $isdisposisi = null;

                if($req['isDisposisi']){
                    $norec_disposisi = ManageSurat::getRandomString();
                    $isdisposisi = true;
                    DB::table("disposisiesurat_t")->insert([
                        'norec' =>  $norec_disposisi,
                        'statusenabled'=>true,
                        'noagenda'=>$req['noagenda'],
                        'suratfk'=>$norec,
                        'terimatgl'=>\Carbon\Carbon::now(),
                        'assisten_pegawaifk'=>ManageSurat::getAsistenPegawai($item)
                    ]);
                }

                
                $inbox = Inbox::create([
                    'norec'=>ManageSurat::getRandomString(),
                    "statusenabled" => true,
                    "tujuanfk"=>$item,
                    "suratfk"=>$norec,
                    "isread" => false,
                    "norec_disposisiesurat" =>$norec_disposisi,
                    "isdisposisi"=> $isdisposisi ,
                    "ket" =>"Surat External",
                    "diskripsifk" =>"2"

                ]);

                // $inbox = Inbox::create([
                //     'norec'=>ManageSurat::getRandomString(),
                //     "statusenabled" => true,
                //     "tujuanfk"=>$surat->tujuan,
                //     "suratfk"=>$surat->norec,
                //     "isread" => false,
                //     "ket" =>"Request Disposisi"
                // ]);



                // $token =  Notif::getTokenPegawaiById($item);
                // $title = "Surat External";
                // $message = "No.".$req->nosurat. ", Perihal :  ".$req->perihal;
                // Notif::sentNotificationByParam($token,$title,$message);
                // ManageSurat::saveHistory($norec, "Input Surat external","ipex");

            }




            DB::commit();
            return back()->with("berhasil","Berhasil ...");
            
        //   } catch (\Exception $th) {
        //     DB::rollback();
        //     return back()->with("gagal","Gagal simpan data ..." . $th->getMessage());
            
        //   }
       }

       public function getLembarDisposisiSuratExternal($suratexternalfk)
       {

        $dis = Auth::user()->jabatanesurat;
        
        switch ($dis) {
            case 'dir':
               $where = "and it.diskripsifk in (2,3)";
                break;
            case 'wadir':
                $where = "and tujuanfk =".Auth::user()->pegawaifk;
                    break;
            
            default:
            $where = " and it.diskripsifk = '3'";
                break;
        }

           $data = DB::select("
           SELECT top 1 'ex' as jenissurat, dt.noagenda ,dt.norec as norec_disposisiesurat, et.*,it.catatandisposisi, it.ket, it.tujuanfk, it.mark_pegawaifk  from esuratexternal_t et 
           left join disposisiesurat_t dt on dt.suratfk  = et.norec 
            join inboxesurat_t it on it.norec_disposisiesurat  = dt.norec 
            where  et.norec = '".$suratexternalfk."' ".$where . " order by it.diskripsifk desc");

           // DISKRIPSIFK 3 ambil disposisi komentar wadir.

           return response()->json($data);
       }


}
