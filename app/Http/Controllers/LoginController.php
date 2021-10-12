<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function getloginRes(Request $req)
    {
        $data = User::where("name","=",$req['username'])->select("password","pegawaifk","namaexternal","key","jabatanesurat")
        // ->where("password","=", \Hash::make( $req['password'] ))
        ->first();

        $cek = \Hash::check($req['password'], $data ? $data->password :"" );

        if($cek){
                return response()->json([
                    "data" => $data,
                    "msg" => 1
                ]);
            } else {
                return response()->json([
                    "data" => "",
                    "msg" => 0
                ]);
            }
    }
}
