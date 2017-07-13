<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use DB;
use DateTime;
use app\config;

define('SALT', 'q5kBq8F4GAHqA');

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    public static function createUser($user){

        ////sequence
        //create a user
        //create a home folder
        //create gift in home
        //create a setting

        $data = array(
            new DateTime(),
            new DateTime(),
            $user -> username,
            $user -> email,
            $user -> password,
            $user -> profile
        );
        DB::insert('INSERT INTO users(created_at, updated_at, username, email, password, profile) VALUES (?,?,?,?,?,?)', $data);
    }

    public static function checkExistedUser($email){
        $check = DB::table('users')->where('email', $email)->get();
        if(count($check) > 0){
            return true;
        }
        else return false;
    }

    public static function validSignIn($email, $password){
        $encPassword = crypt($password, SALT);
        $user = User::where('email', $email)->where('password', $encPassword)->take(1)->get();
//        var_dump($encPassword);
//        var_dump($email);
        if (count($user) == 0) {
            return false;
        } else {
            return $user;
        }
    }

    public static function getUserId($email, $password){
        $id = DB::table('users')->select('id')->where('email', $email)->where('password',$password )->get();
        return $id;
    }

    public function hasFolders(){
        return $this->hasMany('App\Folder');
    }

    public static function currentUser() {
        $nimol = new User();
        $nimol->id = 1;
        $nimol->username = 'nimol';
        $nimol->email = 'nimol@gmail.com';
        $nimol->password = '1234';
        return $nimol;
    }
}
