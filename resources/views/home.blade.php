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

                    @if($position == 'home')

                        <div class="row" style="margin-bottom: 10px">
                            @include('homeNavigation')
                        </div>

                        @if($activeNav == 'help')
                            @include('homeHelp')
                        @elseif($activeNav == 'favorite')
                            @include('homeFavorite')
                        @else
                            @include('homeContent')
                        @endif
                    @elseif($position == 'connection')
                        @include('connectionContent')
                    @elseif($position == 'about')
                        @include('aboutContent')
                    @elseif($position == 'setting')
                        @include('settingContent')
                    @endif
                </div>
            </div>
        </div>
    </div>
<!-- /#page-content-wrapper -->

</div>


@if($position == 'home' && $activeNav == 'management') {

<div id="createFolder" class="modal fade" role="dialog" style="z-index: 1050">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{url('folders')}}" style="margin-bottom: 0px">
                {{csrf_field()}}
                <input name="currentFolder" type="hidden" value="{{$pwd}}">
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

<div id="createPlaylist" class="modal fade" role="dialog" style="z-index: 1050">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{url('playlists')}}" style="margin-bottom: 0px">
                {{csrf_field()}}
                <input name="currentFolder" type="hidden" value="{{$pwd}}">
                <div class="modal-header"  style="background-color: #c44e4e">
                    <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                    <h4 class="modal-title">Enter new song playlist name</h4>
                </div>
                <div class="modal-body">
                    <input name="playlistName"  type="text" class="form-control" placeholder="New song playlist">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" value="Ok">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

<div id="createLesson" class="modal fade" role="dialog" style="z-index: 1050">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{url('lessons')}}" style="margin-bottom: 0px">
                {{csrf_field()}}
                <input name="currentFolder" type="hidden" value="{{$pwd}}">
                <div class="modal-header"  style="background-color: #4453a1">
                    <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                    <h4 class="modal-title">Enter new lesson playlist name</h4>
                </div>
                <div class="modal-body">
                    <input  name="lessonName"  type="text" class="form-control" placeholder="New lesson playlist">
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" value="Ok">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>
</div>

@endif


<!-- Menu Toggle Script -->
<script>

    $(".blocker").click(function(e) {
        e.preventDefault();
        toggleSidebar();
    });

</script>
</body>
</html>