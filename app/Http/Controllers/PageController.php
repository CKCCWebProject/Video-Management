<?php

namespace App\Http\Controllers;

use App\Folder;
use App\LessonPlaylist;
use App\SongPlaylist;
use App\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function signup() {
        return view('signup');
    }

    public function home($tab) {
        if ($tab == 'management') {
            $homes = Folder::where('u_id', User::currentUser()->id)->where('folderName', 'home')->where('if_deletable', 0)->get();
            return redirect('home/management/'.$homes[0]->f_id);
        }
        $data = array(
            'activeNav' => $tab,
            'position' => 'home'
        );
        return view ('home', $data);
    }

    public function nav($nav) {
        if ($nav == 'home') {
            return redirect("home/management");
        }
        $data = array(
            'position' => $nav
        );
        return view ('home', $data);
    }

    public function playLesson($id) {
        $data = array(
            'parentId' => LessonPlaylist::where('l_id', $id)->get()[0]->f_id
        );
        return view('playLesson', $data);
    }

    public function playSong($id) {
        $data = array(
            'parentId' => SongPlaylist::where('sp_id', $id)->get()[0]->f_id
        );
        return view('playSong', $data);
    }

//    public function edit($id) {
//        $data = array (
//            'type' => 'lesson'
//        );
//        return view('edit');
//    }

    public function folder($id) {

        $directories = array();
        $now = $id;
        do {
            $folder_i = Folder::where('f_id', $now)->where('u_id', User::currentUser()->id)->get();
            if (count($folder_i) != 1) {
                return redirect('invalid_folder');
            }
            $now = $folder_i[0]->parent_id;
            array_unshift($directories, $folder_i[0]);
        } while ($folder_i[0]->folderName != 'home' || $folder_i[0]->if_deletable != false);

        $folders = Folder::where('u_id', User::currentUser()->id)->where('parent_id', $id)->where('f_id', '!=', $id)->get();
        $songPlaylists = SongPlaylist::where('u_id', User::currentUser()->id)->where('f_id', $id)->get();
        $lessonPlaylists = LessonPlaylist::where('u_id', User::currentUser()->id)->where('f_id', $id)->get();
        $data = array (
            'directories' => $directories,
            'pwd' => $id,
            'activeNav' => 'management',
            'position' => 'home',
            'folders' => $folders,
            'playlists' => $songPlaylists,
            'lessons' => $lessonPlaylists
        );

        return view('home', $data);
    }
}
