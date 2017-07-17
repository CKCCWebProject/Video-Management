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

                    <div class="row" style="text-align: center">
                        <ul class="nav nav-tabs" style="width: 380px; margin: auto; padding-left: 50px">
                            <li class="sp active"><a data-toggle="pill" href="#menu1">Song playlists</a></li>
                            <li class="lp"><a data-toggle="pill" href="#menu2">Lesson playlists</a></li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div id="menu1" class="tab-pane fade in active">

                            <ul class="folder-group">
                                @foreach($ownSP/*->getCollection()->all()*/ as $playlist)

                                    <?php
                                    $gift = \App\GiftBox::where('item_id', $playlist->sp_id)->where('item_type', 1)->where('receiver_id', session('userId'))->get();
                                    ?>

                                    {!! view('viewItem', ['playlist' => $playlist, 'search' => true, 'mode'
                                        => ($playlist->u_id==session('userId')?'user':(count($gift)>0?'gift':'globe')),
                                        'gift'=>count($gift)>0?$gift[0]:[]]) !!}

                                @endforeach
                            </ul>

{{--                            {{$ownSP->links()}}--}}
                        </div>
                        <div id="menu2" class="tab-pane fade">

                            <ul class="folder-group">
                                @foreach($ownLP as $lesson)

                                    <?php
                                    $gift = \App\GiftBox::where('item_id', $lesson->l_id)->where('item_type', 2)->where('receiver_id', session('userId'))->get();
                                    ?>

                                    {!! view('viewItem', ['lesson' => $lesson, 'search' => true, 'mode'
                                        => ($lesson->u_id==session('userId')?'user':(count($gift)>0?'gift':'globe')),
                                        'gift'=>count($gift)>0?$gift[0]:[]]) !!}

                                @endforeach
                            </ul>

                            {{--{{$ownLP->links()}}--}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>

<div id="deleteFolder" class="modal fade" role="dialog" style="z-index: 1050">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form id="delete-form" method="post" action="{{url('deleteFolder')}}" style="margin-bottom: 0px" onsubmit="return checkDelete()">
                {{csrf_field()}}
                <input name="currentFolder" type="hidden" value="">
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
                <input name="currentFolder" type="hidden" value="">
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
                <input name="currentFolder" type="hidden" value="">
                <input class="share-folder-type" name="type" type="hidden">
                <input class="share-folder-id" name="id" type="hidden">
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

    function onRejectGift(gid) {
        if (confirm("You really want to reject?")) {
            return $('#reject-gift'+gid).submit();
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
                        $('#publicsp'+id).val(1);
                    } else if (type == 'lp') {
                        $('#publiclp'+id).val(1);
                    }
                } else {
                    $('#check-share-public').html('');
                    if (type == 'sp') {
                        $('#publicsp'+id).val(0);
                    } else if (type == 'lp') {
                        $('#publiclp'+id).val(0);
                    }
                }

            },
            error: function( _response ){
            }
        });
    }

    function formDelete(type, id) {
        $("#folder-type").val(type);
        $("#folder-id").val(id);
        focusUrl();
    }

    function focusUrl() {
        setTimeout(function () {
            $("#confirm-delete").focus();
        }, 500);
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

</script>
</body>
</html>