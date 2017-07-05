<nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: {{$position==1?'#FF7C7C':($position==3?'#7B94FD':"#FFD27C")}}; border: 0px;">
    <div class="container-fluid">
        <div class="navbar-header" style="padding-bottom: 5px; float: left">
            <div class="navbar-brand" style="padding: 0px">
                <a href="#menu-toggle" class="btn toggler" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
            </div>
            {{--<a class="navbar-brand" href="#">--}}{{--Logo--}}{{--</a>--}}

        </div>
        @if($position == 1)
            <div class="search-container">
                <form>
                    <input class="search-box form-control" type="text" name="search" style="color: white;" placeholder="Search..">
                </form>
            </div>
        @endif
    </div>
</nav>