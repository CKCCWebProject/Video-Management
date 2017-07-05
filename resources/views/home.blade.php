@include('include')
<body class="bigScroll">

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

                    <div class="top-margin"></div>

                    @if($position == 1)

                        <div class="row" style="margin-bottom: 10px">
                            @include('homeNavigation')
                        </div>

                        @if($activeNav == 3)
                            @include('homeHelp')
                        @elseif($activeNav == 2)
                            @include('homeFavorite')
                        @else
                            @include('homeContent')
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
<!-- /#page-content-wrapper -->

</div>

<!-- Menu Toggle Script -->
<script>

    $(".blocker").click(function(e) {
        e.preventDefault();
        toggleSidebar();
    });

</script>
</body>
</html>