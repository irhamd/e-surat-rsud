<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    protected $table ="esurat_t";
    public $timestamps = true;

    protected $guarded = [];
    // protected $fillable = ['title','content'];
}
