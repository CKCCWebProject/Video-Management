<?php

namespace App\Http\Controllers;

use App\Connection;
use App\Folder;
use App\GiftBox;
use App\Lesson;
use App\LessonPlaylist;
use App\QNA;
use App\SendTo;
use App\Setting;
use App\Song;
use App\SongPlaylist;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use DB;
use DateTime;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

//define('SALT', 'q5kBq8F4GAHqA');
//reallocate in the function destroy

class AdminController extends Controller
{
    public function insertFolder(Request $request) {
        $userId = session('userId');
        $folderName = $request->folderName;
        $currentFolder = $request->currentFolder;

        $checkName = Folder::where('parent_id', $currentFolder)->where('folderName', $folderName)->get();
        if (count($checkName) > 0) {
            session(['message' => 'This name is already used']);
        } elseif ($folderName[0] == '.') {
            session(['message' => 'Not allow `.` at beginning']);
        } elseif (strpos($folderName, '/') != false) {
            session(['message' => 'Not allow `/` in folder name']);
        } else {
            $folder = new Folder();
            $folder->u_id = $userId;
            $folder->created_at = new DateTime();
            $folder->updated_at = new DateTime();
            $folder->folderName = $folderName;
            $folder->if_deletable = true;
            $folder->if_public = false;
            $folder->parent_id = $currentFolder;

            $folder->save();
        }

        return redirect('home/management/'.$request->currentFolder);
    }

    public function insertPlaylist(Request $request) {
        $userId = session('userId');
        $playlistName = $request->playlistName;
        $currentFolder = $request->currentFolder;

        $checkName = SongPlaylist::where('f_id', $currentFolder)->where('sp_name', $playlistName)->get();
        if (count($checkName) > 0) {
            session(['message' => 'This name is already used']);
        } else {

            $playlist = new SongPlaylist();
            $playlist->u_id = $userId;
            $playlist->created_at = new DateTime();
            $playlist->updated_at = new DateTime();
            $playlist->sp_name = $playlistName;
            $playlist->if_public = false;
            $playlist->f_id = $currentFolder;

            $playlist->save();
        }

        return redirect('home/management/'.$request->currentFolder);
    }

    public function insertLesson(Request $request) {
        $userId = session('userId');
        $lessonName = $request->lessonName;
        $currentFolder = $request->currentFolder;

        $checkName = LessonPlaylist::where('f_id', $currentFolder)->where('l_name', $lessonName)->get();
        if (count($checkName) > 0) {
            session(['message' => 'This name is already used']);
        } else {

            $lesson = new LessonPlaylist();
            $lesson->u_id = $userId;
            $lesson->created_at = new DateTime();
            $lesson->updated_at = new DateTime();
            $lesson->l_name = $lessonName;
            $lesson->if_public = false;
            $lesson->f_id = $currentFolder;
            $lesson->record = "";

            $lesson->save();
        }

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
                $countUnavailable = 0;
                foreach ($videos as $video) {
                    $success = $this->addLesson($video['title'], $video['id'], $lessonPlaylist, $video['duration']);
                    if ($success == false) {
                        $countUnavailable++;
                    }
                }
                $message = "New videos added" . ($countUnavailable==0?'':($countUnavailable==1?', one video is unavailable':$countUnavailable.' videos are unavailable'));
                session(['message' => $message]);
                return redirect('home/management/playLesson/'.$lessonPlaylist);
            }
        } else {
            $videoUrl = $request->videoURL;
            $videoTitle = $request->videoTitle;
            if (PageController::validYoutubeUrl($videoUrl)) {
                $id = PageController::getYoutubeId($videoUrl);
                $success = $this->addLesson($videoTitle, $id, $lessonPlaylist, PageController::getDurationFromId($id));
                if ($success == false) {
                    $message = "Video is unavailable";
                } else {
                    $message = "New video added";
                }
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
        echo 'hi';
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

        if (session()->has('searchUrl') == null) {
            return redirect('home/management/' . $currentFolder);
        } else {
            $searchUrl = session('searchUrl');
            session()->forget('searchUrl');
            return redirect($searchUrl);
        }
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

    public function rename(Request $request) {
        $id = $request->id;
        $type = $request->type;
        $newName = $request->newName;
        $currentFolder = $request->currentFolder;

        if ($type == 'fd') {
            $folder = Folder::find($id);
            if(count(Folder::where('folderName', $newName)->where('parent_id', $folder->parent_id)->get())>0) {
                session(['message'=>'Name already in use']);
            } else {
                $folder->folderName = $newName;
                $folder->save();
            }

        } elseif ($type == 'sp') {
            $songPlaylist = SongPlaylist::find($id);
            if(count(SongPlaylist::where('sp_name', $newName)->where('f_id', $songPlaylist->f_id)->get())>0) {
                session(['message'=>'Name already in use']);
            } else {
                $songPlaylist->sp_name = $newName;
                $songPlaylist->save();
            }
        } elseif ($type == 'lp') {
            $lessonPlaylist = LessonPlaylist::find($id);
            if(count(LessonPlaylist::where('folderName', $newName)->where('f_id', $lessonPlaylist->f_id)->get())>0) {
                session(['message'=>'Name already in use']);
            } else {
                $lessonPlaylist->l_name = $newName;
                $lessonPlaylist->save();
            }
        } else {
            session(['message'=>'Rename failed']);
        }

        if (session()->has('searchUrl') == null) {
            return redirect('home/management/' . $currentFolder);
        } else {
            $searchUrl = session('searchUrl');
            session()->forget('searchUrl');
            return redirect($searchUrl);
        }
    }

//    public static function Gift() {
//        $gifts = SendTo::where('receiver_id', session('userId'))->get();
//        return $gifts;
//    }

    public function deleteAccount(Request $request) {
        $salt = 'q5kBq8F4GAHqA';
        $uid = session('userId');
        $password = $request->password;
        $confirm = $request->confirmPassword;
        if ($password !== $confirm) {
            session(['message'=>'We know you were kidding']);
            return redirect('setting');
        } else {
            if (crypt($password, $salt) != User::find($uid)->password) {
                session(['message'=>'You are not the owner of this account, right?']);
                return redirect('setting');
            } else {
                $connections = Connection::where('u_id', $uid)->delete();
//                foreach ($connections as $connection) {
//                    $connection->delete();
//                }
                $connections = Connection::where('connect_with', $uid)->delete();
//                foreach ($connections as $connection) {
//                    $connection->delete();
//                }
                $folders = Folder::where('u_id', $uid)->get();
                foreach ($folders as $folder) {
                    $folder->delete();
                }
//                $gifts = GiftBox::join('send_tos', 'gift_boxes.g_id', '=', 'send_tos.g_id');
//                $giftsSender = $gifts->where('sender_id', $uid)->get();
                $giftsSender = GiftBox::where('sender_id', $uid)->get();
                foreach ($giftsSender as $giftSender) {
                    $giftSender->delete();
                }
//                $giftsReceiver = $gifts->where('receiver_id', $uid)->get();
                $giftsReceiver = GiftBox::where('receiver_id', $uid)->get();
                foreach ($giftsReceiver as $giftReceiver) {
                    $giftReceiver->delete();
                }
                $songs = Song::where('u_id', $uid)->get();
                foreach ($songs as $song) {
                    $song->delete();
                }
                $lessons = Lesson::where('u_id', $uid)->get();
                foreach ($lessons as $lesson) {
                    $lesson->delete();
                }
                $lessonPlaylists = LessonPlaylist::where('u_id', $uid)->get();
                foreach ($lessonPlaylists as $lessonPlaylist) {
                    $lessonPlaylist->delete();
                }
                $setting = Setting::find($uid);
                $setting->delete();
                $songPlaylists = SongPlaylist::where('u_id', $uid)->get();
                foreach ($songPlaylists as $songPlaylist) {
                    $songPlaylist->delete();
                }
                $user = User::find($uid);
                $user->delete();
                session()->forget('userId');
                session()->flush();
                return redirect('signup');
            }
        }
    }

    public function sharePublic(Request $request) {
//        $currentFolder = $request->currentFolder;
        $type = $request->type;
        $id = $request->id;
        $state = $request->state;

        if ($type == 'sp') {
            $change = $state==0?1:0;
            $playlist = SongPlaylist::find($id);
            $playlist->if_public = $change;
            $playlist->save();
            echo $change;
        } elseif ($type == 'lp') {
            $change = $state==0?1:0;
            $playlist = LessonPlaylist::find($id);
            $playlist->if_public = $change;
            $playlist->save();
            echo $change;
        }
    }

    public function connect(Request $request) {
        $now = new DateTime();
        $uid = session('userId');
        $purpose = $request->purpose;
        $personId = $request->personId;
        if ($purpose == 'add') {
            $connection1 = new Connection();
            $connection1->created_at = $now;
            $connection1->updated_at = $now;
            $connection1->u_id = $uid;
            $connection1->connect_with = $personId;
            $connection2 = new Connection();
            $connection2->created_at = $now;
            $connection2->updated_at = $now;
            $connection2->u_id = $personId;
            $connection2->connect_with = $uid;
            $connection1->save();
            $connection2->save();
        } elseif ($purpose == 'end') {
            $connection1 = Connection::where('u_id', $uid)->where('connect_with', $personId);
            $connection2 = Connection::where('connect_with', $uid)->where('u_id', $personId);
            $connection1->delete();
            $connection2->delete();
        }
    }

    public function searchPeople(Request $request) {
        $userId = session('userId');
        $peopleName = $request->name;
        $people = User::where('email', $peopleName)
            ->orWhere('username', 'like', '%' . $peopleName . '%')->where('id', '!=', $userId)->paginate(12);
//        foreach ($people as $person) {
//            echo "<div class='col-lg-4 col-md-4 col-sm-6 col-xs-12 each-connection'>";
//            echo "<div class='connection-container'>";
//            $res = Connection::where('u_id',$userId)->where('connect_with', $person->id)->get();
//            $isConnected = count($res) == 1;
//            if($isConnected){
//                echo "<div id=\"actionSearch".$person->id."\" class=\"connection-action\" onclick=\"changeConnectionOnSearch('end', '".$person->id."')\">&times;</div>";
//            }else{
//                echo "<div id=\"actionSearch".$person->id."\" class=\"connection-action\" onclick=\"changeConnectionOnSearch('add', '".$person->id."')\">+</div>";
//            }
//            echo "<div class=\"connection-profile profile-preview\" style=\"background-image: url('".asset($person->profile)."')\">";
//            echo "</div>";
//            echo "<div class=\"connection-text\">";
//            echo "<div class=\"connection-name\">";
//            echo $person->username;
//            echo "</div>";
//            echo "<div class=\"connection-description\">";
//            $desc = str_replace('<div>', '', $person->description);
//            $desc = str_replace('</div>', '', $desc);
//            $desc = str_replace('<br>', '', $desc);
//            echo substr($desc, 0, 20).(strlen($desc)>20?'...':'');
//            echo "</div>";
//            echo "</div>";
//            echo "</div>";
//            echo "</div>";
//        }
        $message = '';
        if (session()->has('message') != null) {
            $message = session('message');
            session()->forget('message');
        }

        $data = array(
            'message' => $message,
            'position' => 'connection',
            'userId' => $userId,
            'people' => $people,
            'searchPeople' => true
        );

        return view ('home', $data);
    }

    public function sendGift(Request $request) {
        $userId = session('userId');
        $currentFolder = $request->currentFolder;
        $receivers = $request->receivers;
        $type = $request->type;
        $id = $request->id;
        $now = new DateTime();
        if (isset($receivers)) {
            foreach ($receivers as $receiver) {
                $findGift = GiftBox::where('sender_id', $userId)->where('receiver_id', $receiver)
                    ->where('item_type', $type=='sp'?1:2)->where('item_id', $id)->get();
                if (count($findGift) > 0) {
                    session(['message'=>'You already send this']);
                } else {
                    $gift = new GiftBox();
                    $gift->created_at = $now;
                    $gift->updated_at = $now;
                    $gift->sender_id = $userId;
                    $gift->receiver_id = $receiver;
                    $gift->item_type = $type=='sp'?1:2;
                    $gift->item_id = $id;
                    $gift->save();
                }
            }
        }
        return redirect('home/management/'.$currentFolder);
    }

    public function receiveGift(Request $request) {
        $userId = session('userId');
        $gid = $request->gId;
        $gift = GiftBox::find($gid);
        if ($gift == null) {
            session(['message' => 'There is no such gift']);
            return redirect('gift');
        } else {
            if ($gift->receiver_id != $userId) {
                session(['message' => 'You do not own this gift']);
                return redirect('gift');
            } else {
                //send message to $gift->sender_id
                $type = $gift->item_type;
                $id = $gift->item_id;

                if ($type == 1) {
                    $now = new DateTime();
                    $myGiftFolder = Folder::where('u_id', $userId)->where('folderName', 'gift')->where('if_deletable', false)->get()[0]->f_id;
                    $newPlaylist = new SongPlaylist();
                    $oldPlaylist = SongPlaylist::find($id);
                    $newPlaylist->created_at = $now;
                    $newPlaylist->updated_at = $now;

                    $currentName = $oldPlaylist->sp_name;
                    $newName = $currentName;
                    for ($i = 1; count(SongPlaylist::where('f_id', $myGiftFolder)->where('sp_name', $newName)->get()) > 0; $i++) {
                        $newName = $currentName . " ($i)";
                    }

                    $newPlaylist->sp_name = $newName;
                    $newPlaylist->u_id = $userId;
                    $newPlaylist->f_id = $myGiftFolder;
                    $newPlaylist->if_public = false;
                    $newPlaylist->save();

                    $songs = Song::where('sp_id', $id)->get();
                    foreach ($songs as $song) {
                        $oldSong = Song::find($song->s_id);
                        $newSong = new Song();
                        $newSong->created_at = $now;
                        $newSong->updated_at = $now;
                        $newSong->title = $oldSong->title;
                        $newSong->sp_id = $newPlaylist->sp_id;
                        $newSong->url = $oldSong->url;
                        $newSong->if_favorite = false;
                        $newSong->duration = $oldSong->duration;
                        $newSong->u_id = $userId;
                        $newSong->save();
                    }
                } else if ($type == 2) {
                    $now = new DateTime();
                    $myGiftFolder = Folder::where('u_id', $userId)->where('folderName', 'gift')->where('if_deletable', false)->get()[0]->f_id;
                    $newPlaylist = new LessonPlaylist();
                    $oldPlaylist = LessonPlaylist::find($id);
                    $newPlaylist->created_at = $now;
                    $newPlaylist->updated_at = $now;

                    $currentName = $oldPlaylist->l_name;
                    $newName = $currentName;
                    for ($i = 1; count(LessonPlaylist::where('f_id', $myGiftFolder)->where('l_name', $newName)->get()) > 0; $i++) {
                        $newName = $currentName . " ($i)";
                    }

                    $newPlaylist->l_name = $newName;
                    $newPlaylist->u_id = $userId;
                    $newPlaylist->f_id = $myGiftFolder;
                    $newPlaylist->record = '';
                    $newPlaylist->if_public = false;
                    $newPlaylist->save();

                    $lessons = Lesson::where('lp_id', $id)->get();
                    foreach ($lessons as $lesson) {
                        $oldLesson = Lesson::find($lesson->l_id);
                        $newLesson = new Lesson();
                        $newLesson->created_at = $now;
                        $newLesson->updated_at = $now;
                        $newLesson->title = $oldLesson->title;
                        $newLesson->lp_id = $newPlaylist->l_id;
                        $newLesson->url = $oldLesson->url;
                        $newLesson->start_time = 0;
                        $newLesson->end_time = $oldLesson->end_time;
                        $newLesson->note = $oldLesson->note;
                        $newLesson->u_id = $userId;
                        $newLesson->save();
                    }
                }

                $gift->delete();

                if (session()->has('searchUrl') == null) {
                    return redirect('gift');
                } else {
                    $searchUrl = session('searchUrl');
                    session()->forget('searchUrl');
                    return redirect($searchUrl);
                }
            }
        }
    }

    public function rejectGift(Request $request) {
        $userId = session('userId');
        $gid = $request->gId;
        $gift = GiftBox::find($gid);
        if ($gift == null) {
            session(['message' => 'There is no such gift']);
            return redirect('gift');
        } else {
            if ($gift->receiver_id != $userId) {
                session(['message' => 'You do not own this gift']);
                return redirect('gift');
            } else {
                //send message to $gift->sender_id
                $gift->delete();

                if (session()->has('searchUrl') == null) {
                    return redirect('gift');
                } else {
                    $searchUrl = session('searchUrl');
                    session()->forget('searchUrl');
                    return redirect($searchUrl);
                }
            }
        }

    }

    public function renameSong (Request $request) {
        $currentPlaylist = $request->currentPlaylist;
        $id = $request->id;
        $newName = $request->newName;

        $song = Song::find($id);
        if ($song == null) {
            session(['message' => 'video not exist']);
        } else {
            $song->title = $newName;
            $song->save();
        }
        return redirect('home/management/playSong/'.$currentPlaylist);
    }

    public function renameLesson (Request $request) {
        $currentPlaylist = $request->currentPlaylist;
        $id = $request->id;
        $newName = $request->newName;

        $lesson = Lesson::find($id);
        if ($lesson == null) {
            session(['message' => 'video not exist']);
        } else {
            $lesson->title = $newName;
            $lesson->save();
        }
        return redirect('home/management/playLesson/'.$currentPlaylist);
    }

    public function editUsername(Request $request) {
        $userId = session('userId');
        $value = $request->value;
        if (User::existUsername($value) == false) {
            $user = User::find($userId);
            $user->username = $value;
            $user->save();
            session(['message'=>'Username changed']);
            return redirect('setting');
        } else {
            session(['message'=>'Username not available']);
            return redirect('setting');
        }
    }

    public function editEmail(Request $request) {
        $userId = session('userId');
        $value = $request->value;
        if (User::checkExistedUser($value) == false) {
            $user = User::find($userId);
            $user->email = $value;
            $user->save();
            session(['message'=>'Email changed']);
            return redirect('setting');
        } else {
            session(['message'=>'E-mail not available']);
            return redirect('setting');
        }
    }

    public function editDescription(Request $request) {
        $userId = session('userId');
        $value = $request->value;
        $user = User::find($userId);
        $user->description = $value;
        $user->save();
        session(['message'=>'Description edited']);
        return redirect('setting');
    }

    public function searchItem(Request $request) {
        $userId = session('userId');
        $item = $request->item;
        $type = $request->type;
//        if ($item == '' && !isset($page)) {
//            return redirect('home');
//        }

        $message = '';
        if(session()->has('message') != null) {
            $message = session('message');
            session()->forget('message');
        }


        $results = array();

        if ($type == 'lp') {
            $publicLP = LessonPlaylist::where('u_id', '!=', $userId)->where('if_public', true)
                ->where('l_name', 'like', '%' . $item . '%');
            $giftLP = LessonPlaylist::join('gift_boxes', 'item_id', '=', 'l_id')->where('item_type', '2')
                ->where('receiver_id', $userId)->where('l_name', 'like', '%' . $item . '%')
                ->select('l_id', 'lesson_playlists.created_at as created_at', 'lesson_playlists.updated_at as updated_at', 'l_name', 'u_id', 'f_id', 'record', 'if_public');
            $ownLP = LessonPlaylist::where('u_id', $userId)->where('l_name', 'like', '%' . $item . '%')
                ->union($giftLP)->union($publicLP)->get();

            foreach ($ownLP as $lp) {
                array_push($results, $lp);
            }
        } elseif ($type == 'sp') {
            $publicSP = SongPlaylist::where('u_id', '!=', $userId)->where('if_public', true)
                ->where('sp_name', 'like', '%' . $item . '%');
            $giftSP = SongPlaylist::join('gift_boxes', 'item_id', '=', 'sp_id')->where('item_type', '1')
                ->where('receiver_id', $userId)->where('sp_name', 'like', '%' . $item . '%')
                ->select('sp_id', 'song_playlists.created_at as created_at', 'song_playlists.updated_at as updated_at', 'sp_name', 'u_id', 'f_id', 'if_public');
            $ownSP = SongPlaylist::where('u_id', $userId)->where('sp_name', 'like', '%' . $item . '%')
                ->union($giftSP)->union($publicSP)->get();

            foreach ($ownSP as $sp) {
                array_push($results, $sp);
            }
        }


        $connections = Connection::join('users', 'id', '=', 'connect_with')->where('u_id', $userId)->get();
        $searchUrl = 'home/search/result?item='.$item;
        session(['searchUrl' => $searchUrl]);


        $data = array(
            'search' => true,
            'position' => 'home',
            'message' => $message,
            'type' => $type,
//            'ownLP' => $ownLP,
//            'ownSP' => $ownSP,
//            'ownLP' => self::paginateArray($LPs, $request, 1),
            'results' => self::paginateArray($results, $request, 1),
            'connections' => $connections,
            'searchUrl' => $searchUrl
//            'ownSP' => SongPlaylist::paginate(1)
        );
//        echo 1;
        return view('searchContent', $data);
    }

    public function getSPFromPublic(Request $request) {
        $userId = session('userId');
        $spId = $request->id;
        $sp = SongPlaylist::find($spId);
        if ($sp == null) {
            session(['message' => 'There is no such playlist']);
            if(session()->has('searchUrl') != null) {
                $searchUrl = session('searchUrl');
                session()->forget('searchUrl');
                return redirect($searchUrl);
            } else {
                return redirect('home');
            }
        } else {
            if ($sp->if_public != true) {
                session(['message' => 'This playlist is not for public']);
                if(session()->has('searchUrl') != null) {
                    $searchUrl = session('searchUrl');
                    session()->forget('searchUrl');
                    return redirect($searchUrl);
                } else {
                    return redirect('home');
                }
            } else {
                    $now = new DateTime();
                    $myDownloadFolder = Folder::where('u_id', $userId)->where('folderName', 'from public')->where('if_deletable', false)->get()[0]->f_id;
                    $newPlaylist = new SongPlaylist();
                    $newPlaylist->created_at = $now;
                    $newPlaylist->updated_at = $now;


                    $currentName = $sp->sp_name;
                    $newName = $currentName;
                    for ($i = 1; count(SongPlaylist::where('f_id', $myDownloadFolder)->where('sp_name', $newName)->get()) > 0; $i++) {
                        $newName = $currentName . " ($i)";
                    }

                    $newPlaylist->sp_name = $newName;
                    $newPlaylist->u_id = $userId;
                    $newPlaylist->f_id = $myDownloadFolder;
                    $newPlaylist->if_public = false;
                    $newPlaylist->save();

                    $songs = Song::where('sp_id', $spId)->get();
                    foreach ($songs as $song) {
                        $oldSong = Song::find($song->s_id);
                        $newSong = new Song();
                        $newSong->created_at = $now;
                        $newSong->updated_at = $now;
                        $newSong->title = $oldSong->title;
                        $newSong->sp_id = $newPlaylist->sp_id;
                        $newSong->url = $oldSong->url;
                        $newSong->if_favorite = false;
                        $newSong->duration = $oldSong->duration;
                        $newSong->u_id = $userId;
                        $newSong->save();
                    }

                    session(['message' => 'moved to folder "from public"']);

                if (session()->has('searchUrl') == null) {
                    return redirect('home');
                } else {
                    $searchUrl = session('searchUrl');
                    session()->forget('searchUrl');
                    return redirect($searchUrl);
                }
            }
        }
    }

    public function getLPFromPublic(Request $request) {
        $userId = session('userId');
        $lpId = $request->id;
        $lp = LessonPlaylist::find($lpId);
        if ($lp == null) {
            session(['message' => 'There is no such playlist']);
            if(session()->has('searchUrl') != null) {
                $searchUrl = session('searchUrl');
                session()->forget('searchUrl');
                return redirect($searchUrl);
            } else {
                return redirect('home');
            }
        } else {
            if ($lp->if_public != true) {
                session(['message' => 'This playlist is not for public']);
                if(session()->has('searchUrl') != null) {
                    $searchUrl = session('searchUrl');
                    session()->forget('searchUrl');
                    return redirect($searchUrl);
                } else {
                    return redirect('home');
                }
            } else {

                $now = new DateTime();
                $myDownloadFolder = Folder::where('u_id', $userId)->where('folderName', 'from public')->where('if_deletable', false)->get()[0]->f_id;
                $newPlaylist = new LessonPlaylist();
                $newPlaylist->created_at = $now;
                $newPlaylist->updated_at = $now;

                $currentName = $lp->l_name;
                $newName = $currentName;
                for ($i = 1; count(LessonPlaylist::where('f_id', $myDownloadFolder)->where('l_name', $newName)->get()) > 0; $i++) {
                    $newName = $currentName . " ($i)";
                }

                $newPlaylist->l_name = $newName;
                $newPlaylist->u_id = $userId;
                $newPlaylist->f_id = $myDownloadFolder;
                $newPlaylist->record = '';
                $newPlaylist->if_public = false;
                $newPlaylist->save();

                $lessons = Lesson::where('lp_id', $lpId)->get();
                foreach ($lessons as $lesson) {
                    $oldLesson = Lesson::find($lesson->l_id);
                    $newLesson = new Lesson();
                    $newLesson->created_at = $now;
                    $newLesson->updated_at = $now;
                    $newLesson->title = $oldLesson->title;
                    $newLesson->lp_id = $newPlaylist->l_id;
                    $newLesson->url = $oldLesson->url;
                    $newLesson->start_time = 0;
                    $newLesson->end_time = $oldLesson->end_time;
                    $newLesson->note = $oldLesson->note;
                    $newLesson->u_id = $userId;
                    $newLesson->save();
                }

                session(['message' => 'moved to folder "from public"']);

                if (session()->has('searchUrl') == null) {
                    return redirect('home');
                } else {
                    $searchUrl = session('searchUrl');
                    session()->forget('searchUrl');
                    return redirect($searchUrl);
                }
            }
        }
    }

    public function checkPath(Request $request) {
        $userId = session('userId');
        $path = $request->path;
        $lastDir = $request->lastType;
        $currentFolder = $request->currentFolder;
        $homeId = Folder::where('u_id', $userId)->where('folderName', 'home')->where('if_deletable', false)->get()[0]->f_id;

        $dir = explode( '/', $path );

        $dirId = null;
        if (count($dir) == 1) {
            $dirId = $currentFolder;
        } else {
            for ($i = 0; $i < count($dir) - 1; $i++) {
                if ($i == 0) {
                    $dirId = $this->getPathId($dir[$i], $currentFolder);
                    if ($dirId == false) {
                    echo json_encode([false, $path]);
//                        echo json_encode([false, 'first try']);
                        return;
                    }
                } else {
                    $dirId = $this->getPathId($dir[$i], $dirId);
                    if ($dirId == false) {
                    echo json_encode([false, $path]);
//                        echo json_encode([false, 'second try']);
                        return;
                    }
                }
            }
        }
        if ($request->type == 'fd')
            $dests = Folder::where('parent_id', $dirId)->where('f_id', '!=', $request->id)->where('u_id', $userId)->where('folderName', 'like', $lastDir.'%')->where('folderName', '!=', 'home')->get();
        else
            $dests = Folder::where('parent_id', $dirId)->where('u_id', $userId)->where('folderName', 'like', $lastDir.'%')->where('folderName', '!=', 'home')->get();
        if (count($dests) == 0) {
            if ($lastDir == '') {
                echo json_encode([true, $path]);
            } else {
                echo json_encode([false, $path]);
//            echo json_encode([false, 'third']);
                return;
            }
        } else {
            $exist = false;
            foreach ($dests as $key=>$dest) {
                if(end($dir) == $dest->folderName) {
                    $exist = true;
                    break;
                }
            }
            if($exist == false) {
                echo json_encode([true, substr($path, 0, strlen($path)-strlen($dir[count($dir)-1])).$dests[0]->folderName]);
//                echo json_encode([true, $dir[1]]);
                return;
            } else {
                if($key == count($dests)-1) {
                    $key = -1;
                }
//                echo json_encode([true, $dests[$key]->folderName]);
                echo json_encode([true, substr($path, 0, strlen($path)-strlen($dir[count($dir)-1])).$dests[$key+1]->folderName]);
                return;
            }
        }
//        echo json_encode([false, 'last try']);
//        return;
    }


    public function move(Request $request) {
        $userId = session('userId');
        $id = $request->id;
        $type = $request->type;
        $currentFolder = $request->currentFolder;
        $path = $request->path;

        $dir = explode( '/', $path );

//        for ($i = 0; $i < count($dir); $i++) {
//            if ($i < count($dir)-1) {
//                if (strpos($dir[$i], '\\') == strlen($dir[$i])-1) {
//                    $dir[$i] = substr($dir[$i], 0, strlen($dir[$i])-1);
//                    unset($dir[$i+1]);
//                }
//            }
//        }

        if (count($dir) == 1) {
            if(strlen($dir[0]) == 0) {
                session(['message'=>'Destination not defined']);
                return redirect('home/management/'.$currentFolder);
            } else {
                $dest = Folder::where('parent_id', $currentFolder)->where('u_id', $userId)->where('folderName', $dir[0])->get();
                if(count($dest) == 1) {
                    if ($type == 'fd') {
                        $goal = Folder::find($id);
                        $goal->parent_id = $dest[0]->f_id;
                        $goal->save();
                    } elseif ($type == 'sp') {
                        $goal = SongPlaylist::find($id);
                        $goal->f_id = $dest[0]->f_id;
                        $goal->save();
                    } elseif ($type == 'lp') {
                        $goal = LessonPlaylist::find($id);
                        $goal->f_id = $dest[0]->f_id;
                        $goal->save();
                    }
                    session(['message'=>'Move successfully']);
                } else {
                    session(['message' => 'Path incorrect']);
                }
                return redirect('home/management/'.$currentFolder);
//                return redirect('home/management/'.$dest[0]->f_id);
            }
        } elseif (count($dir) > 1) {
            $dirId = null;
            for ($i = 0; $i < count($dir); $i++) {
                if ($i == 0) {
                    $dirId = $this->getPathId($dir[$i], $currentFolder);
                    if ($dirId == false) {
                        session(['message' => 'Path incorrect']);
                        break;
                    }
                } elseif ($i == count($dir) - 1) {
                    if($dir[$i] == '') {
                        $i++;
                        break;
                    } else {
                        $dirId = $this->getPathId($dir[$i], $dirId);
                        if ($dirId == false) {
                            session(['message' => 'Path incorrect']);
                            break;
                        }
                    }
                } else {
                    $dirId = $this->getPathId($dir[$i], $dirId);
                    if ($dirId == false) {
                        session(['message' => 'Path incorrect']);
                        break;
                    }
                }
            }
            if ($i == count($dir)) {
                if ($type == 'fd') {
                    $goal = Folder::find($id);
                    $goal->parent_id = $dirId;
                    $goal->save();
                } elseif ($type == 'sp') {
                    $goal = SongPlaylist::find($id);
                    $goal->f_id = $dirId;
                    $goal->save();
                } elseif ($type == 'lp') {
                    $goal = LessonPlaylist::find($id);
                    $goal->f_id = $dirId;
                    $goal->save();
                }
                session(['message'=>'Move successfully']);
            } else {
                session(['message'=>'Move failed']);
            }
            return redirect('home/management/'.$currentFolder);
//            return redirect('home/management/'.$dirId);
        }

    }

    #PARAM $now is name of current folder
    #PARAM $parentId is if of parent folder
    #for first routing, $parentId is id of current folder
    private function getPathId($now, $parentId) {
//        not used if count($dir) == 1 and '' is the last
        $userId = session('userId');
        if ($now == '') {
            $nows = Folder::where('u_id', $userId)->where('folderName', 'home')->where('if_deletable', false)->get();
            if(count($nows) == 1) {
                return $nows[0]->f_id;
            } else {
                return false;
            }
        } elseif ($now == '.') {
            return $parentId;
        } elseif ($now == '..') {
            $grandParent = Folder::find($parentId)->parent_id;
            return $grandParent;
        } else {
            $nows = Folder::where('u_id', $userId)->where('folderName', $now)->where('parent_id', $parentId)->get();
            if(count($nows) == 1) {
                return $nows[0]->f_id;
            } else {
                return false;
            }
        }
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
        $lesson->end_time = PageController::duration($duration);
        if ($lesson->end_time == 0) {
            return false;
        }
        $lesson->created_at = new DateTime();
        $lesson->updated_at = new DateTime();
        $lesson->title =($videoTitle != '')?($videoTitle):
            (PageController::getTitleFromId($id));
        $lesson->lp_id = $lessonPlaylist;
        $lesson->url = $id;
        $lesson->u_id = $userId;
        $lesson->start_time = 0;
        $lesson->note = '';
        $lesson->save();
        return true;
    }

    private function addSong($videoTitle, $id, $songPlaylist, $duration) {
        $userId = session('userId');
        $song = new Song();
        $song->duration = PageController::duration($duration);
        if ($song->duration == 0) {
            return false;
        }
        $song->created_at = new DateTime();
        $song->updated_at = new DateTime();
        $song->title = ($videoTitle != '')?($videoTitle):
            (PageController::getTitleFromId($id));
        $song->sp_id = $songPlaylist;
        $song->url = $id;
        $song->u_id = $userId;
        $song->if_favorite = false;
        $song->save();
        return true;
    }

    public function searchQuestion(Request $request) {
        $userId = session('userId');
        $question = $request->question;
        $wordList = self::getWordList($question);
        $countRecord = QNA::count();
        $arrayResults = array();
        for ($i = 0; $i < $countRecord; $i++) {
            $data = QNA::take(1)->skip($i)->get();
//            echo $i.'---'.$data->get()[0]['question'].'<br>';
            if (count($data) > 0) {
                $dataRaw = $data[0]['keyword'];
                $dataArr = explode(',', $dataRaw);
                $score = self::getCompareScore($wordList, $dataArr);
                $getQ = QNA::find($data[0]->id);
                $getQ->frequency = $getQ->frequency + $score;
                $getQ->save();
//                echo $score.'<br>';
                $assocData = [
                    'data' => $data[0],
                    'score' => $score
                ];
                $arrayResults = self::addElementTopN($arrayResults, $assocData, 20);
            }
        }

        usort($arrayResults, 'self::compare_score');

//        foreach ($arrayResults as $arrayResult) {
//            echo $arrayResult['data']['id'].'<br/>';
//        }

        $collectionResults = array();
        foreach ($arrayResults as $arrayResult) {
            $q = new QNA();
            $q->id = $arrayResult['data']['id'];
            $q->created_at = $arrayResult['data']['created_at'];
            $q->updated_at = $arrayResult['data']['updated_at'];
            $q->question = $arrayResult['data']['question'];
            $q->answer = $arrayResult['data']['answer'];
            $q->frequency = $arrayResult['data']['frequency'];
            $q->keyword = $arrayResult['data']['keyword'];
            $q->category = $arrayResult['data']['category'];
            array_push($collectionResults, $q);
//            $collectionResults->push($q);
        }


//        //pagination on array
//        $page = Input::get('page', 1); // Get the ?page=1 from the url
//        $perPage = 10; // Number of items per page
//        $offset = ($page * $perPage) - $perPage;
//
//        $paginateResult = new LengthAwarePaginator(
//            array_slice($collectionResults, $offset, $perPage, true), // Only grab the items we need
//            count($collectionResults), // Total items
//            $perPage, // Items per page
//            $page, // Current page
//            ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
//        );

        $paginateResult = self::paginateArray($collectionResults, $request, 10);


        $message = '';
        if(session()->has('message') != null) {
            $message = session('message');
            session()->forget('message');
        }

        $data = array(
            'message' => $message,
            'position' => 'help',
            'userId' => $userId,
            'questions' => $paginateResult,
            'question' => $question,
            'searchQuestion' => true
        );

//        foreach ($arrayResults as $arrayResult) {
//            echo $arrayResult['data']['question'].'<br/>';
//        }


        return view ('home', $data);
    }

    public static function getWordList($sentence) {
//        $stopWords = array("a", "about", "above", "above", "across", "after", "afterwards", "again", "against", "all", "almost", "alone", "along", "already", "also","although","always","am","among", "amongst", "amoungst", "amount",  "an", "and", "another", "any","anyhow","anyone","anything","anyway", "anywhere", "are", "around", "as",  "at", "back","be","became", "because","become","becomes", "becoming", "been", "before", "beforehand", "behind", "being", "below", "beside", "besides", "between", "beyond", "bill", "both", "bottom","but", "by", "call", "can", "cannot", "cant", "co", "con", "could", "couldnt", "cry", "de", "describe", "detail", "do", "done", "down", "due", "during", "each", "eg", "eight", "either", "eleven","else", "elsewhere", "empty", "enough", "etc", "even", "ever", "every", "everyone", "everything", "everywhere", "except", "few", "fifteen", "fify", "fill", "find", "fire", "first", "five", "for", "former", "formerly", "forty", "found", "four", "from", "front", "full", "further", "get", "give", "go", "had", "has", "hasnt", "have", "he", "hence", "her", "here", "hereafter", "hereby", "herein", "hereupon", "hers", "herself", "him", "himself", "his", "how", "however", "hundred", "ie", "if", "in", "inc", "indeed", "interest", "into", "is", "it", "its", "itself", "keep", "last", "latter", "latterly", "least", "less", "ltd", "made", "many", "may", "me", "meanwhile", "might", "mill", "mine", "more", "moreover", "most", "mostly", "move", "much", "must", "my", "myself", "name", "namely", "neither", "never", "nevertheless", "next", "nine", "no", "nobody", "none", "noone", "nor", "not", "nothing", "now", "nowhere", "of", "off", "often", "on", "once", "one", "only", "onto", "or", "other", "others", "otherwise", "our", "ours", "ourselves", "out", "over", "own","part", "per", "perhaps", "please", "put", "rather", "re", "same", "see", "seem", "seemed", "seeming", "seems", "serious", "several", "she", "should", "show", "side", "since", "sincere", "six", "sixty", "so", "some", "somehow", "someone", "something", "sometime", "sometimes", "somewhere", "still", "such", "system", "take", "ten", "than", "that", "the", "their", "them", "themselves", "then", "thence", "there", "thereafter", "thereby", "therefore", "therein", "thereupon", "these", "they", "thickv", "thin", "third", "this", "those", "though", "three", "through", "throughout", "thru", "thus", "to", "together", "too", "top", "toward", "towards", "twelve", "twenty", "two", "un", "under", "until", "up", "upon", "us", "very", "via", "was", "we", "well", "were", "what", "whatever", "when", "whence", "whenever", "where", "whereafter", "whereas", "whereby", "wherein", "whereupon", "wherever", "whether", "which", "while", "whither", "who", "whoever", "whole", "whom", "whose", "why", "will", "with", "within", "without", "would", "yet", "you", "your", "yours", "yourself", "yourselves", "the");
        $stopWords = array('a','able','about','above','abroad','according','accordingly','across','actually','adj','after','afterwards','again','against','ago','ahead','ain\'t','all','allow','allows','almost','alone','along','alongside','already','also','although','always','am','amid','amidst','among','amongst','an','and','another','any','anybody','anyhow','anyone','anything','anyway','anyways','anywhere','apart','appear','appreciate','appropriate','are','aren\'t','around','as','a\'s','aside','ask','asking','associated','at','available','away','awfully','b','back','backward','backwards','be','became','because','become','becomes','becoming','been','before','beforehand','begin','behind','being','believe','below','beside','besides','best','better','between','beyond','both','brief','but','by','c','came','can','cannot','cant','can\'t','caption','cause','causes','certain','certainly','changes','clearly','c\'mon','co','co.','com','come','comes','concerning','consequently','consider','considering','contain','containing','contains','corresponding','could','couldn\'t','course','c\'s','currently','d','dare','daren\'t','definitely','described','despite','did','didn\'t','different','directly','do','does','doesn\'t','doing','done','don\'t','down','downwards','during','e','each','edu','eg','eight','eighty','either','else','elsewhere','end','ending','enough','entirely','especially','et','etc','even','ever','evermore','every','everybody','everyone','everything','everywhere','ex','exactly','example','except','f','fairly','far','farther','few','fewer','fifth','first','five','followed','following','follows','for','forever','former','formerly','forth','forward','found','four','from','further','furthermore','g','get','gets','getting','given','gives','go','goes','going','gone','got','gotten','greetings','h','had','hadn\'t','half','happens','hardly','has','hasn\'t','have','haven\'t','having','he','he\'d','he\'ll','hello','help','hence','her','here','hereafter','hereby','herein','here\'s','hereupon','hers','herself','he\'s','hi','him','himself','his','hither','hopefully','how','howbeit','however','hundred','i','i\'d','ie','if','ignored','i\'ll','i\'m','immediate','in','inasmuch','inc','inc.','indeed','indicate','indicated','indicates','inner','inside','insofar','instead','into','inward','is','isn\'t','it','it\'d','it\'ll','its','it\'s','itself','i\'ve','j','just','k','keep','keeps','kept','know','known','knows','l','last','lately','later','latter','latterly','least','less','lest','let','let\'s','like','liked','likely','likewise','little','look','looking','looks','low','lower','ltd','m','made','mainly','make','makes','many','may','maybe','mayn\'t','me','mean','meantime','meanwhile','merely','might','mightn\'t','mine','minus','miss','more','moreover','most','mostly','mr','mrs','much','must','mustn\'t','my','myself','n','name','namely','nd','near','nearly','necessary','need','needn\'t','needs','neither','never','neverf','neverless','nevertheless','new','next','nine','ninety','no','nobody','non','none','nonetheless','noone','no-one','nor','normally','not','nothing','notwithstanding','novel','now','nowhere','o','obviously','of','off','often','oh','ok','okay','old','on','once','one','ones','one\'s','only','onto','opposite','or','other','others','otherwise','ought','oughtn\'t','our','ours','ourselves','out','outside','over','overall','own','p','particular','particularly','past','per','perhaps','placed','please','plus','possible','presumably','probably','provided','provides','q','que','quite','qv','r','rather','rd','re','really','reasonably','recent','recently','regarding','regardless','regards','relatively','respectively','right','round','s','said','same','saw','say','saying','says','second','secondly','see','seeing','seem','seemed','seeming','seems','seen','self','selves','sensible','sent','serious','seriously','seven','several','shall','shan\'t','she','she\'d','she\'ll','she\'s','should','shouldn\'t','since','six','so','some','somebody','someday','somehow','someone','something','sometime','sometimes','somewhat','somewhere','soon','sorry','specified','specify','specifying','still','sub','such','sup','sure','t','take','taken','taking','tell','tends','th','than','thank','thanks','thanx','that','that\'ll','thats','that\'s','that\'ve','the','their','theirs','them','themselves','then','thence','there','thereafter','thereby','there\'d','therefore','therein','there\'ll','there\'re','theres','there\'s','thereupon','there\'ve','these','they','they\'d','they\'ll','they\'re','they\'ve','thing','things','think','third','thirty','this','thorough','thoroughly','those','though','three','through','throughout','thru','thus','till','to','together','too','took','toward','towards','tried','tries','truly','try','trying','t\'s','twice','two','u','un','under','underneath','undoing','unfortunately','unless','unlike','unlikely','until','unto','up','upon','upwards','us','use','used','useful','uses','using','usually','v','value','various','versus','very','via','viz','vs','w','want','wants','was','wasn\'t','way','we','we\'d','welcome','well','we\'ll','went','were','we\'re','weren\'t','we\'ve','what','whatever','what\'ll','what\'s','what\'ve','when','whence','whenever','where','whereafter','whereas','whereby','wherein','where\'s','whereupon','wherever','whether','which','whichever','while','whilst','whither','who','who\'d','whoever','whole','who\'ll','whom','whomever','who\'s','whose','why','will','willing','wish','with','within','without','wonder','won\'t','would','wouldn\'t','x','y','yes','yet','you','you\'d','you\'ll','your','you\'re','yours','yourself','yourselves','you\'ve','z','zero');
        $sentence = preg_replace('/\b('.implode('|',$stopWords).')\b/','',$sentence);
        $sentence = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $sentence);
        $sentence = strtolower ( $sentence );
        $sentence = preg_replace('/'.implode('\s|\s',$stopWords).'/u', 'a',$sentence);
        $sentence = preg_replace('/\s+/', ' ', $sentence);
        $sentence = explode( ' ', $sentence );
        if (in_array( $sentence[0], $stopWords)) {
            unset($sentence[0]);
        }
        if (in_array( $sentence[count($sentence)-1], $stopWords)) {
            unset($sentence[count($sentence)-1]);
        }
        $final = array();
        foreach ($sentence as $word) {
            array_push($final, $word);
        }
        return $final;
    }


    public static function getCompareScore($sentence /*array*/, $keyword /*array*/) {
        $count = 0;
        for ($i = 0; $i < count($sentence); $i++) {
            if (in_array($sentence[$i], $keyword)) {
                $count++;
            }
        }
//        var_dump($sentence);
//        echo '<br>';
//        echo $count;
        return $count/(float)count($sentence);
    }

    //    $sentence = array(
    //        searchResult,
    //        score
    //    );
    public static function addElementTopN($array, $newElement, $limit = 20) {
        if (count($array) >= $limit) {
            $arr = array_column($array, 'score');
            $min = min($arr);
            $pos = array_search($min, $arr);
            if ($newElement['score'] > $min) {
                unset($array[$pos]);
                array_push($array, $newElement);
            }
        } else {
            array_push($array, $newElement);
        }
        return $array;
    }

    //sort descend
    public static function compare_score($a, $b)
    {
        if ($a['score'] > $b['score']) {
            return -1;
        }
        elseif ($a['score'] < $b['score']) {
            return 1;
        } else {
            return 0;
        }
    }

    public function addItem($obj, $key = null) {
        if ($key == null) {
            $this->items[] = $obj;
        }
        else {
            if (isset($this->items[$key])) {
                throw new KeyHasUseException("Key $key already in use.");
            }
            else {
                $this->items[$key] = $obj;
            }
        }
    }

    public static function paginateArray($array, $request, $perPage, $isArray = true) {
        //pagination on array
        $page = Input::get('page', 1); // Get the ?page=1 from the url
        $offset = ($page * $perPage) - $perPage;

        if ($isArray) {
            $arr = $array;
        } else {
            $arr = $array->toArray();
        }

        $paginateResult = new LengthAwarePaginator(
            array_slice($arr, $offset, $perPage, true), // Only grab the items we need
            count($array), // Total items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // We need this so we can keep all old query parameters from the url
        );

        return $paginateResult;
    }
}
