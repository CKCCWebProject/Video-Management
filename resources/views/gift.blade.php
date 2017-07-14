<li class="row each-folder" style="display: flex; align-items: center;">
    <div style="float: left;">
        <div>
            <a href="{{url('home/management/'.($gift->item_type==1?'playSong':'playLesson').'/'.$gift->id)}}">
                @if($gift->item_type==1)
                    @include('playlist')
                @elseif ($gift->item_type==2)
                    @include('lesson')
                @endif
            </a>
        </div>
    </div>
    <div class="fold-text" style="float: left; color: black;">
        <a href="{{url('home/management/'.($gift->item_type==1?'playSong':'playLesson').'/'.$gift->id)}}">
            <div class="fold-name">
                @if($gift->item_type==1)
                    {{ \App\SongPlaylist::find($gift->item_id)->sp_name }}
                @elseif ($gift->item_type==2)
                    {{ \App\LessonPlaylist::find($gift->item_id)->l_name }}
                @endif

            </div>
            <div class="fold-info">
                From : {{\App\User::find($gift->sender_id)->usernamet}}
            </div>
        </a>

    </div>
    {{--<div class="folder-setting dropdown">--}}
        {{--<i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>--}}
        {{--<ul class="dropdown-menu setting-option">--}}
            {{--<li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('sp', '{{$playlist->sp_id}}', '{{$playlist->sp_name}}')">rename</a></li>--}}
            {{--<li class="set-opt"><a href="#">share setting</a></li>--}}
            {{--<li class="set-opt delete-color"><a data-toggle="modal" data-target="#deleteFolder" onclick="formDelete('song', '{{$playlist->sp_id}}')">delete</a></li>--}}
        {{--</ul>--}}
    {{--</div>--}}
    accept
    reject
</li>