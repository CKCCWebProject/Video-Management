<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Folder;
use App\GiftBox;
use App\Lesson;
use App\LessonPlaylist;
use App\QNA;
use App\Setting;
use App\Song;
use App\SongPlaylist;
use App\User;
use DateInterval;
use Illuminate\Http\Request;
use DB;
use Illuminate\Database\Query\Builder;

class PageController extends Controller
{
    public function signup() {
        return view('signup');
    }

    public function home($tab) {
        if(session()->has('searchUrl') != null) {
            session()->forget('searchUrl');
        }
        $userId = session('userId');

        if ($tab == 'management') {
            $homes = Folder::where('u_id', $userId)->where('folderName', 'home')->where('if_deletable', 0)->get();
            return redirect('home/management/'.$homes[0]->f_id);
        }

        $message = '';
        if(session()->has('message') != null) {
            $message = session('message');
            session()->forget('message');
        }

        $data = array(
            'message' => $message,
            'activeNav' => $tab,
            'position' => 'home'
        );
        if ($tab == 'favorite') {
            $favoriteVideos = Song::where('u_id', $userId)->where('if_favorite', true)->get();
            $data['favoriteVideos'] = $favoriteVideos;
        }
        return view ('home', $data);
    }

    public static function nav($nav) {
        if(session()->has('searchUrl') != null) {
            session()->forget('searchUrl');
        }

        if ($nav == 'home') {
            return redirect("home/management");
        }

        $userId = session('userId');

        $message = '';
        if(session()->has('message') != null) {
            $message = session('message');
            session()->forget('message');
        }

        $data = array(
            'message' => $message,
            'position' => $nav,
            'userId' => $userId,
        );

        if ($nav == 'connection') {
            $data['people'] = Connection::where('u_id', $userId)->join('users', 'users.id', '=', 'connections.connect_with')->paginate(12);
        } elseif ($nav == 'gift') {
            $gifts = GiftBox::where('receiver_id', $userId)->get();
            $data['gifts'] = $gifts;
        } elseif ($nav == 'help') {
            $questions = QNA::orderBy('frequency', 'desc')->take(20)->paginate(10);
            $data['questions'] = $questions;
        }

//        foreach ($questions as $question) {
//            echo $question.'<br><br>';
//        }
        return view ('home', $data);
    }

    public static function playLesson($id, $vid = null, $message = '') {
        $userId = session('userId');

        $playlist = LessonPlaylist::find($id);
        if ($playlist == null) {
            session(['message' => 'Playlist not exist']);
            return redirect('home');
        }
        $publicVideo = $playlist->if_public;
        $gift = GiftBox::where('item_id', $id)->where('item_type', 2)->where('receiver_id', $userId)->get();
        $giftVideo = count($gift) > 0;
        $ownerVideo = $playlist->u_id == $userId;

        if ($publicVideo || $giftVideo ||$ownerVideo) {
            if (session()->has('message') != null) {
                $message = session('message');
                session()->forget('message');
            }

            $videos = Lesson::where('lp_id', $id)->orderBy('title', 'asc')->get();
            if (count($videos) > 0) {
                if ($vid == null) {
                    $currentVideo = $videos[0];
                } else {
                    $currentVideo = Lesson::find($vid);
                }
            } else {
                $currentVideo = null;
            }

            $total = 0;
            $done = 0;

            foreach ($videos as $video) {
                $total += $video->end_time;
                $done += $video->start_time;
            }

            if ($total > 0) {
                $percent = ceil($done * 100 / $total);
            } else {
                $percent = 0;
            }

            $data = array(
                'record' => LessonPlaylist::find($id)->record,
                'message' => $message,
                'currentVideo' => $currentVideo,
                'videos' => $videos,
                'percent' => $percent,
                'currentPlaylist' => $id,
                'autoplay' => $vid == null ? false : true,
                'parentId' => LessonPlaylist::where('l_id', $id)->get()[0]->f_id
            );
            return view('playLesson', $data);
        } else {
            session(['message'=>'You do not have permission to open this']);
            return redirect('home');
        }
    }

    public static function playSong($id, $vid = null, $message = '') {
        $userId = session('userId');

        $playlist = SongPlaylist::find($id);

        if ($playlist == null) {
            session(['message' => 'Playlist not exist']);
            return redirect('home');
        }

        $publicVideo = $playlist->if_public;
        $gift = GiftBox::where('item_id', $id)->where('item_type', 1)->where('receiver_id', $userId)->get();
        $giftVideo = count($gift) > 0;
        $ownerVideo = $playlist->u_id == $userId;

        if ($publicVideo || $giftVideo ||$ownerVideo) {

            if (session()->has('message') != null) {
                $message = session('message');
                session()->forget('message');
            }

            $videos = Song::where('sp_id', $id)->orderBy('title', 'asc')->get();
            $favoriteVideos = Song::where('sp_id', $id)->where('if_favorite', true)->orderBy('title', 'asc')->get();
            if (count($videos) > 0) {
                if ($vid == null) {
                    $currentVideo = $videos[0];
                } else {
                    $currentVideo = Song::find($vid);
                }
//            $duration = PageController::duration(PageController::getDurationInfoFromId($currentVideo->url)['items'][0]['contentDetails']['duration']);
            } else {
                $currentVideo = null;
                $duration = 0;
            }

            $setting = Setting::where('u_id', session('userId'))->get()[0];

            $data = array(
                'setting' => $setting,
                'message' => $message,
                'currentVideo' => $currentVideo,
                'videos' => $videos,
                'favoriteVideos' => $favoriteVideos,
//            'duration' => $duration,
                'currentPlaylist' => $id,
                'autoplay' => $vid == null ? false : true,
                'parentId' => SongPlaylist::where('sp_id', $id)->get()[0]->f_id
            );
            return view('playSong', $data);
        } else {
            session(['message'=>'You do not have permission to open this']);
            return redirect('home');
        }
    }

//    public function edit($id) {
//        $data = array (
//            'type' => 'lesson'
//        );
//        return view('edit');
//    }

    public function folder($id) {
        if(session()->has('searchUrl') != null) {
            session()->forget('searchUrl');
        }
        $userId = session('userId');
        $checkFolderPossession = Folder::where('f_id', $id)->where('u_id', $userId)->get();
        if (count($checkFolderPossession) != 1) {
            return redirect('home');
        } else {
            $userId = session('userId');

            $directories = array();
            $now = $id;
            do {
                $folder_i = Folder::where('f_id', $now)->where('u_id', $userId)->get();
                if (count($folder_i) != 1) {
                    return redirect('invalid_folder');
                }
                $now = $folder_i[0]->parent_id;
                array_unshift($directories, $folder_i[0]);
            } while ($folder_i[0]->folderName != 'home' || $folder_i[0]->if_deletable != false);

            $folders = Folder::where('u_id', $userId)->where('parent_id', $id)->where('f_id', '!=', $id)->get();
            $songPlaylists = SongPlaylist::where('u_id', $userId)->where('f_id', $id)->get();
            $lessonPlaylists = LessonPlaylist::where('u_id', $userId)->where('f_id', $id)->get();

            $message = '';
            if (session()->has('message') != null) {
                $message = session('message');
                session()->forget('message');
            }

            $connections = Connection::join('users', 'id', '=', 'connect_with')->where('u_id', $userId)->get();

            $data = array(
                'directories' => $directories,
                'pwd' => $id,
                'activeNav' => 'management',
                'position' => 'home',
                'folders' => $folders,
                'playlists' => $songPlaylists,
                'message' => $message,
                'lessons' => $lessonPlaylists,
                'connections' => $connections,
            );

            return view('home', $data);
        }
    }

//    public static function getYoutubeId ($url) {
////        $url = "http://www.youtube.com/watch?v=C4kxS1ksqtw&feature=relate";
//        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
//        return $my_array_of_vars['v'];
//    }

    public static function getYoutubeId($url) {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        .*$%x'
        ;
        $result = preg_match($pattern, $url, $matches);
        if ($result) {
            $answer = $matches[1];
//            if (strlen($answer) > 11) {
//                $answer = substr($answer, 0, 10);
//            }
            return $answer;
        }
        return false;
    }


    public static function validYoutubeUrl($url) {
        $rx = '~^(?:https?://)?(?:www[.])?(?:youtube[.]com/watch[?]v=|youtu[.]be/)([^&]{11})~x';

        $has_match = preg_match($rx, $url, $matches);
        return $has_match;
    }

    public static function getDurationFromId ($id) {
        $jsonUrl = "https://www.googleapis.com/youtube/v3/videos?id=".$id."&key=AIzaSyB95ggxhaa_dCCntXeHDF0c6y1bj_YKAgA&part=contentDetails";
        $json_source = file_get_contents($jsonUrl,true);
        $response = json_decode($json_source,true);
        if (count($response['items']) == 1) {
            return $response['items'][0]['contentDetails']['duration'];
        } else {
            return 'PT0S';
        }
    }

    public static function getTitleFromId ($id) {
        $jsonUrl = "https://www.googleapis.com/youtube/v3/videos?id=".$id."&key=AIzaSyB95ggxhaa_dCCntXeHDF0c6y1bj_YKAgA&part=snippet";
        $json_source = file_get_contents($jsonUrl,true);
        $response = json_decode($json_source,true);
        if (count($response['items']) == 1) {
            return $response['items'][0]['snippet']['title'];
        } else {
            return 'Unknown';
        }
    }



    public static function valideId($id) {
        $jsonUrl = "https://www.googleapis.com/youtube/v3/videos?id=".$id."&key=AIzaSyB95ggxhaa_dCCntXeHDF0c6y1bj_YKAgA&part=snippet,contentDetails,statistics,status";
        $json_source = file_get_contents($jsonUrl,true);
        $result = json_decode($json_source,true);
        if ($result['pageInfo']['totalResults'] == 0) {
            return false;
        } else {
            return true;
        }
    }

    public static function duration($ytDuration) {
        $di = new DateInterval($ytDuration);

        $totalSec = 0;
        if ($di->h > 0) {
            $totalSec+=$di->h*3600;
        }
        if ($di->i > 0) {
            $totalSec+=$di->i*60;
        }
        $totalSec+=$di->s;

        return $totalSec;
    }

    public static function songDirectory($parentId) {
        $playlist = SongPlaylist::find($parentId);
        $directory = $playlist->sp_name.'/';
        $now = $playlist->f_id;
        do {
            $folder_i = Folder::find($now);
            if ($folder_i == null) {
                return redirect('invalid_folder');
            }
            $directory = $folder_i->folderName.'/'.$directory;
            $now = $folder_i->parent_id;
        } while ($folder_i->folderName != 'home' || $folder_i->if_deletable != false);
        return $directory;
    }
}
