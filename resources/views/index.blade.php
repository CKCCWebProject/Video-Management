@include('include')
<body>

@include('nav')

<div id="wrapper">

<!-- Sidebar -->
    @include('sidebar')
<!-- /#sidebar-wrapper -->

<!-- Blocker -->
    <div class="blocker visible-xs animated">
    </div>
<!-- /#Blocker -->

<!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    {{--<a href="#menu-toggle" class="btn toggler" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>--}}
                </div>
            </div>
        </div>
    </div>
<!-- /#page-content-wrapper -->

</div>

<!-- Menu Toggle Script -->
<script>

    $("#menu-toggle, .blocker").click(function(e) {
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
</body>
</html>