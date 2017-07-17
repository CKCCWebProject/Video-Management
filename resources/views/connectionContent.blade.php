<div id="connection-content" class="container">

    @foreach($people->getCollection()->all() as $person)
        @include('people')
    @endforeach

</div>
    {{$people->links()}}
<div id="search-connection-content" class="container" style="display: none">

</div>