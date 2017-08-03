<div id="connection-content" class="container">

    @forelse($people->getCollection()->all() as $person)
        @include('people')
    @empty
        <div style="min-height: 80vh; display: flex; align-items: center;">
            <h1 style="margin: auto">You are alone</h1>
        </div>
    @endforelse

</div>
    {{$people->links()}}
<div id="search-connection-content" class="container" style="display: none">

</div>