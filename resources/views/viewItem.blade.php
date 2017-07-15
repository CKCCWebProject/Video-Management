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
                    <span id="globesp{{$playlist->sp_id}}" style="display: {!! $playlist->if_public==1?'inline':'none' !!}"><i class="fa fa-globe"></i></span> created at {{$playlist->created_at}}
                </div>
            </a>

        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('sp', '{{$playlist->sp_id}}', '{{$playlist->sp_name}}')">rename</a></li>
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#share-setting" onclick="startShare('sp', '{{$playlist->sp_id}}')">share setting</a></li>
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
                    <span id="globelp{{$lesson->l_id}}" style="display: {!! $lesson->if_public==1?'inline':'none' !!}"><i class="fa fa-globe"></i></span> created at {{$lesson->created_at}}
                </div>
            </a>
        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('lp', '{{$lesson->l_id}}', '{{$lesson->l_name}}')">rename</a></li>
                <li class="set-opt"><a href="#" data-toggle="modal" data-target="#share-setting" onclick="startShare('lp', '{{$lesson->l_id}}')">share setting</a></li>
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

    function startShare(type, id) {
        $('.share-folder-type').val(type);
        $('.share-folder-id').val(id);
        if (type == 'sp') {
            if ($('#globesp'+id).css('display')=='none') {
                $('#check-share-public').html('');
                $('#if-public').val('0');
            } else {
                $('#check-share-public').html('<i class="fa fa-check"></i>');
                $('#if-public').val('1');
            }
        } else if (type == 'lp') {
            if ($('#globelp'+id).css('display')=='none') {
                $('#check-share-public').html('');
                $('#if-public').val('0');
            } else {
                $('#check-share-public').html('<i class="fa fa-check"></i>');
                $('#if-public').val('1');
            }
        }
    }
</script>