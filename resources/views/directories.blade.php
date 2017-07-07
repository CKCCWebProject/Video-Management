<div class="directories" style="text-align: center; margin: auto">
    <div class="back-dir">
    @if(count($directories) > 1)
            <a href="{{url('home/management/'.($directories[count($directories) - 2]->f_id))}}">
                <i class="fa fa-arrow-left"></i>
            </a>
    @endif
    </div>
    <div class="dir-container thinScroll">
        @foreach($directories as $key=>$directory)
            @if($key != 0)
                <i class="fa fa-play mapper"></i>
            @endif
                @if($key == (count($directories) - 1))
                    <span class="dir last-dir">{{$directory->folderName}}</span>
                @else
                    <a href="{{url('home/management/'.$directory->f_id)}}" style="text-decoration: none">
                        <span class="dir">{{$directory->folderName}}</span>
                    </a>
                @endif
        @endforeach

        {{--<i class="fa fa-play mapper"></i>--}}
        {{--<span class="dir last-dir">My videos</span>--}}
    </div>
</div>