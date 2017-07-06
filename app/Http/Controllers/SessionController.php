<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    //accessing session Data with get() method
    public function getSession(Request $request)
    {
        if($request->session()->has('sessionName'))
        {
            echo $request->session()->get('sessionName');
        }
        else{
            echo "no data in the session";
        }
    }

    //with put() method
    public function putSession(Request $request)
    {
        $request->session()->put('sessionName', 'localhost:8000');
        echo "new data added to the session";
    }

    //delete session
    public function forgetSession(Request $request){
        $request->session()->forget('sessionName');
        echo "data removed from session";
    }
}
