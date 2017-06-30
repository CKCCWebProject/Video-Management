<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;

class User extends Model
{
    public static function createUser($user){
        $data = array(
            new DateTime(),
            new DateTime(),
            $user -> username,
            $user -> email,
            $user -> password
        );
        DB::insert('INSERT INTO users(username, email, password) VALUES (?,?,?,?)', $data);
    }


}
