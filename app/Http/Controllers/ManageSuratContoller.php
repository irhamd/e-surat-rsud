<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ManageSuratContoller extends Controller
{
    public function logouta(){
        Auth::logout();
            return redirect('/login');
    }
}
