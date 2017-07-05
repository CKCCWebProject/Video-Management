<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next, $quard = null)
    {
        if(Auth::guard($quard)->guest()){
            if($request->ajax()){
                return response('Unauthorized.', 401);
            }
            else{
                return redirect('home');
            }
        }
    }
}