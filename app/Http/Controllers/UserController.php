<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    var $email = 'nimol@gmail.com';
    var $password = '4567';

    public function signupScreenWithMessage($message){
        return view('signup', ['message'=> $message]);
    }

    public function signup(Request $request){
//        $this->validate($request, [
//           'email' => 'required|email|unique:users',
//            'username' => 'required|max:120',
//            'password' => 'required|min:6'
//        ]);
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

                $request->session()->regenerate();
                return redirect('home');
            }
            else{
//                echo "already existed";
                return $this->signupScreenWithMessage("Email is already existed!!");
//                return redirect('connection');
            }
        }
        else{
//            echo "<script>alert('password not match');</script>";
            return $this->signupScreenWithMessage("Password is not match!!");
        }
    }

    public function signin(Request $request){
        //try to log in
        $email=$request->email;
        $password=$request->password;

        $currentUser = User::validSignIn($email, $password);
        if($currentUser == null) {
            //error
            return redirect('signup');
        }else{
            $id = User::getUserId($email, $password);
            $request->session()->put('id', $id);
            return redirect('home');
        }
    }


    public function signout(){
//        $request->session()->flush();
        return redirect('/');
    }

    public function isLoggedIn(){
        return true;
    }
}
