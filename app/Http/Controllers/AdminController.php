<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Lesson;
use App\LessonPlaylist;
use App\Song;
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

    public function insertLessonVideo(Request $request) {
        $videoUrl = $request->videoURL;
        $videoTitle = $request->videoTitle;
        $lessonPlaylist = $request->currentPlaylist;
        if (PageController::validYoutubeUrl($videoUrl)) {
            $id = PageController::getYoutubeId($videoUrl);
//            echo $id;
            $lesson = new Lesson();
            $lesson->created_at = new DateTime();
            $lesson->updated_at = new DateTime();
            $lesson->title =($videoTitle != '')?($videoTitle):
                (PageController::getInfoFromId($id)['items'][0]['snippet']['title']);
            $lesson->lp_id = $lessonPlaylist;
            $lesson->url = $id;
            $lesson->start_time = 0;
            $lesson->end_time = PageController::duration(PageController::getInfoFromId($id)['items'][0]['contentDetails']['duration']);
            $lesson->note = '';
            $lesson->save();
            $data = array (
                'message' => "New video added"
            );
            return redirect('home/management/playLesson/'.$lessonPlaylist);
        } else {
            $data = array (
                'message' => "URL invalid"
            );
            return redirect('home/management/playLesson/'.$lessonPlaylist);
        }
    }

    public function insertSongVideo(Request $request) {
        $videoUrl = $request->videoURL;
        $videoTitle = $request->videoTitle;
        $songPlaylist = $request->currentPlaylist;
        if (PageController::validYoutubeUrl($videoUrl)) {
            $id = PageController::getYoutubeId($videoUrl);
//            echo $id;
            $song = new Song();
            $song->created_at = new DateTime();
            $song->updated_at = new DateTime();
            $song->title =($videoTitle != '')?($videoTitle):
                (PageController::getInfoFromId($id)['items'][0]['snippet']['title']);
            $song->sp_id = $songPlaylist;
            $song->url = $id;
            $song->if_favorite = false;
            $song->save();
            $data = array (
                'message' => "New video added"
            );
            return redirect('home/management/playSong/'.$songPlaylist);
        } else {
            $data = array (
                'message' => "URL invalid"
            );
            return redirect('home/management/playSong/'.$songPlaylist);
        }
    }

    public function editNote(Request $request) {
        $id = $request->id;
        $note = $request->note;
        $video = Lesson::find($id);
        $video->note = $note;
        $video->save();
//        return response()->json(['return' => 'some data']);
    }

    public function favorite(Request $request) {
        $id = $request->id;
        $video = Song::find($id);
        if ($video->if_favorite == true) {
            $video->if_favorite = false;
            $video->save();
            return 'white';
        } else {
            $video->if_favorite = true;
            $video->save();
            return 'red';
        }
    }
}
