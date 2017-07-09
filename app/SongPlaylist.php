<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongPlaylist extends Model
{
    protected $primaryKey = 'sp_id';
    public function songs()
    {
        return $this->hasMany('Song');
    }
}
