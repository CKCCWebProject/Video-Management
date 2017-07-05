<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function goToHome(){
        $data = array(
           'position' => 5,
            'activeNav' => 1
        );
        return view('home', $data);
    }

    public function signup(Request $request){
        $this->validate($request, [
           'email' => 'required|email|unique:users',
            'username' => 'required|max:120',
            'password' => 'required|min:6'
        ]);
        $email = $request->signup_email;
        $username = $request->signup_username;
        $password = $request->signup_password;
        $confirmPassword = $request->signup_confirmpassword;
//        echo $password;
//        echo "/n".$confirmPassword;
        if($password == $confirmPassword){
            if((User::checkExistedUser($email)) == false){
                $user = new User();
                $user->username = $username;
                $user->email = $email;
                $user->password = bcrypt($password);
                User::createUser($user);

                Auth::login($user);
                return $this->goToHome();
            }
            else{
//                echo "already existed";
                $data = array(
                    'existed' => "Email is already existed!!"
                );
                return view('signup', $data);
            }
        }
        else{
//            echo "<script>alert('password not match');</script>";
            $data = array(
                'existed' => "Password is not match!!"
            );
            return view('signup', $data);
        }
    }

    public function signin(Request $request){
        //try to log in
        $email=$request->email;
        $password=$request->password;
        if(Auth::attempt(['email' => $email, 'password' => $password])){
            return redirect('home');
        }
        else{
            return view('welcome');
        }
    }

    public function signout(){
        Auth::logout();
        return redirect('/');
    }
}
