@if(isset($folder))
    <li class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            <div>
                <a href="{{url('home/management/'.$folder->f_id)}}">
                    @include('folder')
                </a>
            </div>
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <a href="{{url('home/management/'.$folder->f_id)}}">
                <div class="fold-name">
                    {{$folder->folderName}}
                </div>
                <div class="fold-info">
                    created at {{$folder->created_at}}
                </div>
            </a>
        </div>
        @if($folder->if_deletable)
            <div class="folder-setting dropdown">
                <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                <ul class="dropdown-menu setting-option">
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('fd', '{{$folder->f_id}}', '{{$folder->folderName}}')">rename</a></li>
                    {{--<li class="set-opt"><a href="#">share setting</a></li>--}}
                    <li class="set-opt delete-color"><a data-toggle="modal" data-target="#deleteFolder" onclick="formDelete('folder', '{{$folder->f_id}}')">delete</a></li>
                </ul>
            </div>
        @endif
    </li>
@elseif(isset($playlist))
    <li class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            <div>
                <a href="{{url('home/management/playSong/'.$playlist->sp_id)}}">
                    @include('playlist')
                </a>
            </div>
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <a href="{{url('home/management/playSong/'.$playlist->sp_id)}}">
                <div class="fold-name">
                    {{$playlist->sp_name}}
                </div>
                <div class="fold-info">
                    {!! $playlist->if_public?'<i class="fa fa-globe"></i>':'' !!} created at {{$playlist->created_at}}
                </div>
            </a>

        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('sp', '{{$playlist->sp_id}}', '{{$playlist->sp_name}}')">rename</a></li>
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#share-setting">share setting</a></li>
                <li class="set-opt delete-color"><a data-toggle="modal" data-target="#deleteFolder" onclick="formDelete('song', '{{$playlist->sp_id}}')">delete</a></li>
            </ul>
        </div>
    </li>
@elseif(isset($lesson))
    <li class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            <div>
                <a href="{{url('home/management/playLesson/'.$lesson->l_id)}}">
                    @include('lesson')
                </a>
            </div>
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <a href="{{url('home/management/playLesson/'.$lesson->l_id)}}">
                <div class="fold-name">
                    {{$lesson->l_name}}
                </div>
                <div class="fold-info">
                    {!! $lesson->if_public?'<i class="fa fa-globe"></i>':'' !!} created at {{$lesson->created_at}}
                </div>
            </a>
        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('lp', '{{$lesson->l_id}}', '{{$lesson->l_name}}')">rename</a></li>
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#share-setting">share setting</a></li>
                <li class="set-opt delete-color"><a data-toggle="modal" data-target="#deleteFolder" onclick="formDelete('lesson', '{{$lesson->l_id}}')">delete</a></li>
            </ul>
        </div>
    </li>
@endif

<script>
    function  startRename(type, id, name) {
        $('#rename-folder-type').val(type);
        $('#rename-folder-id').val(id);
        $('#oldname').val(name);
        setTimeout(function () {
            $('#oldname').focus();
        }, 200);
    }
</script>