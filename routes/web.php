<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['web']], function (){

    Route::get('/', function (){
        return redirect('signup');
    });

    Route::get('signup', function (){
        return view('signup');
    });

    Route::post('/signup', 'UserController@signup');

    Route::post('/signin', 'UserController@signin');

//    Route::get('homepage', 'PageController@home');

        Route::get('signout', 'UserController@signout');

        Route::get('/home/{tab}', 'PageController@home');
        Route::get('/{nav}', 'PageController@nav');



});
Route::group(['middleware' => 'guest'], function (){
    return view('signup');
});

