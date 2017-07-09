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
                        <iframe class="lesson-video" src="https://www.youtube.com/embed/{{$currentVideo->url}}{{$autoplay?'/?rel=0&autoplay=1':''}}" frameborder="0" allowfullscreen></iframe>
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
                    <div class="clearfix">

                        <div class="c100 p50 big green">
                            <span>50%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>

                        <div class="c100 p25 green">
                            <span>25%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
                        </div>

                        <div class="c100 p12 small green">
                            <span>12%</span>
                            <div class="slice">
                                <div class="bar"></div>
                                <div class="fill"></div>
                            </div>
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
                <button class="btn btn-default" data-toggle="modal" data-target="#add-lesson">
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
                                        <li class="set-opt delete-color"><a href="#">delete</a></li>
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
                <form method="post" action="{{url('addLesson')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentPlaylist" type="hidden" value="{{$currentPlaylist}}">
                    <input name="currentVideo" type="hidden" value="{{$currentVideo}}">
                    <div class="modal-header"  style="background-color: #5d6fc2">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        <h4 class="modal-title">Enter youtube URL</h4>
                    </div>
                    <div class="modal-body">
                        <div style="margin-bottom: 10px">
                            <input name="videoURL" type="text" class="form-control" placeholder="YouTube URL">
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

<script>

    $(window).on('load', function () {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
            url: "{{url('/home/management/playLesson/editNote')}}",
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
</script>

</html>