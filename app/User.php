<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    public static function createUser($user){
        $data = array(
            new DateTime(),
            new DateTime(),
            $user -> username,
            $user -> email,
            $user -> password
        );
        DB::insert('INSERT INTO users(created_at, updated_at, username, email, password) VALUES (?,?,?,?,?)', $data);
    }

    public static function checkExistedUser($email){
        $check = DB::table('users')->where('email', $email)->get();
        if(count($check) > 0){
            return true;
        }
        else return false;
    }

    public static function getUserId($email, $password){
        $id = DB::table('users')->select('id')->where('email', $email)->where('password',$password )->get();
    }

    public function hasFolders(){
        return $this->hasMany('App\Folder');
    }
}
