<?php

namespace App\Inbox;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table="inboxesurat_t";

    public $timestamps = true;

    protected $guarded = [];
    
}
