@include('include')
<body class="bigScroll lesson-body">
    <div class="lesson-container">
        {{--close--}}
        <div class="lesson-close">
            <a href="{{url('home/management/'.$parentId)}}">&times;</a>
        </div>
        {{--main--}}
        @if(count($videos) > 0)
            <div class="lesson-main">
                {{--top--}}
                <div  class="lesson-top">
                    {{--video--}}
                    <div class="lesson-video-container">
                        <iframe id="video" class="lesson-video" src="https://www.youtube.com/embed/{{$currentVideo->url}}?enablejsapi=1" frameborder="0" allowfullscreen></iframe>
                    </div>
                    {{--note--}}
                    <div id="note" class="notepaper lesson-note mediumScroll overlay" contenteditable="true" onkeyup="return editNote({{$currentVideo->l_id}})">
                        {{$currentVideo->note}}
                    </div>
                </div>
            </div>
            <div class="row" style="text-align: center; padding-bottom: 10px">
                <button class="btn btn-primary" data-toggle="collapse" data-target="#lesson-info">View playlist information</button>
            </div>
            {{--right side--}}
            <div id="lesson-info" class="lesson-info collapse">
                <div class="lesson-progress">
                    <div class="clearfix" style="margin: 5vw">

                        <div class="hidden-xs hidden-sm c100 p{{$percent}} big green">
                            <span>{{$percent}}%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>

                        <div class="visible-sm c100 p{{$percent}} green">
                            <span>{{$percent}}%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>

                        <div class="visible-xs c100 p{{$percent}} small green">
                            <span>{{$percent}}%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>

                        <div class="wmediumScroll" id="lesson-record" style="color: white; width: 70%; float: right; border: 1px solid red">
                            <?php
                                echo $record;
                            ?>
                        </div>

                    </div>
                </div>
                <div class="lesson-record">

                </div>
            </div>
        @else
            <div style="padding-top: 50px">
                <div class="lesson-video" style="margin: auto; text-align: center; font-size: 4vw; font-weight: bolder; color: white">
                    <div>
                        Click the button below to add a new video
                    </div>
                    <div style="font-size: 10vw; margin-top: 100px">
                        <i class="fa fa-arrow-down"></i>
                    </div>
                </div>
            </div>
        @endif

        {{--list--}}
        <div class="lesson-list">
            <div class="row" style="text-align: center">
                <button class="btn btn-default" data-toggle="modal" data-target="#add-lesson" onclick="focusUrl()">
                    Add a new video
                </button>
            </div>
            <ul class="lessons">
                @foreach($videos as $key=>$video)
                    <li id="lesson{{$key}}" class="each-lesson {{$video->l_id==$currentVideo->l_id?'playing':''}}">
                            <div class="lesson-i">
                                <a href="{{url('home/management/playLesson/'.$currentPlaylist.'/'.$video->l_id)}}" style="display: flex; align-items: center">

                                    <div class="lesson-watched">
                                        @if($video->end_time - $video->start_time < 5)
                                            <i class="fa fa-check"></i>
                                        @endif
                                    </div>
                                    <div class="lesson-thumbnail profile-preview" style="background-image: url('https://img.youtube.com/vi/{{$video->url}}/mqdefault.jpg')">

                                    </div>
                                    <div class="lesson-text">
                                        <div class="lesson-title">
                                            {{$video->title}}
                                        </div>
                                        <div class="lesson-note-short">
                                            {{substr($video->note, 20)}}
                                        </div>
                                        <div class="lesson-duration">
                                            {{sprintf('%02d:%02d:%02d', floor($video->end_time / 3600), floor($video->end_time / 60 % 60), floor($video->end_time % 60))}}
                                        </div>
                                    </div>
                                </a>
                                <div class="folder-setting dropdown">
                                    <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                                    <ul class="dropdown-menu setting-option" style="top: 0px">
                                        <li class="set-opt"><a href="#">rename</a></li>
                                        <li class="set-opt delete-color"><a href="{{url('deletelesson/'.$currentPlaylist.'/'.$video->l_id)}}">delete</a></li>
                                    </ul>
                                </div>
                            </div>

                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div id="add-lesson" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('/home/management/playLesson/'.$currentPlaylist)}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentPlaylist" type="hidden" value="{{$currentPlaylist}}">
                    @if(count($videos) > 0)
                        <input name="currentVideo" type="hidden" value="{{$currentVideo}}">
                    @endif
                    <div class="modal-header"  style="background-color: #5d6fc2">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        <h4 class="modal-title">Enter youtube URL</h4>
                    </div>
                    <div class="modal-body">
                        <div style="margin-bottom: 10px">
                            <input id="input-url" name="videoURL" type="text" class="form-control" placeholder="YouTube URL" required>
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

</body>

<script src="http://www.youtube.com/player_api"></script>

<script>

    @if($message != '')
        $(window).on('load', function () {
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2500);
        });
    @endif

//    $.ajaxSetup({
//        headers: {
//            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//        }
//    });

    function openNav() {
//        document.getElementById("myNav").style.width = "100%";
        $(".overlay").css('width', '100%');
    }

    function closeNav() {
//        document.getElementById("myNav").style.width = "0%";
        $(".overlay").css('width', '0%');
    }

    function editNote($id) {
        var data = 'id='+$id+"&note="+$('#note').html()+"&_token="+'{{csrf_token()}}';
        $.ajax({
            url: "{{url('editNote')}}",
            type: 'post',
            data: data,
            dataType: 'json',
            success: function( _response ){
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
    @if(count($videos) > 0)
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
    //        event.target.playVideo();
    //            alert("hello")
        }

        // state change
        function onPlayerStateChange(event) {
            var arrays = [@foreach($videos as $video){{$video->l_id}},@endforeach];
            var now = {{$currentVideo->l_id}};
            var pos = arrays.indexOf(now);
            switch(event.data) {
                case 0: //video ended
                    updateTime('{{$currentVideo->end_time}}');
                    if (pos < arrays.length - 1) {
                        window.location = "{{url('home/management/playLesson/'.$currentPlaylist)}}"+"/"+arrays[pos+1];
                    }
                case 1: //video playing from player.getCurrentTime()
                    updateTime(player.getCurrentTime());
                    break;
                case 2: //video paused at player.getCurrentTime()
                    updateTime(player.getCurrentTime());
            }
        }

        function updateTime(time) {
            $.ajax({
                url: "{{url('updateTime')}}",
                type: 'post',
                data: 'lessonId='+'{{$currentVideo->l_id}}'+'&time='+Math.ceil(time)+'&record='+'{{date("F j, Y, g:i a")}}'+' - '+'<strong>{{strlen($currentVideo->title)>40?substr($currentVideo->title,0, 40).'...':$currentVideo->title}}</strong>'+' <i>'+(''+time).toHHMMSS()+'</i><br/>'+'&_token='+'{{csrf_token()}}',
                dataType: 'text',
                success: function( _response ){
                },
                error: function( _response ){
                }
            });
        }
    @endif


    String.prototype.toHHMMSS = function () {
        var sec_num = parseInt(this, 10); // don't forget the second param
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        return hours+':'+minutes+':'+seconds;
    }


</script>

</html>