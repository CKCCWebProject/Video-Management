<div class="row" style="text-align: center; margin-bottom: 10px">
    @include('directories')
</div>
<div class="row">
    @include('createFolder')
</div>
<div class="row">
    <ul class="folder-group">
        @foreach($folders as $folder)

            <li class="row each-folder" style="display: flex; align-items: center;">
                <div style="float: left;">
                    <div>
                        <a href="{{url('home/management/'.$folder->f_id)}}">
                            @include('folder')
                        </a>
                    </div>
                </div>
                <div class="fold-text" style="float: left; color: black;">
                    <div class="fold-name">
                        {{$folder->folderName}}
                    </div>
                    <div class="fold-info">
                        created at {{$folder->created_at}}
                    </div>
                </div>
                <div class="folder-setting dropdown">
                    <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                    <ul class="dropdown-menu setting-option">
                        <li class="set-opt"><a href="#">share setting</a></li>
                        <li class="set-opt"><a href="#">delete</a></li>
                    </ul>
                </div>
            </li>

        @endforeach

        @foreach($playlists as $playlist)
        <li class="row each-folder" style="display: flex; align-items: center;">
            <div style="float: left;">
                <div>
                    <a href="{{url('home/management/playSong/'.$playlist->sp_id)}}">
                        @include('playlist')
                    </a>
                </div>
                <div>

                </div>
            </div>
            <div class="fold-text" style="float: left; color: black;">
                <div class="fold-name">
                    {{$playlist->sp_name}}
                </div>
                <div class="fold-info">
                    created at {{$playlist->created_at}}
                </div>
            </div>
            <div class="folder-setting dropdown">
                <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                <ul class="dropdown-menu setting-option">
                    <li class="set-opt"><a href="#">edit</a></li>
                    <li class="set-opt"><a href="#">share setting</a></li>
                    <li class="set-opt"><a href="#">delete</a></li>
                </ul>
            </div>
        </li>

        @endforeach

        @foreach($lessons as $lesson)

        <li class="row each-folder" style="display: flex; align-items: center;">
            <div style="float: left;">
                <div>
                    <a href="{{url('home/management/playLesson/'.$lesson->l_id)}}">
                        @include('lesson')
                    </a>
                </div>
            </div>
            <div class="fold-text" style="float: left; color: black;">
                <div class="fold-name">
                    {{$lesson->l_name}}
                </div>
                <div class="fold-info">
                    created at {{$lesson->created_at}}
                </div>
            </div>
            <div class="folder-setting dropdown">
                <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                <ul class="dropdown-menu setting-option">
                    <li class="set-opt"><a href="#">edit</a></li>
                    <li class="set-opt"><a href="#">share setting</a></li>
                    <li class="set-opt"><a href="#">delete</a></li>
                </ul>
            </div>
        </li>

        @endforeach
    </ul>
</div>