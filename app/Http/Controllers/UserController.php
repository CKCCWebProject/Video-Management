<?php

namespace App\Http\Controllers;

use App\Folder;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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

                $request->session()->put('user', $username);

                $uid = User::where('email', $email)->get()[0]->id;

                $home = new Folder();
                $home->created_at = new DateTime();
                $home->updated_at = new DateTime();
                $home->u_id = $uid;
                $home->folderName = "home";
                $home->if_deletable = false;
                $home->if_public = false;
                $home->parent_id = 0;
                $home->save();

                $homeId = Folder::where('folderName', 'home')->where('u_id', $uid)->get()[0]->f_id;
                $home1 = Folder::find($homeId);
                $home1->parent_id = $homeId;
                $home1->save();

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
        $password=bcrypt($request->password);

        $currentUser = User::validSignIn($email, $password);
        if($currentUser == null) {
            //error
            return redirect('signup');
        }else{
            $id = User::getUserId($email, $password);
//            $request->session()->put('id', $id);
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
