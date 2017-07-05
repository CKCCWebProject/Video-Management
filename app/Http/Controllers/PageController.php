<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function signup() {
        return view('signup');
    }

    public function home($tab) {
        $data = array(
            'activeNav' => $tab,
            'position' => 'home'
        );
        return view ('home', $data);
    }

    public function nav($nav) {
        $data = array(
            'activeNav' => 'management',
            'position' => $nav
        );
        return view ('home', $data);
    }
}
