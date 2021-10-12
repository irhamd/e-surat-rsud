<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;

class UserControllerRev extends Controller
{
        public function getDataUser( Request $req ){
            $data = DB::table('users');

            if(isset($req->find)){
                $data = $data->where('name','like','%'.$req->find.'%');
            }
            $data = $data->get();

            return response()->json($data);
        }

 

}
