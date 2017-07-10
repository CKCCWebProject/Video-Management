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




});


Route::get('/home/{tab}', 'PageController@home');
Route::get('/home/management/{id}', 'PageController@folder');
Route::get('/{nav}', 'PageController@nav');
Route::get('/home/management/playLesson/{id}', 'PageController@playLesson');
Route::get('/home/management/playLesson/{id}/{vid}', 'PageController@playLesson');
Route::get('/home/management/playSong/{id}', 'PageController@playSong');
Route::get('/home/management/playSong/{id}/{vid}', 'PageController@playSong');
Route::get('/home/management/edit/{id}', 'PageController@edit');
Route::get('/deletesong/{id}/{vid}', 'AdminController@deleteSong');
Route::get('/deletelesson/{id}/{vid}', 'AdminController@deleteLesson');

Route::post('/folders', 'AdminController@insertFolder');
Route::post('/playlists', 'AdminController@insertPlaylist');
Route::post('/lessons', 'AdminController@insertLesson');
Route::post('/home/management/playLesson/{id}', 'AdminController@insertLessonVideo');
Route::post('/home/management/playSong/{id}', 'AdminController@insertSongVideo');
Route::post('editNote', 'AdminController@editNote');
Route::post('favorite', 'AdminController@favorite');
Route::post('changePlayFavorite', 'AdminController@changePlayFavorite');
Route::post('changeSequence', 'AdminController@changeSequence');
Route::post('home/favorite/removeFavorite', 'AdminController@removeFavorite');
Route::post('deleteFolder', 'AdminController@deleteFolder');