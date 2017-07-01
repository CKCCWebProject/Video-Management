

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand" style="text-indent: 0px">
                <div class="user-display">
                    <div class="profile-preview display-profile" style="background-image: url('http://www.incrediblesnaps.com/wp-content/uploads/2012/05/35-most-beautiful-butterfly-pictures-26.jpg')"></div>
                    <div class="display-name">Sar Channimol</div>
                    <div class="btn-edit">
                        <a href=""><i class="fa fa-edit"> </i> edit</a>
                    </div>
                </div>
            </li>
            <li>
                <a href="#">
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
                <a href="#">
                    <i class="fa fa-chain icon"> </i>
                    <span> Your connections</span>
                </a>
            </li>
            <li class="side-space">

            </li>
            <li>
                <a href="#">
                    <i class="fa fa-info icon"> </i>
                    <span> About</span>
                </a>
            </li>
            <li>
                <a href="#">
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