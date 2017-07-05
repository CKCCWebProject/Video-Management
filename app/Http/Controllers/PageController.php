<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function signup() {
        return view('signup');
    }

    public function home() {
        $data = array(
            'activeNav' => 1,
            'position' => 5
        );
        return view ('home', $data);
    }
}
