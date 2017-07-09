<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Lesson;
use App\LessonPlaylist;
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
        if ($tab == 'management') {
            $homes = Folder::where('u_id', User::currentUser()->id)->where('folderName', 'home')->where('if_deletable', 0)->get();
            return redirect('home/management/'.$homes[0]->f_id);
        }
        $data = array(
            'activeNav' => $tab,
            'position' => 'home'
        );
        if ($tab == 'favorite') {
            $favoriteVideos = DB::table('songs')->join('song_playlists', 'songs.sp_id', '=', 'song_playlists.sp_id')->where('u_id', User::currentUser()->id)->where('if_favorite', true)->get();
            $data['favoriteVideos'] = $favoriteVideos;
        }
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

    public static function playLesson($id, $vid = null, $message = '') {
//        $json_output = self::getInfoFromId('tq3itlILfn4');
//        echo $json_output['items'][0]['contentDetails']['duration'];
//        echo $json_output['items'][0]['snippet']['title'];

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

        $data = array(
            'message' => $message,
            'currentVideo' => $currentVideo,
            'videos' => $videos,
            'currentPlaylist' => $id,
            'autoplay' => $vid == null?false:true,
            'parentId' => LessonPlaylist::where('l_id', $id)->get()[0]->f_id
        );
        return view('playLesson', $data);
    }

    public function playSong($id, $vid = null, $message = '') {
//        $data = array(
//            'currentPlaylist' => $id,
//            'parentId' => SongPlaylist::where('sp_id', $id)->get()[0]->f_id
//        );
//        return view('playSong', $data);
        $videos = Song::where('sp_id', $id)->orderBy('title', 'asc')->get();
        if (count($videos) > 0) {
            if ($vid == null) {
                $currentVideo = $videos[0];
            } else {
                $currentVideo = Song::find($vid);
            }
            $duration = PageController::duration(PageController::getInfoFromId($currentVideo->url)['items'][0]['contentDetails']['duration']);
        } else {
            $currentVideo = null;
            $duration = 0;
        }



        $data = array(
            'message' => $message,
            'currentVideo' => $currentVideo,
            'videos' => $videos,
            'duration' => $duration,
            'currentPlaylist' => $id,
            'autoplay' => $vid == null?false:true,
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

    public static function getInfoFromId ($id) {
        $jsonUrl = "https://www.googleapis.com/youtube/v3/videos?id=".$id."&key=AIzaSyB95ggxhaa_dCCntXeHDF0c6y1bj_YKAgA&part=snippet,contentDetails,statistics,status";
        $json_source = file_get_contents($jsonUrl,true);
        return json_decode($json_source,true);
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
