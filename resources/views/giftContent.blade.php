<div class="container">

    @forelse($gifts as $gift)
        @include('gift')
    @empty
        <div style="min-height: 80vh; display: flex; align-items: center;">
            <h1 style="margin: auto">Empty gift box</h1>
        </div>
    @endforelse

</div>