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
                    @elseif($position == 'gift')
                        @include('giftContent')

                    @endif
                </div>
            </div>
        </div>
    </div>
<!-- /#page-content-wrapper -->

</div>


@if($position == 'home' && $activeNav == 'management')

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
                        <input id="add-folder" name="folderName" type="text" class="form-control" placeholder="New folder">
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
                        <input id="add-sp" name="playlistName"  type="text" class="form-control" placeholder="New song playlist">
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
                        <input id="add-lp" name="lessonName"  type="text" class="form-control" placeholder="New lesson playlist">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" value="Ok">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="deleteFolder" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="delete-form" method="post" action="{{url('deleteFolder')}}" style="margin-bottom: 0px" onsubmit="return checkDelete()">
                    {{csrf_field()}}
                    <input name="currentFolder" type="hidden" value="{{$pwd}}">
                    <input id="folder-type" name="type" type="hidden">
                    <input id="folder-id" name="id" type="hidden">
                    <div class="modal-header"  style="background-color: #ee0000">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        <h4 class="modal-title">Type `confirm` to delete</h4>
                    </div>
                    <div class="modal-body">
                        <input id="confirm-delete" name="lessonName"  type="text" class="form-control" placeholder="type to confirm" onkeyup="confirmDelete()" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <input id="btn-delete" type="submit" class="btn btn-danger" value="Delete" style="display: none">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="rename" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="rename-form" method="post" action="{{url('renameFolder')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentFolder" type="hidden" value="{{$pwd}}">
                    <input id="rename-folder-type" name="type" type="hidden">
                    <input id="rename-folder-id" name="id" type="hidden">
                    <div class="modal-header" style="background-color: #808085; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Type the new name
                    </div>
                    <div class="modal-body">
                        <input id="oldname" name="newName"  type="text" class="form-control" placeholder="Type the new name" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-info" value="Save">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="share-setting" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog" style="width: 350px;">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="rename-form" method="post" action="{{url('sendGift')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentFolder" type="hidden" value="{{$pwd}}">
                    <input id="rename-folder-type" name="type" type="hidden">
                    <input id="rename-folder-id" name="id" type="hidden">
                    <div class="modal-header" style="background-color: #808085; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Share
                    </div>
                    <div class="modal-body">
                        <div class="row" style="margin-bottom: 20px">
                            <button class="btn btn-default" style="width: 100%">
                                to public
                                <span style="color: #67ed76; float: right"><i class="fa fa-check"></i></span>
                            </button>
                        </div>
                        <div class="row">
                            <button class="btn btn-default" style="width: 100%">
                                as gift
                                <span style="color: white; float: right"><i class="fa fa-chevron-right"></i></span>
                            </button>
                        </div>
                    </div>
                    {{--<div class="modal-footer">--}}
                        {{--<input type="submit" class="btn btn-info" value="Save">--}}
                        {{--<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>--}}
                    {{--</div>--}}
                </form>
            </div>

        </div>
    </div>
@endif

@if($position == 'setting')
    <div id="deleteAccount" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('deleteAccount')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <div class="modal-header" style="background-color: #000000; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Delete account
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="text-align: center">
                                <i class="fa fa-frown-o" style="font-size: 200px">

                                </i>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12" style="text-align: center; font-size: 25px; font-weight: bolder">
                                It looks like you are not happy with what you have created.
                                We can't stop you. If it is your final decision, type your password below to confirm
                            </div>
                        </div>
                        <input name="password"  type="password" class="form-control" placeholder="Password here">
                        <div class="confirm-destroy" style="display: none">
                            <span style="color: red; padding-left: 5px;">We give you one more chance. You can be back now.</span>
                            <input name="confirmPassword" type="password" class="form-control" placeholder="Password :(">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input id="destroy" type="button" class="btn btn-danger" value="Destroy" onclick="moreTry()">
                        <button type="button" class="btn btn-success" data-dismiss="modal">move back to safe</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endif


@if($message != '')
    <div class="show" id="snackbar">{{$message}}</div>
@endif

<!-- Menu Toggle Script -->
<script>

    @if($message != '')
        $(window).on('load', function () {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2500);
    });
    @endif

    $(".blocker").click(function(e) {
        e.preventDefault();
        toggleSidebar();
    });

    function formDelete(type, id) {
        $("#folder-type").val(type);
        $("#folder-id").val(id);
        focusUrl();
    }

    function checkDelete() {
        if($('#confirm-delete').val() == 'confirm') {
            return true;
        } else {
            return false;
        }
    }

    function confirmDelete() {
        if($('#confirm-delete').val() == 'confirm') {
            $("#btn-delete").css('display', 'inline');
        } else {
            $("#btn-delete").css('display', 'none');
        }
    }

    function focusUrl() {
        setTimeout(function () {
            $("#confirm-delete").focus();
        }, 500);
    }

    function focusAdd(type) {
        setTimeout(function () {
            if (type == 'folder') {
                $("#add-folder").focus();
            } else if (type == 'song') {
                $("#add-sp").focus();
            } else if (type == 'lesson') {
                $("#add-lp").focus();
            }
        }, 500);
    }

    function moreTry() {
        if($('.confirm-destroy').css('display') == 'none') {
            $('.confirm-destroy').css('display', 'block');
        } else if($('.confirm-destroy').css('display') == 'block') {
            $('#destroy').attr('type', 'submit');
        }
    }

</script>
</body>
</html>