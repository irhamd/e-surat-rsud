<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class NotifikasiController extends Controller
{

    public function getTokenPegawai($suratfk){

        return DB::select(DB::raw("
            SELECT top 1  pg.id, pg.tokenfirebase from esurat_t as es 
            JOIN parafby_t as pf on pf.suratfk = es.norec
            join pegawai_m as pg on pg.id = pf.pegawaifk
            JOIN jabatan_m as jb on jb.id = pg.jabatansuratfk

            WHERE es.norec ='".$suratfk."'
            ORDER BY jb.nourut asc
        "))->first();
    }

    public static function getTokenPegawaiById($pegawaifk){

        $data = DB::table("pegawai_m as pg")
        // ->join("jabatan_m as jb","pg.jabatansuratfk","jb.id")
        ->select("pg.id","pg.tokenfirebase")
        ->where("pg.id","=",$pegawaifk)
        ->first();

        return $data->tokenfirebase;

    }


    
    public static function sentNotification( Request $req ){

        $serverKey = "key=AAAAT5eDlNo:APA91bE4lkOBzNvAsvEU8IGMDUn1RgjJkEkhTYA9h05nObBeFa2yamqsDv0I05J68tUxHPMeyHCDSVfR82yfP5pOvltfDXIEuC4QenC7OBF0VHVkfxABWuwGL2yqxrJTrdV9R0iOQYBx";

        $ch=curl_init("https://fcm.googleapis.com/fcm/send");
        $header=array("Content-Type:application/json","Authorization:".$serverKey);
        //to topic means am using all device
        //$data=json_encode(array("to"=>"/topics/allDevices","notification"=>array("title"=>$req['title'],"message"=>$req['message'])));
        //$data=json_encode(array("to"=>"fVHH4Dz_vKo:APA91bFFaxnUbX1U5IaDjJR4Hy3ewEX8QSjsCXHDTVLXPGToK0HU0dnItAUqHsPDkLTn6jGoiq5LK4mqiCyWtvrM_xPn2GwgTHbuc5rInJ0f2Us2iUmqIIwSBH_Fg1czVDPBbhJsgrnc","notification"=>array("title"=>$req['title'],"message"=>$req['message'])));


        //now let's see data message
        $data=json_encode(array("to"=>$req['token'],"data"=>array("title"=>$req['title'],"message"=>$req['message'])));
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_exec($ch);

    }

    public static function sentNotificationByParam_lama( $tokenTujuan, $title, $message ){
       $serverKey = "key=AAAAT5eDlNo:APA91bE4lkOBzNvAsvEU8IGMDUn1RgjJkEkhTYA9h05nObBeFa2yamqsDv0I05J68tUxHPMeyHCDSVfR82yfP5pOvltfDXIEuC4QenC7OBF0VHVkfxABWuwGL2yqxrJTrdV9R0iOQYBx";
        $ch=curl_init("https://fcm.googleapis.com/fcm/send");
        $header=array("Content-Type:application/json","Authorization:".$serverKey);

        $data=json_encode(array("to"=>$tokenTujuan,"data"=>array("title"=>$title,"message"=>$message)));
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_exec($ch);

        return curl_exec($ch);

    }

    public static function sentNotificationByParam( $tokenTujuan, $title, $message ){

        $arr =  explode(":",  url("/")); 
        $base = "";
        $port = ":6789";
        switch ($arr[1]) {
            case '//localhost':
            case '//127.0.0.1':
                // $base = '//103.228.236.58'.$port;
                $base = '//172.16.75.229'.$port;
                break;            
                
            case '//172.16.75.229':
            case '//103.228.236.58':
                $base = $arr[1].$port;
                break;
        }

        // $tokenTujuan = "eRj0hCmPaAU:APA91bFbFJAuevtQx47nvkfR-C3jyCJvC2TjVMT2rxYV9It7pBfDMJn88WwL1LnTxMqjDa9hQL8LJDxMu1S0fFJrfXVxlsDqg-ocxkdvxZdW8rKbGWrpGRl8g15ptcokZrwOFAty9QV-";
        $uri = "http:".$base."/send?title=".$title."&message=".$message."&to=".$tokenTujuan;

        $client = new \GuzzleHttp\Client();
        $request = $client->get($uri);
        $response = $request->getBody();

        return $response;
           

    }



    public static function sentNotificationFromApache( $tokenTujuan, $title, $message ){

        $arr =  explode(":",  url("/")); 
        
        // return $arr;
         
        // if ($arr[1] == '//localhost' || $arr[1] == '//127.0.0.1' || $arr[1] == '172.16.0.217')
        $base = "";
        $port = ":6789";
        switch ($arr[1]) {
            case '//localhost':
            case '//127.0.0.1':
                // $base = $arr[1];
                // $base = "//172.16.0.217".$port;
                $base = '//103.228.236.74'.$port;
                break;            
                
            case '//172.16.0.217':
            case '//103.228.236.74':
                $base = $arr[1].$port;
                break;
        }

        $tokenTujuan = "eRj0hCmPaAU:APA91bFbFJAuevtQx47nvkfR-C3jyCJvC2TjVMT2rxYV9It7pBfDMJn88WwL1LnTxMqjDa9hQL8LJDxMu1S0fFJrfXVxlsDqg-ocxkdvxZdW8rKbGWrpGRl8g15ptcokZrwOFAty9QV-";
        $uri = "http:".$base."/send?title=".$title."&message=".$message."&to=".$tokenTujuan;
        // $uri = "http://103.228.236.74:6789/send/?title=".$title."&message=".$message."&to=eRj0hCmPaAU:APA91bFbFJAuevtQx47nvkfR-C3jyCJvC2TjVMT2rxYV9It7pBfDMJn88WwL1LnTxMqjDa9hQL8LJDxMu1S0fFJrfXVxlsDqg-ocxkdvxZdW8rKbGWrpGRl8g15ptcokZrwOFAty9QV-";
        // $uri = "http://172.16.0.217:6789/send/?title=".$title."&message=".$message."&to=eRj0hCmPaAU:APA91bFbFJAuevtQx47nvkfR-C3jyCJvC2TjVMT2rxYV9It7pBfDMJn88WwL1LnTxMqjDa9hQL8LJDxMu1S0fFJrfXVxlsDqg-ocxkdvxZdW8rKbGWrpGRl8g15ptcokZrwOFAty9QV-";

        $client = new \GuzzleHttp\Client();
        $request = $client->get($uri);
        $response = $request->getBody();

        return $response;
           
            // dd($response);

    }

    
    
}
