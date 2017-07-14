<?php
    $gifts = [];
    $user = \App\User::find(session('userId'));
?>

    <div class="mediumScroll" id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand" style="text-indent: 0px">
                <div class="user-display">
                    <div class="profile-preview display-profile" id="show-profile" style="background-image: url('{{asset($user->profile)}}')"></div>
                    <div class="display-name" style="font-weight: bold">{{$user->username}}</div>
                    <div class="btn-edit">
                        <form id="profile-form" enctype="multipart/form-data" method="post" action="/uploadProfile">
                            {{csrf_field()}}
                            <div class="edit-profile">
                                <label for="upload-profile">
                                    <i class="fa fa-edit"> </i> edit
                                </label>
                            </div>
                            <input name="currentPosition" type="hidden" value="{{$position}}">
                            <input style="display: none" id="upload-profile" type="file" name="imageProfile">
                            <div>
                                {{--<input class="btn btn-default" type="submit" value="upload">--}}
                            </div>
                        </form>
                    </div>
                </div>
            </li>
            <li>
                <a {{$position=='home'?'class=active':''}} href="{{url('home/management')}}">
                    <i class="fa fa-home icon"> </i>
                    <span> Home</span>
                </a>
            </li>
            <li>
                <a {{$position=='gift'?'class=active':''}} href="{{url('gift')}}">
                    <i class="fa fa-gift icon"> </i>
                    <span> Gift box</span>
                    <span class="count-gift">{{count($gifts)}}</span>
                </a>
            </li>
            <li>
                <a {{$position=='connection'?'class=active':''}} href="{{url('/connection')}}">
                    <i class="fa fa-chain icon"> </i>
                    <span> Your connections</span>
                </a>
            </li>
            <li class="side-space">

            </li>
            <li>
                <a {{$position=='about'?'class=active':''}} href="{{url('/about')}}">
                    <i class="fa fa-info icon"> </i>
                    <span> About</span>
                </a>
            </li>
            <li>
                <a {{$position=='setting'?'class=active':''}} href="{{url('/setting')}}">
                    <i class="fa fa-cog icon"> </i>
                    <span> Settings</span>
                </a>
            </li>
        </ul>
    </div>

    <script>
//        var smallScreenSize = window.matchMedia( "(max-width: 768px)" );

        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            toggleSidebar();
        });

        $(document).on("swipeleft",function(){
//            if screen is small
            if($(window).width()<769) {
                if ($("#wrapper").hasClass("toggled")) {
                    toggleSidebar();
                }
            }
        });

//        $(document).on("swiperight",function(){
//            if (!$("#wrapper").hasClass("toggled")) {
//                toggleSidebar();
//            }
//        });

        var toggleSidebar = function () {
            $("#wrapper").toggleClass("toggled");
            if (!$(".blocker").hasClass("fadeIn") && !$(".blocker").hasClass("fadeOut")) {
                $(".blocker").toggleClass("fadeIn");
            } else {
                $(".blocker").toggleClass("fadeIn");
                $(".blocker").toggleClass("fadeOut");
            }
        }

        $("#upload-profile").change(function () {
            $('#profile-form').submit();
        });
    </script>