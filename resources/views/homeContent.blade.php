<div class="row" style="text-align: center; margin-bottom: 10px">
    @include('directories')
</div>
<div class="row">
    @include('createFolder')
</div>
{{--{!! view('folder') !!}--}}
<div class="row">
    <ul class="folder-group">
        @foreach($folders as $folder)

            {!! view('viewItem', ['folder' => $folder]) !!}

        @endforeach

        @foreach($playlists as $playlist)

            {!! view('viewItem', ['playlist' => $playlist]) !!}

        @endforeach

        @foreach($lessons as $lesson)

            {!! view('viewItem', ['lesson' => $lesson]) !!}

        @endforeach
    </ul>
</div>