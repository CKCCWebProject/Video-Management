<nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: {{$position=='home'?'#FF7C7C':($position=='connection'?'#7B94FD':($position=='gift'?'#86DA6D':($position=='about'?'#8BAEE1':"#FFD27C")))}}; border: 0px;">
    <div class="container-fluid">
        <div class="navbar-header" style="padding-bottom: 5px; float: left">
            <div class="navbar-brand" style="padding: 0px">
                <a href="#menu-toggle" class="btn toggler" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            {{--<a class="navbar-brand" href="#">--}}{{--Logo--}}{{--</a>--}}

        </div>
        @if($position == 'home')
            <div class="search-container">
                <form>
                    <input class="search-box form-control" type="text" name="search" style="color: white;" placeholder="Search..">
                </form>
            </div>
        @elseif($position == 'connection')
                <div class="search-container">
                    <form>
                        <input class="search-box form-control" type="text" name="search" style="color: white;" placeholder="Search..">
                    </form>
                </div>
            @endif
    </div>
</nav>