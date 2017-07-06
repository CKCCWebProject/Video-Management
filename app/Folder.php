<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function belongToUser()
    {
        return $this->belongsTo('App\User');
    }

   public static function createFolder(){

   }
}
