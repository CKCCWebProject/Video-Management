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
        $userId = session('userId');
        $folderName = $request->folderName;
        $folder = new Folder();

        $folder->u_id = $userId;
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
        $userId = session('userId');
        $playlistName = $request->playlistName;
        $playlist = new SongPlaylist();

        $playlist->u_id = $userId;
        $playlist->created_at = new DateTime();
        $playlist->updated_at = new DateTime();
        $playlist->sp_name = $playlistName;
        $playlist->if_public = false;
        $playlist->f_id = $request->currentFolder;

        $playlist->save();

        return redirect('home/management/'.$request->currentFolder);
    }

    public function insertLesson(Request $request) {
        $userId = session('userId');
        $lessonName = $request->lessonName;
        $lesson = new LessonPlaylist();

        $lesson->u_id = $userId;
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
        $lessonPlaylist = $request->currentPlaylist;
        if (isset($request->allPlaylist)) {
            $id = $request->playlistId;
            $videos = $this->getVideosFromPlaylist($id);
            if($videos == false) {
                $message = "URL invalid / playlist not exist";
                session(['message' => $message]);
                return redirect('home/management/playLesson/'.$lessonPlaylist);
            } else {
                foreach ($videos as $video) {
                    $this->addLesson($video['title'], $video['id'], $lessonPlaylist, $video['duration']);
                }
                $message = "New videos added";
                session(['message' => $message]);
                return redirect('home/management/playLesson/'.$lessonPlaylist);
            }
        } else {
            $videoUrl = $request->videoURL;
            $videoTitle = $request->videoTitle;
            if (PageController::validYoutubeUrl($videoUrl)) {
                $id = PageController::getYoutubeId($videoUrl);
                $this->addLesson($videoTitle, $id, $lessonPlaylist, PageController::getDurationFromId($id));
                $message = "New video added";
                session(['message' => $message]);

                return redirect('home/management/playLesson/'.$lessonPlaylist);
            } else {
                $message = "URL invalid";
                session(['message' => $message]);

                return redirect('home/management/playLesson/'.$lessonPlaylist);
            }
        }
    }

    public function insertSongVideo(Request $request) {
        $songPlaylist = $request->currentPlaylist;
        if(isset($request->allPlaylist)) {
            $id = $request->playlistId;
            $videos = $this->getVideosFromPlaylist($id);
            if($videos == false) {
                $message = "URL invalid / playlist not exist";
                session(['message' => $message]);
                return redirect('home/management/playSong/'.$songPlaylist);
            } else {
                foreach ($videos as $video) {
                    $this->addSong($video['title'], $video['id'], $songPlaylist, $video['duration']);
                }
                $message = "New videos added";
                session(['message' => $message]);
                return redirect('home/management/playSong/'.$songPlaylist);
            }
        } else {
            $videoUrl = $request->videoURL;
            $videoTitle = $request->videoTitle;
            if (PageController::validYoutubeUrl($videoUrl)) {
                $id = PageController::getYoutubeId($videoUrl);
                $this->addSong($videoTitle, $id, $songPlaylist, PageController::getDurationFromId($id));
                $message = "New video added";
                session(['message' => $message]);
                return redirect('home/management/playSong/'.$songPlaylist);
            } else {
                $message = "URL invalid";
                session(['message' => $message]);
                return redirect('home/management/playSong/'.$songPlaylist);
            }
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
        $setting = Setting::find(session('userId'));
        $setting->play_favorite = $checked;
        $setting->save();
        echo $checked;
    }

    public function changeSequence(Request $request) {
        $sequence = $request->sequence;
        $setting = Setting::find(session('userId'));
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
        $gifts = SendTo::where('receiver_id', session('userId'))->get();
        return $gifts;
    }

    private function getVideosFromPlaylist($playlistId) {
//        https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=25&playlistId=PLwAKR305CRO-Q90J---jXVzbOd4CDRbVx&key=AIzaSyB95ggxhaa_dCCntXeHDF0c6y1bj_YKAgA
        $api_key = 'AIzaSyB95ggxhaa_dCCntXeHDF0c6y1bj_YKAgA';
        $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet,contentDetails&maxResults=10&playlistId='. $playlistId . '&key=' . $api_key;
//        $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=25&playlistId='. $playlistId . '&key=' . $api_key;

//        if (isset($playlist->error)) {
//            echo 'what';
//            return false;
//        }

        $file_headers = @get_headers($api_url);
        if($file_headers[0] == 'HTTP/1.1 404 Not Found' || $file_headers[0] == 'HTTP/1.0 404 Not Found') {
            return false;
        } else if($file_headers[0] == 'HTTP/1.1 503 Service Unavailable' || $file_headers[0] == 'HTTP/1.0 503 Service Unavailable') {
            return false;
        }

        $list = [];

        $playlist = json_decode(file_get_contents($api_url));

        foreach ($playlist->items AS $item) {
            $oneId = $item->snippet->resourceId->videoId;
            $one = array(
                'title' => $item->snippet->title,
                'id' => $oneId,
                'duration' => PageController::getDurationFromId($oneId)
            );
            array_push($list, $one);
        }

        while (count($list) < $playlist->pageInfo->totalResults) {
            $api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=10&playlistId='. $playlistId . '&pageToken=' . $playlist->nextPageToken . '&key=' . $api_key;
            $playlist = json_decode(file_get_contents($api_url));
            foreach ($playlist->items AS $item) {
                $oneId = $item->snippet->resourceId->videoId;
                $one = array(
                    'title' => $item->snippet->title,
                    'id' => $oneId,
                    'duration' => PageController::getDurationFromId($oneId)
                );
                array_push($list, $one);
            }
        }
        return $list;
    }

    private function addLesson($videoTitle, $id, $lessonPlaylist, $duration) {
        $userId = session('userId');
        $lesson = new Lesson();
        $lesson->created_at = new DateTime();
        $lesson->updated_at = new DateTime();
        $lesson->title =($videoTitle != '')?($videoTitle):
            (PageController::getTitleFromId($id));
        $lesson->lp_id = $lessonPlaylist;
        $lesson->url = $id;
        $lesson->u_id = $userId;
        $lesson->start_time = 0;
        $lesson->end_time = PageController::duration($duration);
        $lesson->note = '';
        $lesson->save();
    }

    private function addSong($videoTitle, $id, $songPlaylist, $duration) {
        $userId = session('userId');
        $song = new Song();
        $song->created_at = new DateTime();
        $song->updated_at = new DateTime();
        $song->title = ($videoTitle != '')?($videoTitle):
            (PageController::getTitleFromId($id));
        $song->sp_id = $songPlaylist;
        $song->url = $id;
        $song->u_id = $userId;
        $song->if_favorite = false;
        $song->duration = PageController::duration($duration);
        $song->save();
    }

}
