<li class="row each-folder gift" style="display: flex; align-items: center;">
    <div style="float: left;">
        <div>
            <a href="{{url('home/management/'.($gift->item_type==1?'playSong':'playLesson').'/'.$gift->item_id)}}">
                @if($gift->item_type==1)
                    @include('playlist')
                @elseif ($gift->item_type==2)
                    @include('lesson')
                @endif
            </a>
        </div>
    </div>
    <div class="fold-text" style="float: left; color: black;">
        <a href="{{url('home/management/'.($gift->item_type==1?'playSong':'playLesson').'/'.$gift->item_id)}}">
            <div class="fold-name">
                @if($gift->item_type==1)
                    {{ \App\SongPlaylist::find($gift->item_id)->sp_name }}
                @elseif ($gift->item_type==2)
                    {{ \App\LessonPlaylist::find($gift->item_id)->l_name }}
                @endif

            </div>
            <div class="fold-info">
                From : {{\App\User::find($gift->sender_id)->username}}
            </div>
        </a>

    </div>
    <div class="respond-gift" style="margin-right: 0px; margin-left: auto; text-align: right;">
        <span>
            <form method="post" action="receiveGift" style="margin-bottom: 0px; display: inline">
                {{csrf_field()}}
                <input type="hidden" name="gId" value="{{$gift->g_id}}">
                <button type="submit" class="btn btn-info">
                <i class="fa fa-smile-o"> </i> receive
            </button>
            </form>
        </span>
        <span>
            <form id="reject-gift{{$gift->g_id}}" method="post" action="rejectGift" style="margin-bottom: 0px; display: inline">
                {{csrf_field()}}
                <input type="hidden" name="gId" value="{{$gift->g_id}}">
                <button type="button" class="btn btn-danger reject-gift" onclick="onRejectGift('{{$gift->g_id}}')">
                <i class="fa fa-frown-o"> </i> reject
            </button>
            </form>
        </span>
    </div>
</li>

<script>
    function onRejectGift(gid) {
        if (confirm("You really want to reject?")) {
            return $('#reject-gift'+gid).submit();
        }
    }
</script>