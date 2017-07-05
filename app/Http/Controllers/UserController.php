<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup(Request $request){
        $email = $request->signup_email;
        $username = $request->signup_username;
        $password = $request->signup_password;
        $confirmPassword = $request->signup_confirmpassword;
        if($password == $confirmPassword){
            if((User::checkExistedUser($email)) == false){
                $user = new User();
                $user->username = $username;
                $user->email = $email;
                $user->password = bcrypt($password);
                User::createUser($user);
                return view('home');
            }
            else{
                "email already exist";
            }
        }
        else{
            echo "Password not match";
        }
    }

    public function SignIn(Request $request){
        //try to log in
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return view('home');
        }
        return view('signup');
    }
}
