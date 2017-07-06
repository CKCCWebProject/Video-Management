@include('include')
<body class="bigScroll">

<div class="song-playlist-container">
    {{--close--}}
    <div class="song-close">
        &times;
    </div>
    {{--main--}}
    <div class="song-main col-lg-7 col-md-6 col-sm-6 col-xs-12">
        <div class="song-view">
            {{--play favorite--}}
            <div class="song-play-favorite">
                <input type="checkbox" id="play-favorite">
                <label for="play-favorite">Play only favorites</label>
            </div>
            {{--video--}}
            <div class="song-video">
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/jaSDeu1RakI" frameborder="0" allowfullscreen></iframe>
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
    <div class="mediumScroll song-list col-lg-5 col-md-6 col-sm-6 col-xs-12">
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
                </div>
            </li>



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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li><li>
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
                </div>
            </li>



        </ul>
    </div>
</div>

</body>
</html>