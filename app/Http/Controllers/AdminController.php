<?php

namespace App\Http\Controllers;

use App\Folder;
use App\LessonPlaylist;
use App\SongPlaylist;
use App\User;
use Illuminate\Http\Request;
use DB;
use DateTime;

class AdminController extends Controller
{
    public function insertFolder(Request $request) {
        $folderName = $request->folderName;
        $folder = new Folder();

        $folder->u_id = User::currentUser()->id;
        $folder->created_at = new DateTime();
        $folder->updated_at = new DateTime();
        $folder->folderName = $folderName;
        $folder->if_deletable = true;
        $folder->if_public = false;
        $folder->parent_id = $request->currentFolder;

        $folder->save();

        return redirect('home/management/'.$request->currentFolder);
    }

    public function insertPlaylist(Request $request) {
        $playlistName = $request->playlistName;
        $playlist = new SongPlaylist();

        $playlist->u_id = User::currentUser()->id;
        $playlist->created_at = new DateTime();
        $playlist->updated_at = new DateTime();
        $playlist->sp_name = $playlistName;
        $playlist->if_public = false;
        $playlist->f_id = $request->currentFolder;

        $playlist->save();

        return redirect('home/management/'.$request->currentFolder);
    }

    public function insertLesson(Request $request) {
        $lessonName = $request->lessonName;
        $lesson = new LessonPlaylist();

        $lesson->u_id = User::currentUser()->id;
        $lesson->created_at = new DateTime();
        $lesson->updated_at = new DateTime();
        $lesson->l_name = $lessonName;
        $lesson->if_public = false;
        $lesson->f_id = $request->currentFolder;
        $lesson->record = "";

        $lesson->save();

        return redirect('home/management/'.$request->currentFolder);
    }
}
