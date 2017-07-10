<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Lesson;
use App\LessonPlaylist;
use App\SendTo;
use App\Setting;
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
//            $data = array (
//                'message' => "New video added"
//            );
//            return redirect('home/management/playLesson/'.$lessonPlaylist);
            $message = "New video added";
            return PageController::playLesson($lessonPlaylist, null, $message);
        } else {
            $data = array (
                'message' => "URL invalid"
            );
//            $message = "URL invalid";
            $message = "URL invalid";
//            return redirect('home/management/playLesson/'.$lessonPlaylist);
            return PageController::playLesson($lessonPlaylist, null, $message);
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
//            $data = array (
//                'message' => "New video added"
//            );
//            return redirect('home/management/playSong/'.$songPlaylist);
            $message = "New video added";
            return PageController::playSong($songPlaylist, null, $message);
        } else {
//            $data = array (
//                'message' => "URL invalid"
//            );
//            return redirect('home/management/playSong/'.$songPlaylist);
            $message = "URL invalid";
            return PageController::playSong($songPlaylist, null, $message);
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

    public function changePlayFavorite(Request $request) {
        $checked = $request->checked;
        $setting = Setting::find(User::currentUser()->id);
        $setting->play_favorite = $checked?1:0;
        $setting->save();
//        echo $checked;
    }

    public function changeSequence(Request $request) {
        $sequence = $request->sequence;
        $setting = Setting::find(User::currentUser()->id);
        $setting->sq_id = $sequence;
        $setting->save();
        echo $sequence;
    }

    public function removeFavorite(Request $request) {
        $checked = $request->favorite;
        if (isset($checked)) {
            foreach ($checked as $noFav) {
                $video = Song::find($noFav);
                $video->if_favorite = false;
                $video->save();
            }
        }
        return redirect('home/favorite');
    }

    public function deleteFolder(Request $request) {
        $currentFolder = $request->currentFolder;
        $type = $request->type;
        $id = $request->id;
        if($type == 'folder') {
            $this->deleteFD($id);
        } elseif ($type == 'song') {
            $this->deleteSP($id);
        } elseif ($type == 'lesson') {
            $this->deleteLP($id);
        } else {
            echo "having problem"; //error
        }

        return redirect('home/management/'.$currentFolder);
    }

    public function deleteSong($id, $vid) {
        $song = Song::find($vid);
        $song->delete();
        return redirect('home/management/playSong/'.$id);
    }

    public function deleteLesson($id, $vid) {
        $lesson = Lesson::find($vid);
        $lesson->delete();
        return redirect('home/management/playLesson/'.$id);
    }

    public function updateTime(Request $request) {
        $time = $request->time;
        $lessonId = $request->lessonId;
        $lesson = Lesson::find($lessonId);
        $lesson->start_time = $time;
        $lesson->save();

        $lp = LessonPlaylist::find($lesson->lp_id);
        $lp->record = $request->record.$lp->record;
        $lp->save();
    }

    private function deleteSP($id) {
        $songs = Song::where('sp_id', $id)->get();
        foreach ($songs as $song) {
            $s = Song::find($song->s_id);
            $s->delete();
        }
        SongPlaylist::find($id)->delete();
    }

    private function deleteLP($id) {
        $lessons = Lesson::where('lp_id', $id)->get();
        foreach ($lessons as $lesson) {
            $l = Lesson::find($lesson->l_id);
            $l->delete();
        }
        LessonPlaylist::find($id)->delete();
    }

    private function deleteFD($id) {
        $fs = Folder::where('parent_id', $id)->get();
        $ss = SongPlaylist::where('f_id', $id)->get();
        $ls = LessonPlaylist::where('f_id', $id)->get();
        if(count($fs)==0) {
            $reach = Folder::find($id);
            $reach->delete();
            if(count($ss) == 0 && count($ls) == 0) {
                return;
            }
        } else {
            foreach ($fs as $f) {
                $this->deleteFD($f->f_id);
                $fs1 = Folder::where('parent_id', $id)->get();
                if(count($fs1) == 0) {
                    $reach1 = Folder::find($id);
                    $reach1->delete();
                }
            }
        }
        foreach ($ss as $s) {
            $this->deleteSP($s->sp_id);
        }
        foreach ($ls as $l) {
            $this->deleteLP($l->l_id);
        }
    }

    public static function Gift() {
        $gifts = SendTo::where('receiver_id', User::currentUser()->id)->get();
        return $gifts;
    }


}
