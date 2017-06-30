<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function SignUp(Request $request){
        $email = $request->signup_email;
        $username = $request->signup_username;
        $password = $request->signup_password;
        $confirmPassword = $request->signup_confirmpassword;
        if($password == $confirmPassword){
            $user = new User();
            $user->username = $username;
            $user->email = $email;
            $user->password = bcrypt($password);
            User::createUser($user);
            return redirect('index');
        }
    }

//    public function SignIn(Request $request){
//
//    }
}
