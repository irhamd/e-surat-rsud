<?php

namespace App\Http\Controllers\Guzzle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuzzleController extends Controller
{
    public function getGuzzleRequest( Request $req )
    {

        // return $req;

        $client = new \GuzzleHttp\Client();
        $token = "eRj0hCmPaAU:APA91bFbFJAuevtQx47nvkfR-C3jyCJvC2TjVMT2rxYV9It7pBfDMJn88WwL1LnTxMqjDa9hQL8LJDxMu1S0fFJrfXVxlsDqg-ocxkdvxZdW8rKbGWrpGRl8g15ptcokZrwOFAty9QV-";
        $title = "Title Aja";
        $msg = "Isi Pesan"; 
        $http = "http://103.228.236.74:6789/send/?to=".$token."&title=".$title."&message=".$msg;
        $request = $client->get($http);
        $response = $request->getBody();
       
        $res = json_decode($response);
        return $res->success;
    }
}
