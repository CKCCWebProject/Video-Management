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
            {{--play favorite--}}
            <div class="song-play-favorite">
                <input type="checkbox" id="play-favorite">
                <label for="play-favorite">Play only favorites</label>
            </div>
            {{--video--}}
            <div class="song-video">
                <iframe id="video" width="100%" height="100%" src="https://www.youtube.com/embed/jaSDeu1RakI?rel=0" frameborder="0" allowfullscreen></iframe>
            </div>
            {{--play sequence--}}
            <div class="song-play-sequence">
                <div class="song-sequence-list-container">
                    <ul class="song-sequence-list">
                        {{--repeat all--}}
                        <li>
                            <input type="radio" name="sequence" value="repeat_all" id="repeat_all" checked>
                            <label for="repeat_all"> Repeat all</label>
                        </li>
                        {{--repeat one--}}
                        <li>
                            <input type="radio" name="sequence" value="repeat_one" id="repeat_one" checked>
                            <label for="repeat_one"> Repeat one</label>
                        </li>
                        {{--random--}}
                        <li>
                            <input type="radio" name="sequence" value="random" id="random" checked>
                            <label for="random"> Random</label>
                        </li>
                        {{--none--}}
                        <li>
                            <input type="radio" name="sequence" value="none" id="none" checked>
                            <label for="none"> None</label>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{--list--}}
    <div class="mediumScroll song-list col-lg-4 col-md-5 col-sm-6 col-xs-12">
        <div class="row" style="text-align: center; padding: 10px">
            <button class="btn btn-default" data-toggle="modal" data-target="#add-video">
                Add a new video
            </button>
        </div>
        <ul class="songs">
            <li>
                <div class="each-song">
                    <div class="heart">
                        <i class="fa fa-heart"></i>
                    </div>
                    <div class="video-thumbnail profile-preview" style="background-image: url('https://www.smashingmagazine.com/wp-content/uploads/2015/06/10-dithering-opt.jpg')"></div>
                    <div class="song-text">
                        <div class="song-title">
                            My song
                        </div>
                        <div class="song-info">
                            2:30
                        </div>
                    </div>
                    <div class="folder-setting dropdown">
                        <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
                        <ul class="dropdown-menu setting-option" style="top: 0px">
                            <li class="set-opt"><a href="#">rename</a></li>
                            <li class="set-opt delete-color"><a href="#">delete</a></li>
                        </ul>
                    </div>
                </div>
            </li>

        </ul>
    </div>
</div>

<div id="add-video" class="modal fade" role="dialog" style="z-index: 1050">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{url('folders')}}" style="margin-bottom: 0px">
                {{csrf_field()}}
                <input name="currentFolder" type="hidden" value="{{--{{$pwd}}--}}">
                <div class="modal-header"  style="background-color: #c3ac38">
                    <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                    <h4 class="modal-title">Enter new folder name</h4>
                </div>
                <div class="modal-body">
                    <input name="folderName" type="text" class="form-control" placeholder="New folder">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" value="Ok">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<script>
    $('#play-video').on('click', function(ev) {

        $("#video")[0].src += "&autoplay=1";
        ev.preventDefault();

    });
</script>

</body>
</html>