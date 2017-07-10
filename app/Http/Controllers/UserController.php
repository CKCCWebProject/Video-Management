<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Setting;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Auth;
use Image;
use Session;
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

                $uid = User::where('email', $email)->get()[0]->id;

                $request->session()->put('id', $uid);

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

                $setting = new Setting();
                $setting->created_at = new DateTime();
                $setting->updated_at = new DateTime();
                $setting->u_id = $uid;
                $setting->play_favorite = false;
                $setting->sq_id = 1;
                $setting->save();

                $gift = new Folder();
                $gift->created_at = new DateTime();
                $gift->updated_at = new DateTime();
                $gift->u_id = $uid;
                $gift->folderName = 'gift';
                $gift->if_deletable = false;
                $gift->if_public = false;
                $gift->parent_id = $homeId;
                $gift->save();

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
            $uid = User::where('email', $email)->get()[0]->id;
            if($request->has('id', $uid)){
                $request->get('id');
            }

//            $request->session()->put('id', $id);
            return redirect('home');
        }
    }
//upload file
    public function uploadProfile(Request $request){
        $user = User::currentUser();
        $uid = User::where('email', $user->email)->get()[0]->id;

        if($request->hasFile('imageProfile')){
            $this->validate($request, [
                'imageProfile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $profile = $request->file('imageProfile');
            $profilePath = $profile->move('img', time()."id".$uid.".".$profile->getClientOriginalExtension());

//            $filename = time().'.'.$profile->getClientOriginalName();
//            $image = Image::make($profile)->resize(300,300)->save(public_path('img'.$filename));


            $user = User::where('email', $user->email)->update(['profile' => $profilePath]);
        }
    }

    public function signout(){
//        User::currentUser();
        session()->forget('id');
        return redirect('/');
    }

    public function isLoggedIn(){
        return true;
    }
}
