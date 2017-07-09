<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $primaryKey = 'f_id';
    public function belongToUser()
    {
        return $this->belongsTo('App\User');
    }
}
