<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Setting;
use App\User;
use DateTime;
use Illuminate\Http\Request;
use Image;
use Session;

class UserController extends Controller
{
    public function signupScreenWithMessage($message){
        return view('signup', ['message'=> $message]);
    }

    public function signup(Request $request){
        $email = $request->signup_email;
        $username = $request->signup_username;
        $password = $request->signup_password;
        $confirmPassword = $request->signup_confirmpassword;

//        $this->validate($request, [
//            'email' => 'required|email|unique:users',
//            'username' => 'required|max:120',
//            'password' => 'required|min:6',
//            'confirmpassword' => 'require|same:password',
//        ]);

        if($password == $confirmPassword){
            if((User::checkExistedUser($email)) == false){
                $user = new User();
                $user->username = $username;
                $user->email = $email;
                $user->profile = "img/photo/default.png";
                $user->password = crypt($password, SALT);
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

                session(['userId' => $uid]);

                session(['message' => 'Welcome']);

                return redirect('home');
            }
            else{
//                echo "already existed";

                session(['message' => 'Email is already used']);

//                return $this->signupScreenWithMessage("Email is already existed!!");
                return redirect('signup');
//                return redirect('connection');
            }
        }
        else{
//            echo "<script>alert('password not match');</script>";
//            return $this->signupScreenWithMessage("Password is not match!!");
            session(['message' => 'Password not match']);
            return redirect('signup');
        }
    }

    public function signin(Request $request){
        //try to log in
        $email = $request->email;
        $password = $request->password;

        $currentUser = User::validSignIn($email, $password);
//        var_dump($currentUser);
        if($currentUser == false) {
            //error
            return redirect('signup');
        }else{
            $uid = $currentUser[0]->id;
//            if($request->session()->has('id', $uid)){
//                $request->session()->get('id');
//            }
//            else $request->session()->put('id', $uid);
            session(['userId' => $uid]);

//            $request->session()->put('id', $id);
            return redirect('home');
        }
    }
//upload file
    public function uploadProfile(Request $request){
        $user = User::find(session('userId'));
        $uid = User::where('email', $user->email)->get()[0]->id;

        if($request->hasFile('imageProfile')){
            $this->validate($request, [
                'imageProfile' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPEG,PNG,JPG,GIF,SVG|max:10240',
            ]);
            $profile = $request->file('imageProfile');

//            $image = Image::make($profile)->resize(300,500);//try this
//            $profile = $this->resizeImage(realpath($profile), 120, 120, Imagick::FILTER_LANCZOS, 1, true, true);

            $filename = time()."id".$uid.".".$profile->getClientOriginalExtension();
            $profilePath = $profile->move('img/photo', $filename);

            $user = User::find(session('userId'));
            $user->profile = $profilePath;
            $user->save();
//            echo $profilePath;
        }

        return PageController::nav($request->currentPosition);
    }

    public function signout(){
//        User::currentUser();
        session()->forget('userId');
        session()->flush();
        return redirect('/');
    }

    public function isLoggedIn(){
        return true;
    }

//    private function resizeImage($imagePath, $width, $height, $filterType, $blur, $bestFit, $cropZoom) {
//        //The blur factor where &gt; 1 is blurry, &lt; 1 is sharp.
//        $imagick = new \Imagick(realpath($imagePath));
//
//        $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);
//
//        $cropWidth = $imagick->getImageWidth();
//        $cropHeight = $imagick->getImageHeight();
//
//        if ($cropZoom) {
//            $newWidth = $cropWidth / 2;
//            $newHeight = $cropHeight / 2;
//
//            $imagick->cropimage(
//                $newWidth,
//                $newHeight,
//                ($cropWidth - $newWidth) / 2,
//                ($cropHeight - $newHeight) / 2
//            );
//
//            $imagick->scaleimage(
//                $imagick->getImageWidth() * 4,
//                $imagick->getImageHeight() * 4
//            );
//        }
//
//
//        header("Content-Type: image/jpg");
//        return $imagick->getImageBlob();
//    }
}
