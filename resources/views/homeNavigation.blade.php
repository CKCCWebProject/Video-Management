<div style="width: 300px; margin: auto">
    <ul class="home-nav">
        <li class="{{$activeNav=='management'?'active-nav':''}}">
            <a href="{{url('home/management')}}">Management</a>
        </li>
        <li class="{{$activeNav=='favorite'?'active-nav':''}}">
            <a href="{{url('home/favorite')}}">Favorites</a>
        </li>
    </ul>
</div>