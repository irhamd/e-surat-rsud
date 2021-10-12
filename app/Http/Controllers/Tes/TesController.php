<?php

namespace App\Http\Controllers\Tes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class TesController extends Controller
{

   public function reset(){
      Session::put("keranjang",0);
      $detail = Session::put("detail","");
      Session::put("detail",[]);
      return redirect()->back();
      
     }


   function TesController(){
      $this->reset();
   }
   public function tambah($barang){

    $jumlah = Session("keranjang");
    $jumlah++;

    Session::put("keranjang", $jumlah);



    $array = Session("detail"); ;

    $array [] =$barang;

    $detail = Session::put("detail",$array);



    return redirect()->back();
    
   }



}
