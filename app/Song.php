<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    //
    protected $primaryKey = 's_id';

    public function song_playlists()
    {
        return $this->belongsTo('SongPlaylist');
    }
}
