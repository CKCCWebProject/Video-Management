<?php
    $playlistOwner = \App\SongPlaylist::find($currentPlaylist)->u_id;
?>
@include('include')
<body class="bigScroll">

<div class="song-playlist-container">
    {{--close--}}
    <div class="song-close">
        <a href="{{url('home/management/'.$parentId)}}">&times;</a>
    </div>
    {{--main--}}
    <div class="song-main col-lg-8 col-md-7 col-sm-12 col-xs-12">
        <div class="song-view">

            @if(count($videos))
                {{--play favorite--}}
                @if($playlistOwner==session('userId'))
                    <div class="song-play-favorite" onchange="return changePlayFavorite()">
                        <input type="checkbox" id="play-favorite" {{$setting->play_favorite==true?'checked':''}}>
                        <label for="play-favorite">Play only favorites</label>
                    </div>
                @endif
                {{--video--}}
                <div class="song-video">
                    <iframe id="video" width="100%" height="100%" src="https://www.youtube.com/embed/{{$currentVideo->url}}?enablejsapi=1{{--{{$autoplay?'/?rel=0&autoplay=1':''}}--}}" frameborder="0" allowfullscreen></iframe>
                </div>
                {{--play sequence--}}
                <div class="song-play-sequence">
                    <div class="song-sequence-list-container">
                        <ul class="song-sequence-list" {!! $playlistOwner==session('userId')?'onchange="return changeSequence()"':'' !!}>
                            @if($playlistOwner==session('userId'))
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                            @endif
                            {{--repeat all--}}
                            <li>
                                <input type="radio" name="sequence" value="4" id="repeat_all" {{$setting->sq_id==4?'checked':''}}>
                                <label for="repeat_all"> Repeat all</label>
                            </li>
                            {{--repeat one--}}
                            <li>
                                <input type="radio" name="sequence" value="3" id="repeat_one" {{$setting->sq_id==3?'checked':''}}>
                                <label for="repeat_one"> Repeat one</label>
                            </li>
                            {{--random--}}
                            <li>
                                <input type="radio" name="sequence" value="2" id="random" {{$setting->sq_id==2?'checked':''}}>
                                <label for="random"> Random</label>
                            </li>
                            {{--none--}}
                            <li>
                                <input type="radio" name="sequence" value="1" id="none" {{$setting->sq_id==1?'checked':''}}>
                                <label for="none"> None</label>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div style="height: 100%; font-size: 4vw; display: flex; align-items: center;">
                    <div style="width: 100%; text-align: center;">
                        Don't have any videos yet
                    </div>
                </div>
            @endif

        </div>
    </div>
    {{--list--}}
    <div class="wmediumScroll song-list col-lg-4 col-md-5 col-sm-12 col-xs-12">
        <div class="row" style="text-align: center; padding: 10px">
            <button class="btn btn-default" {!! $playlistOwner==session('userId')?'data-toggle="modal" data-target="#add-video" onclick="focusUrl()"':'onclick="alert(\'Cannot add video\')"' !!}>
                Add a new video
            </button>
        </div>
        <ul class="songs">
            @foreach($videos as $key=>$video)
                <li id="index{{$video->s_id}}" class="{{$video->s_id==$currentVideo->s_id?'playing':''}}">
                    <div class="each-song">
                        <div style="color: white">
                            {{$key+1}}&nbsp;
                        </div>
                        @if($playlistOwner==session('userId'))
                            <div class="heart" onclick="return favorite({{$video->s_id}})">
                                <i id="heart{{$video->s_id}}" style="color: {{$video->if_favorite?'red':'white'}}" class="fa fa-heart"></i>
                            </div>
                        @endif
                        <a href="{{url('home/management/playSong/'.$currentPlaylist.'/'.$video->s_id)}}" style="display: flex; align-items: center; width: 90%">
                            <div class="video-thumbnail profile-preview" style="background-image: url('https://img.youtube.com/vi/{{$video->url}}/mqdefault.jpg')"></div>
                            <div class="song-text">
                                <div class="song-title">
                                    {{$video->title}}
                                </div>
                                <div class="song-info">
                                    {{sprintf('%02d:%02d:%02d', floor($video->duration / 3600), floor($video->duration / 60 % 60), floor($video->duration % 60))}}
                                </div>
                            </div>
                        </a>
                        @if($playlistOwner==session('userId'))
                            <div class="folder-setting dropdown">
                                <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                                <ul class="dropdown-menu setting-option" style="top: 0px">
                                    <li class="set-opt"><a href="#" data-toggle="modal" data-target="#rename" onclick="startRename('{{$video->s_id}}', '{{$video->title}}')">rename</a></li>
                                    <li class="set-opt delete-color"><a href="{{url('deletesong/'.$currentPlaylist.'/'.$video->s_id)}}">delete</a></li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
</div>

@if($playlistOwner==session('userId'))
    <div id="add-video" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('/home/management/playSong/'.$currentPlaylist)}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentPlaylist" type="hidden" value="{{$currentPlaylist}}">
                    @if(count($videos) > 0)
                        <input name="currentVideo" type="hidden" value="{{$currentVideo}}">
                    @endif
                    <div class="modal-header"  style="background-color: #bf2f34">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        <h4 class="modal-title">Enter youtube URL</h4>
                    </div>
                    <div class="modal-body">
                        <div style="margin-bottom: 10px">
                            <input id="input-url" name="videoURL" type="text" class="form-control" placeholder="YouTube URL" required oninput="checkPlaylist()" autocomplete="off">
                            <div class="import-playlist-container" style="display: none">
                                <input name="allPlaylist" id="import-playlist" type="checkbox">
                                <label for="import-playlist">import all videos from playlist</label>
                            </div>
                            <input name="playlistId" type="hidden" id="playlist-id">
                        </div>
                        <div>
                            <input name="videoTitle" type="text" class="form-control" placeholder="video title (optional)">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" value="Ok">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="rename" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="rename-form" method="post" action="{{url('renameSong')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentPlaylist" type="hidden" value="{{$currentPlaylist}}">
                    <input id="rename-song-id" name="id" type="hidden">
                    <div class="modal-header" style="background-color: #808085; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Type the new name
                    </div>
                    <div class="modal-body">
                        <input id="oldname" name="newName"  type="text" class="form-control" placeholder="Type the new name" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info" value="Save">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endif

@if($message != '')
    <div class="show" id="snackbar">{{$message}}</div>
@endif


<script src="http://www.youtube.com/player_api"></script>

<script>

    $('form').attr('onsubmit', "$.LoadingOverlay('show')");

    var array = [@foreach($videos as $video){{$video->s_id}},@endforeach];
    @if($playlistOwner==session('userId'))
        var favoriteArray = [@foreach($favoriteVideos as $video){{$video->s_id}},@endforeach];
    @endif

    @if($message != '')
        $(window).on('load', function () {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2500);
    });
    @endif

    $('#play-video').on('click', function(ev) {

        $("#video")[0].src += "&autoplay=1";
        ev.preventDefault();

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function favorite($id) {
        $.ajax({
            url: "{{url('favorite')}}",
            type: 'post',
            data: 'id='+$id+'&_token='+'{{csrf_token()}}',
            dataType: 'text',
            success: function( _response ){
                if (document.getElementById('play-favorite').checked) {
                    location.reload();
                } else {
                    $("#heart"+$id).css('color', _response);
                }
//                alert(_response)
            },
            error: function( _response ){
            }
        });
        return false;
    }

    function changeSequence() {
        $sequence = $("input[name=sequence]:checked").val();
        $.ajax({
            url: "{{url('changeSequence')}}",
            type: 'post',
            data: 'sequence='+$sequence+'&_token='+'{{csrf_token()}}',
            dataType: 'text',
            success: function( _response ){
//                $("#heart"+$id).css('color', _response);
//                alert(_response)
            },
            error: function( _response ){
            }
        });
        return false;
    }

    function changePlayFavorite() {
        $checked = $('#play-favorite').is(":checked");
        $checked = $checked?1:0;
        $.ajax({
            url: "{{url('changePlayFavorite')}}",
            type: 'post',
            data: 'currentPlaylist={{$currentPlaylist}}&checked='+$checked+'&_token='+'{{csrf_token()}}',
            dataType: 'json',
            success: function( _response ){
//                favoriteArray = _response;
            },
            error: function( _response ){
            }
        });
        if(document.getElementById('play-favorite').checked) {
            location.reload();
        }
        return false;
    }

    function focusUrl() {
        setTimeout(function () {
            $("#input-url").focus();
        }, 500);
    }

    function checkPlaylist() {
        var a = $("#input-url").val().split("?list=")[1];
        if (a == undefined) a = $("#input-url").val().split("&list=")[1];
        if (a != undefined) {
//            $("#import-playlist").prop('checked', true);
            var pos = a.indexOf('#');
            if (pos != -1) {
                a = a.substr(0, pos);
            }
            pos = a.indexOf('?');
            if (pos != -1) {
                a = a.substr(0, pos);
            }
            pos = a.indexOf('&');
            if (pos != -1) {
                a = a.substr(0, pos);
            }
            $(".import-playlist-container").css('display', 'block');
            $("#playlist-id").val(a);
        } else {
//        alert("changed")
            $("#import-playlist").prop('checked', false);
            $(".import-playlist-container").css('display', 'none');
        }
    }

    function startRename(sid, oldname) {
        $('#rename-song-id').val(sid);
        $('#oldname').val(oldname);
    }

    // create youtube player

    @if(count($videos) > 0)
        var height = getPosition(document.getElementById('index{{$currentVideo->s_id}}'));

        if ($(window).width() <= 480 ) {
            $( ".song-list" ).scrollTop( height['y'] - 400);
        } else if ($(window).width() <= 767 ) {
            $( ".song-list" ).scrollTop( height['y'] - 430);
        } else if ($(window).width() <= 979 ) {
            $( ".song-list" ).scrollTop( height['y'] - 480);
        } else {
            $( ".song-list" ).scrollTop( height['y'] );
        }

        var player;
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('video' /*ifameId*/, {
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerStateChange
                }
            });
        }

        // autoplay video
        function onPlayerReady(event) {
            event.target.playVideo();
//            alert("hello")
        }

        // state change
        function onPlayerStateChange(event) {
            var arrays = [];
            @if($playlistOwner==session('userId'))
                if (document.getElementById('play-favorite').checked == false) {
                    arrays = array;
                } else {
                    arrays = favoriteArray;
                }
            @else
                arrays = array;
            @endif
            if (arrays.length > 0) {
                var now = {{$currentVideo->s_id}};
                var pos = arrays.indexOf(now);
                switch(event.data) {
                    case 0: //video ended
                        if (document.getElementById('none').checked) {
                            if (pos < arrays.length - 1) {
                                window.location = "{{url('home/management/playSong/'.$currentPlaylist)}}"+"/"+arrays[pos+1];
                            }
                        } else if (document.getElementById('random').checked) {
                            var next = Math.floor(Math.random()*arrays.length);
                            if (next == arrays.length) {
                                next = 0;
                            }
                            window.location = "{{url('home/management/playSong/'.$currentPlaylist)}}"+"/"+arrays[next];
                        } else if (document.getElementById('repeat_one').checked) {
                            event.target.playVideo();
                        } else if (document.getElementById('repeat_all').checked) {
                            if (pos < arrays.length - 1) {
                                window.location = "{{url('home/management/playSong/'.$currentPlaylist)}}"+"/"+arrays[pos+1];
                            } else if (pos == arrays.length - 1) {
                                window.location = "{{url('home/management/playSong/'.$currentPlaylist)}}"+"/"+arrays[0];
                            }
                        }
                        break;
                    case 1: //video playing from player.getCurrentTime()

                        break;
                    case 2: //video paused at player.getCurrentTime()
                }
            }
        }
    @endif

    function getPosition(el) {
        var xPos = 0;
        var yPos = 0;

        while (el) {
            if (el.tagName == "BODY") {
                // deal with browser quirks with body/window/document and page scroll
                var xScroll = el.scrollLeft || document.documentElement.scrollLeft;
                var yScroll = el.scrollTop || document.documentElement.scrollTop;

                xPos += (el.offsetLeft - xScroll + el.clientLeft);
                yPos += (el.offsetTop - yScroll + el.clientTop);
            } else {
                // for all other non-BODY elements
                xPos += (el.offsetLeft - el.scrollLeft + el.clientLeft);
                yPos += (el.offsetTop - el.scrollTop + el.clientTop);
            }

            el = el.offsetParent;
        }
        return {
            x: xPos,
            y: yPos
        };
    }
</script>

</body>
</html>