<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function signup() {
        return view('signup');
    }

    public function index() {
        return view ('index');
    }
}
