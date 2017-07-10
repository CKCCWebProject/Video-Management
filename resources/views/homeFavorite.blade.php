<div class="row" style="text-align: center; margin-bottom: 10px">
    <hr/>
</div>
<div class="favorite-list">
    <form method="post" action="{{url('home/favorite/removeFavorite')}}">
        {{csrf_field()}}
        <div class="row" style="color: grey; display: flex; align-items: center; margin-bottom: 40px;">
            <div>
                <input type="checkbox" id="select-all">
            </div>
            <div style="padding-top: 7px; margin-left: 10px;">
                <label for="select-all" class="select-all">Select all</label>
            </div>
            <div style="margin-right: 20px; margin-left: auto">
                <button type="submit" class="btn btn-danger">remove from favorite
                </button>
            </div>
        </div>
        <div class="row">
            <ul class="list-favorite">
                @foreach($favoriteVideos as $favoriteVideo)
                    <li class="each-fav row" style="display: flex; align-items: center">
                        <a href="{{url('/home/management/playSong/'.$favoriteVideo->sp_id.'/'.$favoriteVideo->s_id)}}" style="display: flex; align-items: center; color: black">
                            <input name="favorite[]" value="{{$favoriteVideo->s_id}}" class="check-fav checkbox checkbox-primary" type="checkbox" id="select-all">
                            <div class="favorite-thumbnail profile-preview" style="background-image: url('https://img.youtube.com/vi/{{$favoriteVideo->url}}/mqdefault.jpg')"></div>
                            <div class="fav-text">
                                <div class="fav-title">
                                    {{$favoriteVideo->title}}
                                </div>
                                <div class="fav-dir">
                                    {{\App\Http\Controllers\PageController::songDirectory($favoriteVideo->sp_id)}}
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </form>
</div>

<script>
    $("#select-all").change(function () {
        if ($("#select-all").prop("checked") == true) {
            $(".check-fav").prop("checked", true);
        } else {
            $(".check-fav").prop("checked", false);
        }
    });


</script>