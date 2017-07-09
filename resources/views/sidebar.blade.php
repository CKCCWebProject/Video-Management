

    <div class="mediumScroll" id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand" style="text-indent: 0px">
                <div class="user-display">
                    <div class="profile-preview display-profile" style="background-image: url('{{asset('img/giphy.gif')}}')"></div>
                    <div class="display-name" style="font-weight: bold">Sar Channimol</div>
                    <div class="btn-edit">
                        <a href=""><i class="fa fa-edit"> </i> edit</a>
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
                <a href="#">
                    <i class="fa fa-gift icon"> </i>
                    <span> Gift box</span>
                    <span class="count-gift">10</span>
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
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            toggleSidebar();
        });

        $(document).on("swipeleft",function(){
            if ($("#wrapper").hasClass("toggled")) {
                toggleSidebar();
            }
        });

        $(document).on("swiperight",function(){
            if (!$("#wrapper").hasClass("toggled")) {
                toggleSidebar();
            }
        });

        var toggleSidebar = function () {
            $("#wrapper").toggleClass("toggled");
            if (!$(".blocker").hasClass("fadeIn") && !$(".blocker").hasClass("fadeOut")) {
                $(".blocker").toggleClass("fadeIn");
            } else {
                $(".blocker").toggleClass("fadeIn");
                $(".blocker").toggleClass("fadeOut");
            }
        }
    </script>