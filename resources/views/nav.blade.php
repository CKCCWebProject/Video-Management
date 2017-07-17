<nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: {{($position=='home' || isset($search))?'#FF7C7C':($position=='connection'?'#7B94FD':($position=='gift'?'#FFA142':($position=='about'?'#8BAEE1':"#f1c130")))}}; border: 0px;">
    <div class="container-fluid">
        <div class="navbar-header" style="padding-bottom: 5px; float: left">
            <div class="navbar-brand" style="padding: 0px">
                <a href="#menu-toggle" class="btn toggler" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            {{--<a class="navbar-brand" href="#">--}}{{--Logo--}}{{--</a>--}}

        </div>
        @if($position == 'home' || isset($search))
            <div class="search-container">
                <form method="get" action="{{url('/home/search/result')}}">
                    <input class="search-box form-control" type="text" name="item" style="color: white;" placeholder="Search..">
                </form>
            </div>
        @elseif($position == 'connection')
            <div class="search-container">
                <form method="get" action="{{url('/connection/result')}}">
                    <input id="search-people" class="search-box form-control" type="text" name="name" style="color: white;" placeholder="Search.." {{--oninput="getTempPeople()"--}}>
                </form>
            </div>
        @endif
    </div>
</nav>

<script>
    {{--function getTempPeople() {--}}
        {{--if ($('#search-people').val() != '') {--}}
            {{--$('#connection-content').css('display', 'none');--}}
            {{--$.ajax({--}}
                {{--url: "{{url('searchPeople')}}",--}}
                {{--type: 'post',--}}
                {{--data: 'peopleName=' + $('#search-people').val() + '&_token=' + '{{csrf_token()}}',--}}
                {{--dataType: 'text',--}}
                {{--success: function (_response) {--}}
{{--//                $("#heart"+$id).css('color', _response);--}}
{{--//                alert(_response)--}}
                    {{--$('#search-connection-content').html(_response);--}}
                {{--},--}}
                {{--error: function (_response) {--}}
                {{--}--}}
            {{--});--}}
            {{--$('#search-connection-content').css('display', 'block');--}}
        {{--} else {--}}
            {{--$('#search-connection-content').css('display', 'none');--}}
            {{--$('#connection-content').css('display', 'block');--}}
        {{--}--}}
    {{--}--}}
</script>