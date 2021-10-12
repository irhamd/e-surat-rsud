<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Surat;
use App\Inbox\Inbox;
use App\ManageSurat;
use DB;
use Auth;
use Session;

class DisposisiController extends Controller
{
    public function Disposisi( Request $req ){
        $data = DB::table('esurat_t as es')
        ->join('disposisiesurat_t as dis',"dis.suratfk","es.norec")
        ->join("pegawai_m as pg","pg.id","es.tujuan")
        ->join('tandatanganby_t as ttd',"es.norec","ttd.suratfk")
        ->select("es.norec as norecsurat","es.perihal","pg.namalengkap","es.asalsurat",
            "ttd.updated_at as tglttd", "es.tanggal","es.nosurat","es.tujuan","dis.*")
        ->where("dis.assisten_pegawaifk","=", Auth::user()->pegawaifk);
        // ->orWhere("es.tujuan","=", Auth::user()->pegawaifk);
        
        if( isset($req->tanggal) && $req->tanggal!="" ){
            $tgl = "'".str_replace("--","' and '",$req->tanggal)."'";
            $data = $data->whereRaw("es.tanggal between  ". $tgl);
         }
         if( isset($req->nomorsurat) && $req->nomorsurat!=""){
               $data = $data->where('es.nosurat','like','%'.$req->nomorsurat.'%');
         }

         if( isset($req->perihal) && $req->perihal!=""){
               $data = $data->where('es.perihal','like','%'.$req->perihal.'%');
         }
        //  dd($data->get() , Auth::user()->pegawaifk);

        //  $data = $data->tosql();
        // ->where()
        // ->where("dis.pegawaifk", Auth::user()->pegawaifk)


        // JIKA ADA PARAMATER GET getRes Maka return dengan JSON
        if(isset($req->getRes) &&  $req->getRes != ""){
            $data = $data->limit(100)->get();
            return response()->json($data);
        } else{
            $data = $data->paginate(15)
            ->appends(request()->query());

            return view("Surat/Disposisi/Disposisi", compact("data"));
        }

    }

    public function lembarDisposisi(){
        $data = DB::table('esurat_t')->get();
        // dd($data);
            return view("Surat/Disposisi/LembarDisposisi", compact("data"));
    }

    public function getSingleDataDisposisi(Request $req){
        $data = DB::table('esurat_t as es')
        ->join('disposisiesurat_t as dis',"dis.suratfk","es.norec")
        ->join('inboxesurat_t as ib','ib.norec_disposisiesurat','=','dis.norec')
        ->join("pegawai_m as pg","pg.id","es.tujuan")
        // ->join('tandatanganby_t as ttd',"es.norec","ttd.suratfk")
        ->select("es.norec as norecsurat","es.perihal","pg.namalengkap","es.asalsurat",
             "es.tanggal","es.nosurat","es.tujuan","dis.*")
        ->where("es.norec","=",$req->suratfk)
        // ->where("ib.tujuanfk","=",$req->pegawaifk)
        ->get();

        // dd($req->pegawaifk);
        
        return response()->json($data);
        // dd($data);
            // return view("Surat/Disposisi/LembarDisposisi", compact("data"));
    }


    public static function simpanDataDisposisi(Request $req, $norec){
    try {

        // dd($req, $norec);
        DB::beginTransaction();
        // khusus untuk tombol disposisi di tujuan
        $dis = $req->disposisiW;
        // dd($dis[1]);

        // dd(json_encode($dis));

        $data = DB::table("disposisiesurat_t");

        // $norecdisposisi = $data->first();
        // $norecdisposisi = $norecdisposisi->norec;
        // $obj['noagenda'] =  "orangg";
    
        if($dis){
            $dataNorec = $data->select("norec")->where('suratfk',"=",$norec)->first();
            $no =0;
            foreach ($dis as $item) {
                $inbox = Inbox::create([
                    'norec'=>ManageSurat::getRandomString(),
                    "statusenabled" => true,
                    "tujuanfk"=>$dis[$no],
                    "suratfk"=>$norec,
                    "norec_disposisiesurat"=>$dataNorec->norec,
                    "isread" => false,
                    "ket" =>$req->denganhormat,
                    "isdisposisi"=> true,
                    "diskripsifk"=>"4"
                ]);
                $token = NotifikasiController::getTokenPegawaiById($dis[$no]);
                $no++;
                NotifikasiController::sentNotificationByParam($token," Disposisi Surat ","Terdapat surat yang didisposisikan  kepada anda .");

                ManageSurat::saveHistory($norec, "Disposisikan Surat Internal","ipin");
                
            }
        } else{
            $obj['noagenda'] =  $req->noagenda;
            $data =$data->where('norec',"=",$norec)->update($obj);
            ManageSurat::saveHistory($norec, "Inpt nomor agenda ","ipa");

        }

        // dd($obj);


        Session::put("jlhDisposisi",ManageSurat::jlhDisposisi());   

        if($data || $inbox){
            $ses = 'success';
            $msg = 'Berhasil ...';
            DB::commit();
        } else{
            $ses = 'error';
            $msg = 'Gagal ...';
            DB::roolback();
        }

    } catch (\Exception $th) {
        $ses = 'error';
        $msg = 'Gagal ... /code '. $th->getMessage();   
    }
    // return $msg;
    return redirect()->back()->with($ses, $msg);
    }


    public static function simpanDataDisposisiExternal(Request $req, $norec){
        try {
    
            DB::beginTransaction();
            $dis = $req->disposisiW;
            $data = DB::table("disposisiesurat_t");
            
            if( Auth::user()->jabatanesurat == 'dir' &&  isset($dis) ){
                $norecDisposisi = $data->select("norec")->where('suratfk',"=",$norec)->first();

                // dd($norecDisposisi->norec);

                $no =0;
                foreach ($dis as $item) {

                    $inbox = Inbox::where("suratfk","=",$norec)
                    ->where("norec_disposisiesurat","=",$norecDisposisi->norec)
                    ->where("tujuanfk","=",$dis[$no])
                    ->delete(); 

                    $inbox = Inbox::create([
                        'norec'=>ManageSurat::getRandomString(),
                        "statusenabled" => true,
                        "tujuanfk"=>$dis[$no],
                        "suratfk"=>$norec,
                        "norec_disposisiesurat"=>$norecDisposisi->norec,
                        "isread" => false,
                        "ket" =>implode(',', $req->denganhormat),

                        // JIKA WADIR YG LOGIN MAKA DESKRIPSI = 3 =>Disposisi Wadir, 4=Breakdown Disposisi
                        "diskripsifk" => "3",
                        // "isdisposisi"=> true
                    ]);


                    $token = NotifikasiController::getTokenPegawaiById($dis[$no]);
                    $no++;
                    NotifikasiController::sentNotificationByParam($token," Disposisi Surat ","Terdapat surat yang didisposisikan  kepada anda .");
                }
            } 

            // dd($req);
            $inbox = Inbox::where("suratfk","=",$norec)->where('tujuanfk',"=", Auth::user()->pegawaifk)
            ->update([
                "catatandisposisi"=>$req['catatan'],
                "mark_pegawaifk"=> isset($req->assignto) ? implode(',', $req->assignto) : "-"
            ]);


           
            
            
            ManageSurat::saveHistory($norec, "Disposisikan Surat external","ipex");
            Session::put("jlhDisposisi",ManageSurat::jlhDisposisi());   
            
    
            if($inbox){
                $ses = 'success';
                $msg = 'Berhasil ...';
                DB::commit();
            } else{
                $ses = 'error';
                $msg = 'Gagal ...';
                DB::rollback();
            }
    
        } catch (\Exception $th) {
            $ses = 'error';
            $msg = 'Gagal ... /code '. $th->getMessage();   
        }
        // return $msg;
        return redirect()->back()->with($ses, $msg);
        }


    public function updateKomentarDisposisi(Request $req)
    {
    try {
        DB::beginTransaction();
            //code...
        $mark = $req['mark_pegawaifk'];

        if(isset($mark)){

            $arr = explode(",",$mark);
            $no =0;
            foreach ($arr as $item) {
                if($arr[$no] == Auth::user()->pegawaifk){
                    continue;
                }

                $inbox = Inbox::create([
                    'norec'=>ManageSurat::getRandomString(),
                    "statusenabled" => true,
                    "tujuanfk"=>$arr[$no],
                    "suratfk"=>$req['suratfk'],
                    "norec_disposisiesurat"=>$req['norec_disposisi'],
                    "isread" => false,
                    "ket" =>'Breakdown Disposisi',
                    "diskripsifk" =>'4',
                ]);

                $inbox = Inbox::where("suratfk","=",$req['suratfk'])->where('tujuanfk',"=", Auth::user()->pegawaifk)
                ->update([
                    "catatandisposisi"=>$req['komentar'],
                    "mark_pegawaifk"=>$mark
                ]);


                $token = NotifikasiController::getTokenPegawaiById($arr[$no]);
                $no++;
                NotifikasiController::sentNotificationByParam($token," Disposisi Surat ","Terdapat surat yang didisposisikan  kepada anda .");

            }
        }

        $save = Inbox::where("tujuanfk","=", Auth::user()->pegawaifk)
        // ->where("norec_disposisiesurat","=", $req['norec_disposisi'])
        ->where("suratfk","=",$req['suratfk'])
        ->update([
            "catatandisposisi"=>$req['komentar'],
            "isdisposisi"=>true,
            "mark_pegawaifk"=>$req['mark_pegawaifk']
        ]);

        ManageSurat::saveHistory($req['suratfk'], "Breakdown disposisi Surat Internal ke ".$req['ket'],"dis");


        $msg = "Berhasil ...";
        DB::commit();

        return response()->json( $msg );
        
    } catch (\Exception $th) {
        DB::rollback();
        $msg = "Gagal . ".$th->getMessage();
        return response()->json( ["msg"=> $msg ] );
    }
    

    }

    public function FunctionName(Type $var = null)
    {
        $inbox = Inbox::create([
            'norec'=>ManageSurat::getRandomString(),
            "statusenabled" => true,
            "tujuanfk"=>$surat->tujuan,
            "suratfk"=>$surat->norec,
            "isread" => false,
            "ket" =>"Request Disposisi"
        ]);

        DB::table("disposisiesurat_t")->insert([
            'norec' =>  Str::random(15) . date("mdYHis"),
            'statusenabled'=>true,
            'suratfk'=>$suratfk,
            'terimatgl'=>\Carbon\Carbon::now(),
            'assisten_pegawaifk'=>ManageSurat::getAsistenPegawai($surat->tujuan)
        ]);

    }

    public static function simpanSebarSurat(Request $req){
    try {
        DB::beginTransaction();
        $arr = explode(",",$req->sebarkan);

        $i = 0;

        foreach ($arr as $item) {

            $cek = DB::table("pegawai_m")->where("jenisjabatan","=",$item)
            ->where("statusenabled","=",true)
            ->select("id","jenisjabatan")->get();

            foreach ($cek as $key) {
                
                $inbox = Inbox::create([
                    'norec'=>ManageSurat::getRandomString().$key->id,
                    "statusenabled" => true,
                    "tujuanfk"=>$key->id,
                    "suratfk"=>$req['suratfk'],
                    "norec_disposisiesurat"=>$req['norec_disposisi'],
                    "isread" => false,
                    "ket" =>'sebar',
                    "diskripsifk" =>$req['diskripsifk'],
                    "statuscode" =>"9"
                ]);
            }

        }

        DB::commit();
        $msg = "Suksess ....";


    } catch (\Exception $th) {
        DB::rollback();
        $msg = "Gagal . ".$th->getMessage();
    }
    
        return response()->json( ["msg"=> $msg ] );
    }


 

    
}    
