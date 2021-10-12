<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use Auth;
use Illuminate\Support\Facades\Crypt;
use Hash;

class PasswordController extends Controller
{
    public function gantipassword(Request $req){
        try {
        $msg = "";
        $sess = "";

        $passwordlama = $req->passwordlama;
        $passwordbaru = $req->passwordbaru;
        $passwordbarulagi = $req->passwordbarulagi;

        $cekPassworLama = User::where('password','=',Hash::make($passwordlama))->count();

        dd(Crypt::encryptString($passwordlama));

            if($cekPassworLama != 0){
                if( $passwordbaru ==  $passwordbarulagi){
                    $ubah = User::where("id","=",Auth::user()->getId() )
                    ->update([
                        'password'=>Hash::make($req->passwordbaru)
                    ]);
                    if ($ubah){
                        $sess = "berhasil";
                        $msg = 'Berhasil ubah password!';
                    } else{
                        $sess = "gagal";
                        $msg = 'Gagal ubah password!';
                    }

                }
                    else{
                        $sess = "gagal";
                        $msg = 'Password baru lagi tiddak cocok .!';
                    }
            } else{
                $sess = "gagal";
                $msg = 'Password lama tidak ditemukan ...';
            }

            // dd($req);

            return redirect()->back()->with($sess,$msg."..");


        } catch (\Exception $th) {
            return redirect()->back()->with('gagal','Berhasil ubah password .!'. $th->getMessage());
        }

    }
}
