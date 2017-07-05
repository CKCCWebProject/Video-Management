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

//    public static function checkExistedUser($email){
//        $check = DB::query("select * from users where email=".$email);
//        if($check->num_row > 0){
//            return true;
//        }
//        else return false;
//    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
