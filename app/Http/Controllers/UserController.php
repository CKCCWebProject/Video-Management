<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function goToHome(){
        return view('home');
    }

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
                $data = array(
                    'existed' => "Email is already existed!!"
                );
                return view('signup', $data);
            }
        }
        else{
            $data = array(
                'existed' => "Password is not match!!"
            );
            return view('signup', $data);
        }
    }

    public function signin(Request $request){
        //try to log in
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return view('home');
        }
//        $email = $request->email;
//        $password = $request->password;
//        if((User::checkExistedUser($email)) == true){
//
//            return view('signup');
//        }
    }
}
