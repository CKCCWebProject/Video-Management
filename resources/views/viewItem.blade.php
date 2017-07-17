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
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#move" onclick="move('fd', '{{$folder->f_id}}')">move</a></li>
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
                    @if(isset($search))
                        <input type="hidden" id="publicsp{{$playlist->sp_id}}" value="{{$playlist->if_public}}">
                        <i class="fa fa-{!! $mode !!}"></i> <span>owned by : {{\App\User::find($playlist->u_id)->username}}</span>
                    @else
                        <span id="globesp{{$playlist->sp_id}}" style="display: {!! $playlist->if_public==1?'inline':'none' !!}"><i class="fa fa-globe"></i></span> created at {{$playlist->created_at}}
                    @endif
                </div>
            </a>

        </div>
        @if($playlist->u_id == session('userId'))
            <div class="folder-setting dropdown">
                <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                <ul class="dropdown-menu setting-option">
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('sp', '{{$playlist->sp_id}}', '{{$playlist->sp_name}}')">rename</a></li>
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#move" onclick="move('sp', '{{$playlist->sp_id}}')">move</a></li>
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#share-setting" onclick="startShare('sp', '{{$playlist->sp_id}}')">share setting</a></li>
                    <li class="set-opt delete-color"><a data-toggle="modal" data-target="#deleteFolder" onclick="formDelete('song', '{{$playlist->sp_id}}')">delete</a></li>
                </ul>
            </div>
        @else
            @if($mode == 'gift')
                <div class="respond-gift" style="margin-right: 0px; margin-left: auto; text-align: right;">
                    <span>
                        <form method="post" action="{{url('receiveGift')}}" style="margin-bottom: 0px; display: inline">
                            {{csrf_field()}}
                            <input type="hidden" name="gId" value="{{$gift->g_id}}">
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-smile-o"> </i> receive
                            </button>
                        </form>
                    </span>
                    <span>
                        <form id="reject-gift{{$gift->g_id}}" method="post" action="{{url('rejectGift')}}" style="margin-bottom: 0px; display: inline">
                            {{csrf_field()}}
                            <input type="hidden" name="gId" value="{{$gift->g_id}}">
                            <button type="button" class="btn btn-danger reject-gift" onclick="onRejectGift('{{$gift->g_id}}')">
                                <i class="fa fa-frown-o"> </i> reject
                            </button>
                        </form>
                    </span>
                </div>
            @elseif($mode == 'globe')
                <div class="folder-setting">
                    <form method="post" action="{{url('getSPFromPublic')}}" style="margin-bottom: 0px; display: inline">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$playlist->sp_id}}">
                        <button type="submit" class="btn btn-info">
                            get it
                        </button>
                    </form>
                </div>
            @endif
        @endif
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
                    @if(isset($search))
                        <input type="hidden" id="publiclp{{$lesson->l_id}}" value="{{$lesson->if_public}}">
                        <i class="fa fa-{!! $mode !!}"></i> <span>owned by : {{\App\User::find($lesson->u_id)->username}}</span>
                    @else
                        <span id="globelp{{$lesson->l_id}}" style="display: {!! $lesson->if_public==1?'inline':'none' !!}"><i class="fa fa-globe"></i></span> created at {{$lesson->created_at}}
                    @endif
                </div>
            </a>
        </div>
        @if($lesson->u_id == session('userId'))
            <div class="folder-setting dropdown">
                <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                <ul class="dropdown-menu setting-option">
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('lp', '{{$lesson->l_id}}', '{{$lesson->l_name}}')">rename</a></li>
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#move" onclick="move('lp', '{{$lesson->l_id}}')">move</a></li>
                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#share-setting" onclick="startShare('lp', '{{$lesson->l_id}}')">share setting</a></li>
                    <li class="set-opt delete-color"><a data-toggle="modal" data-target="#deleteFolder" onclick="formDelete('lesson', '{{$lesson->l_id}}')">delete</a></li>
                </ul>
            </div>
        @else
            @if(count(\App\GiftBox::where('receiver_id', session('userId'))->where('item_type', 2)->where('item_id', $lesson->l_id)->get()) > 0)
                <div class="respond-gift" style="margin-right: 0px; margin-left: auto; text-align: right;">
                    <span>
                        <form method="post" action="{{url('receiveGift')}}" style="margin-bottom: 0px; display: inline">
                            {{csrf_field()}}
                            <input type="hidden" name="gId" value="{{$gift->g_id}}">
                            <button type="submit" class="btn btn-info">
                            <i class="fa fa-smile-o"> </i> receive
                        </button>
                        </form>
                    </span>
                    <span>
                        <form id="reject-gift{{$gift->g_id}}" method="post" action="{{url('rejectGift')}}" style="margin-bottom: 0px; display: inline">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$gift->g_id}}">
                            <button type="button" class="btn btn-danger reject-gift" onclick="onRejectGift('{{$gift->g_id}}')">
                            <i class="fa fa-frown-o"> </i> reject
                        </button>
                        </form>
                    </span>
                </div>
            @elseif($mode == 'globe')
                <div class="folder-setting">
                    <form method="post" action="{{url('getLPFromPublic')}}" style="margin-bottom: 0px; display: inline">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{$lesson->l_id}}">
                        <button type="submit" class="btn btn-info">
                            get it
                        </button>
                    </form>
                </div>
            @endif
        @endif
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
            @if(isset($search))
                if ($('#publicsp'+id).val()== '0') {
            @else
                if ($('#globesp'+id).css('display')=='none') {
            @endif
                $('#check-share-public').html('');
                $('#if-public').val('0');
            } else {
                $('#check-share-public').html('<i class="fa fa-check"></i>');
                $('#if-public').val('1');
            }
        } else if (type == 'lp') {
                @if(isset($search))
                    if ($('#publiclp'+id).val()== '0') {
                @else
                    if ($('#globelp'+id).css('display')=='none') {
                @endif
                $('#check-share-public').html('');
                $('#if-public').val('0');
            } else {
                $('#check-share-public').html('<i class="fa fa-check"></i>');
                $('#if-public').val('1');
            }
        }
    }

    function move(type, id) {
        $('#move-type').val(type);
        $('#move-id').val(id);
        $('#move-id').val(id);
        setTimeout(function () {
            $('#destination-folder').focus();
        }, 200);
    }
</script>