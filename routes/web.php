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

Route::group(['middleware' => ['checkloggedin']], function (){
    Route::get('signup', function (){
        $message = '';
        if (session()->has('message') != null) {
            $message = session('message');
            session()->forget('message');
        }
        return view('signup', ['message' => $message]);
    });

    Route::post('/signup', 'UserController@signup');
});

Route::group(['middleware' => ['checkuser']], function (){
    Route::get('/', function (){
        return redirect('signup');
    });
    Route::get('signout', 'UserController@signout');
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
    Route::get('/home/search/result', 'AdminController@searchItem');
    Route::get('/connection/result', 'AdminController@searchPeople');
    Route::get('/help/result', 'AdminController@searchQuestion');
});

Route::post('/uploadProfile', 'UserController@uploadProfile');
Route::post('/signin', 'UserController@signin');
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
Route::post('updateTime', 'AdminController@updateTime');
Route::post('renameFolder', 'AdminController@rename');
Route::post('deleteAccount', 'AdminController@deleteAccount');
Route::post('sharePublic', 'AdminController@sharePublic');
Route::post('sendGift', 'AdminController@sendGift');
Route::post('connect', 'AdminController@connect');
//Route::post('searchPeople', 'AdminController@searchPeople');
Route::post('receiveGift', 'AdminController@receiveGift');
Route::post('rejectGift', 'AdminController@rejectGift');
Route::post('renameSong', 'AdminController@renameSong');
Route::post('renameLesson', 'AdminController@renameLesson');
Route::post('editUsername', 'AdminController@editUsername');
Route::post('editEmail', 'AdminController@editEmail');
Route::post('editDescription', 'AdminController@editDescription');
Route::post('changePassword', 'UserController@changePassword');
Route::post('getSPFromPublic', 'AdminController@getSPFromPublic');
Route::post('getLPFromPublic', 'AdminController@getLPFromPublic');
Route::post('checkPath', 'AdminController@checkPath');
Route::post('move', 'AdminController@move');