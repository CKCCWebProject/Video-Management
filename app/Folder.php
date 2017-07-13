<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Folder extends Model
{
    protected $primaryKey = 'f_id';
    public function belongToUser()
    {
        return $this->belongsTo('App\User');
    }
}
