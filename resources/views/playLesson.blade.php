@include('include')
<body class="bigScroll">

    <div class="lesson-container">
        {{--close--}}
        <div class="song-close">
            <a href="{{url('home/management/'.$parentId)}}">&times;</a>
        </div>
        {{--main--}}
        <div class="lesson-main">
            {{--top--}}
            <div  class="lesson-top">
                {{--video--}}
                <div class="lesson-video">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/yDD8MN8nDT4" frameborder="0" allowfullscreen></iframe>
                </div>
                {{--note--}}
                <div class="lesson-note">

                </div>
            </div>
            {{--list--}}
            <div class="lesson-list">
                <ul class="lessons">
                    <li>

                    </li>
                </ul>
            </div>
        </div>
        {{--right side--}}
        <div class="lesson-info">
            {{--progress--}}
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
            {{--record--}}
            <div class="lesson-record">

            </div>
        </div>
    </div>

</body>
</html>