@include('include')
<body class="bigScroll">

@include('nav')

<div id="wrapper" class="toggled">

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

                        @if($activeNav == 'favorite')
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
                    @elseif($position == 'help')
                        @include('helpContent')
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

    <div id="move" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('move')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <input name="currentFolder" type="hidden" value="{{$pwd}}">
                    <input id="move-type" name="type" type="hidden">
                    <input id="move-id" name="id" type="hidden">
                    <input id="last-dir" type="hidden" value="">
                    <div class="modal-header"  style="background-color: #676880">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        <h4 class="modal-title">Move</h4>
                    </div>
                    <div class="modal-body">
                        <div>type the directory path to move</div>
                        <div class="form-control" style="background-color: transparent"><strong><i>For example : </i></strong>
                            <code>/My lesson/Physics</code>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">move to </span>
                            <input id="destination-folder" name="path" type="text" class="form-control" placeholder="destination path" value="" onkeydown="checkPath()" onkeyup="insertLastDir()">
                        </div>
                        <div class="row" style="text-align: right; padding-right: 10px"><i><code>/</code> : defines home <br/><code>./</code> : defines current directory
                                <br/><code>../</code> : defines parent directory</i></div>
                        <div class="row" style="text-align: right; padding-right: 10px"><i>press `Tab` for auto completion and check error</i></div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-default" value="move">
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
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
{{--                {{csrf_field()}}--}}
                <input class="share-folder-type" name="type" type="hidden">
                <input class="share-folder-id" name="id" type="hidden">
                <input type="hidden" name="public" id="if-public">
                <div class="modal-header" style="background-color: #808085; color: white; font-size: 20px; font-weight: bolder">
                    <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                    Share as
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 20px">
                        <button class="btn btn-default" style="width: 100%" onclick="makePublic()">
                            public
                            <span id="check-share-public" style="color: #67ed76; float: right"></span>
                        </button>
                    </div>
                    <div class="row">
                        <button class="btn btn-default" style="width: 100%" data-dismiss="modal" data-toggle="modal" data-target="#send-gift">
                            gift
                            <span style="color: white; float: right"><i class="fa fa-chevron-right"></i></span>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="send-gift" class="modal fade" role="dialog" style="z-index: 1050;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('sendGift')}}" style="margin-bottom: 0px;">
                    {{csrf_field()}}
                    <input name="currentFolder" type="hidden" value="{{$pwd}}">
                    <input class="share-folder-type" name="type" type="hidden">
                    <input class="share-folder-id" name="id" type="hidden">
                    <input type="hidden" name="public" id="if-public">
                    <div class="modal-header" style="background-color: #808085; color: white; font-size: 20px; font-weight: bolder">
                        <div class="pointer" style="float: left" data-dismiss="modal" data-toggle="modal" data-target="#share-setting"><i class="fa fa-chevron-left"></i></div>
                        <div style="float: right">
                            <button type="submit" class="btn btn-info">send <i class="fa fa-send"></i></button>
                        </div>
                    </div>
                    <div class="modal-body" style="max-height: 80vh; padding: 10px">
                        <div style="text-align: center; margin: auto; font-weight: bold; font-size: 20px">Choose people</div>
                        <ul class="gift-people-list" style="list-style: none; padding-left: 0px">
                            @if(count($connections) == 0)
                                <li style="text-align: center; margin-top: 20px">
                                    <i>You haven't connect with anyone yet</i>
                                </li>
                            @endif
                            @foreach($connections as $connection)
                                <li style="padding: 10px">
                                    <label style="display: flex; align-items: center">
                                        <input name="receivers[]" id="connection{{$connection->id}}" value="{{$connection->id}}" type="checkbox" style="margin: 10px">
                                        <div style="display: flex; align-items: center">
                                            <div class="profile-preview gift-profile" style="background-image: url('{{asset($connection->profile)}}')">
                                            </div>
                                            <div class="gift-name" style="margin: 10px">
                                                {{$connection->username}}
                                            </div>
                                        </div>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endif

@if($position == 'setting')

    <?php
        $user = \App\User::find(session('userId'));
    ?>

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
    <div id="edit-username" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('editUsername')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <div class="modal-header" style="background-color: #6f7ba2; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Edit username
                    </div>
                    <div class="modal-body">
                        <input name="value" type="text" class="form-control" placeholder="Your new username" value="{{$user->username}}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="edit-email" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('editEmail')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <div class="modal-header" style="background-color: #6f7ba2; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Edit e-mail
                    </div>
                    <div class="modal-body">
                        <input name="value" type="text" class="form-control" placeholder="Your new e-mail" value="{{$user->email}}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="edit-description" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('editDescription')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <div class="modal-header" style="background-color: #6f7ba2; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Edit description
                    </div>
                    <div class="modal-body">
                        <div id="input-tmp-description" oninput="updateTemp()" style="overflow-y: scroll; height: auto; max-height: 500px" class="form-control" placeholder="Write your description" contenteditable="">
                            {!! $user->description !!}
                        </div>
                        <script>
                            function updateTemp() {
                                $('#input-description').val($('#input-tmp-description').html());
                            }
                        </script>
                        <input id="input-description" name="value" type="hidden">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">save</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="change-password" class="modal fade" role="dialog" style="z-index: 1050">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url('changePassword')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <div class="modal-header" style="background-color: #6f7ba2; color: white; font-size: 20px; font-weight: bolder">
                        <button type="button" class="close" data-dismiss="modal" style="color: white">&times;</button>
                        Change password
                    </div>
                    <div class="modal-body">
                        <input style="margin: 5px" placeholder="old password" class="form-control" type="password" name="oldPassword">
                        <input style="margin: 5px" placeholder="new password" class="form-control" type="password" name="newPassword">
                        <input placeholder="confirm new password" class="form-control" type="password" name="confirmNewPassword">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">change</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endif


@if($message != '')
    <div class="show" id="snackbar">{{$message}}</div>
@elseif(session()->has('message') != null)
    <div class="show" id="snackbar">{{session('message')}}</div>
@endif

<!-- Menu Toggle Script -->
<script>

    $('form').attr('onsubmit', "$.LoadingOverlay('show')");

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
            $.LoadingOverlay('show');
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

    function makePublic() {
        var type = $('.share-folder-type').val();
        var id = $('.share-folder-id').val();
        var data = 'type='+type
            +'&id='+id
            +'&state='+$('#if-public').val()
            +'&_token={{csrf_token()}}';
        $.ajax({
            url: "{{url('sharePublic')}}",
            type: 'post',
            data: data,
            dataType: 'text',
            success: function( _response ){
                $('#if-public').val(_response);
                if (_response == 1) {
                    $('#check-share-public').html('<i class="fa fa-check"></i>');
                    if (type == 'sp') {
                        $('#globesp'+id).css('display', 'inline');
                    } else if (type == 'lp') {
                        $('#globelp'+id).css('display', 'inline');
                    }
                } else {
                    $('#check-share-public').html('');
                    if (type == 'sp') {
                        $('#globesp'+id).css('display', 'none');
                    } else if (type == 'lp') {
                        $('#globelp'+id).css('display', 'none');
                    }
                }

            },
            error: function( _response ){
            }
        });
    }

    function changeConnection(purpose, personId) {
        var data = 'purpose='+purpose+'&personId='+personId+'&_token={{csrf_token()}}';
        $.ajax({
            url: "{{url('connect')}}",
            type: 'post',
            data: data,
            dataType: 'text',
            success: function( _response ){
                if(purpose == 'end') {
                    $('#action'+personId).html('+');
                    $('#action'+personId).attr('onclick', "changeConnection('add', "+personId+")");
                } else if (purpose == 'add'){
                    $('#action'+personId).html('&times;');
                    $('#action'+personId).attr('onclick', "changeConnection('end', "+personId+")");
                }
            },
            error: function( _response ){
            }
        });
    }

    function changeConnectionOnSearch(purpose, personId) {
        var data = 'purpose='+purpose+'&personId='+personId+'&_token={{csrf_token()}}';
        $.ajax({
            url: "{{url('connect')}}",
            type: 'post',
            data: data,
            dataType: 'text',
            success: function( _response ){
                if(purpose == 'end') {
                    $('#actionSearch'+personId).html('+');
                    $('#actionSearch'+personId).attr('onclick', "changeConnectionOnSearch('add', "+personId+")");
                } else if (purpose == 'add'){
                    $('#actionSearch'+personId).html('&times;');
                    $('#actionSearch'+personId).attr('onclick', "changeConnectionOnSearch('end', "+personId+")");
                }
            },
            error: function( _response ){
            }
        });
    }

    function insertLastDir(evt) {
        var e = event || evt; // for trans-browser compatibility
        var charCode = e.which || e.keyCode;
        if (charCode == 9 ) {
            e.preventDefault();
        } else {
            var input = $('#destination-folder').val();
            var slash = input.lastIndexOf('/');
            $('#last-dir').val(input.substring(slash+1));
        }
    }

    @if($position == 'home' && $activeNav == 'management')
    //move-type move-id destination-folder
    function checkPath(evt) {
        var e = event || evt; // for trans-browser compatibility
        var charCode = e.which || e.keyCode;
        if (charCode == 9 ) {
            e.preventDefault();
            $.ajax({
                url: "{{url('checkPath')}}",
                type: 'post',
                data: 'id='+$('#move-id').val()+'&type='+$('#move-type').val()+'&path='+$('#destination-folder').val()+'&currentFolder={{$pwd}}&lastType='+$('#last-dir').val()+'&_token={{csrf_token()}}',
                dataType: 'json',
                success: function( _response ){
                    $('#destination-folder').css('color', _response[0]==true?'black':'red');
                    $('#destination-folder').val(_response[1]);
//                    alert(_response[2]);
                },
                error: function( _response ){
                }
            });
        }
    }
    @endif

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

</script>
</body>
</html>