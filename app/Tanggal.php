<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tanggal 
{
    public static function FormatIndo($tanggal){
        return Carbon::parse($tanggal)->format('d-m-Y');

    }    
    
    public static function diff($tanggal){
        return Carbon::parse($tanggal)->diffForHumans();
    }
    public static function now(){
         
        // return Carbon::now();
        return date("Y-m-d h:i:s");
    }


}
