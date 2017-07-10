@include('include')
<body class="bigScroll">

<div class="song-playlist-container">
    {{--close--}}
    <div class="song-close">
        <a href="{{url('home/management/'.$parentId)}}">&times;</a>
    </div>
    {{--main--}}
    <div class="song-main col-lg-8 col-md-7 col-sm-6 col-xs-12">
        <div class="song-view">

            @if(count($videos))
                {{--play favorite--}}
                <div class="song-play-favorite" onchange="return changePlayFavorite()">
                    <input type="checkbox" id="play-favorite" {{$setting->play_favorite==true?'checked':''}}>
                    <label for="play-favorite">Play only favorites</label>
                </div>
                {{--video--}}
                <div class="song-video">
                    <iframe id="video" width="100%" height="100%" src="https://www.youtube.com/embed/{{$currentVideo->url}}{{$autoplay?'/?rel=0&autoplay=1':''}}" frameborder="0" allowfullscreen></iframe>
                </div>
                {{--play sequence--}}
                <div class="song-play-sequence">
                    <div class="song-sequence-list-container">
                        <ul class="song-sequence-list" onchange="return changeSequence()">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <div class="mediumScroll song-list col-lg-4 col-md-5 col-sm-6 col-xs-12">
        <div class="row" style="text-align: center; padding: 10px">
            <button class="btn btn-default" data-toggle="modal" data-target="#add-video" onclick="focusUrl()">
                Add a new video
            </button>
        </div>
        <ul class="songs">
            @foreach($videos as $key=>$video)
                <li id="index{{$key}}" class="{{$video->s_id==$currentVideo->s_id?'playing':''}}">
                    <div class="each-song">
                        <div class="heart" onclick="return favorite({{$video->s_id}})">
                            <i id="heart{{$video->s_id}}" style="color: {{$video->if_favorite?'red':'white'}}" class="fa fa-heart"></i>
                        </div>
                        <a href="{{url('home/management/playSong/'.$currentPlaylist.'/'.$video->s_id)}}" style="display: flex; align-items: center; width: 90%">
                            <div class="video-thumbnail profile-preview" style="background-image: url('https://img.youtube.com/vi/{{$video->url}}/mqdefault.jpg')"></div>
                            <div class="song-text">
                                <div class="song-title">
                                    {{$video->title}}
                                </div>
                                <div class="song-info">
                                    {{sprintf('%02d:%02d:%02d', floor($duration / 3600), floor($duration / 60 % 60), floor($duration % 60))}}
                                </div>
                            </div>
                        </a>
                        <div class="folder-setting dropdown">
                            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                            <ul class="dropdown-menu setting-option" style="top: 0px">
                                <li class="set-opt"><a href="#">rename</a></li>
                                <li class="set-opt delete-color"><a href="{{url('deletesong/'.$currentPlaylist.'/'.$video->s_id)}}">delete</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            @endforeach

        </ul>
    </div>
</div>

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
                        <input id="input-url" name="videoURL" type="text" class="form-control" placeholder="YouTube URL">
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

@if($message != '')
    <div class="show" id="snackbar">{{$message}}</div>
@endif


<script src="http://www.youtube.com/player_api"></script>

<script>

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
                $("#heart"+$id).css('color', _response);
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
        $.ajax({
            url: "{{url('changePlayFavorite')}}",
            type: 'post',
            data: 'checked='+$checked+'&_token='+'{{csrf_token()}}',
            dataType: 'text',
            success: function( _response ){
//                alert(_response)
            },
            error: function( _response ){
            }
        });
        return false;
    }

    function focusUrl() {
        setTimeout(function () {
            $("#input-url").focus();
        }, 500);
    }

    // create youtube player
    var player;

    @if(count($videos) > 0)
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
                height: '390',
                width: '640',
                videoId: '{{$currentVideo->url}}',
                events: {
                    onReady: onPlayerReady,
                    onStateChange: onPlayerStateChange
                }
            });
        }

        // autoplay video
        function onPlayerReady(event) {
//            event.target.playVideo();
            alert("hello")
        }

        // when video ends
        function onPlayerStateChange(event) {
            if(event.data === 0) {
                alert('done');
            }
        }
    @endif
</script>

</body>
</html>