@include('include')
<body>
<nav class="navbar navbar-inverse" style="background-color: #FF7C7C; border: 0px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <a style="color: white;">Login</a>
            </button>
            <a class="navbar-brand" href="#">{{--Logo--}}</a>
        </div>
        <div class="collapse navbar-collapse" style="border: 0px; margin-top: 4px; margin-bottom: 4px;" id="myNavbar">
            <div class="nav navbar-nav">

            </div>
            <ul class="nav navbar-nav navbar-right login-container">
                <form method="post" action="{{url('signin')}}" style="margin-bottom: 0px">
                    {{csrf_field()}}
                    <div class="login-form col-xs-12 col-sm-10">
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 push-buttom-s">
                            <input class="form-control input-login" style="width: 100%;" type="text" value="nimol&#64gmail.com" name="email" placeholder="Your e-mail" required>
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 push-buttom-s">
                            <input class="form-control input-login" style="width: 100%;" type="password" value="1234" name="password" placeholder="Your password" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2" style="text-align: center">
                        <button type="submit" class="btn btn-primary btn-login">
                            <span class="fa fa-sign-in"></span>&nbsp; Log in
                        </button>
                    </div>
                    {{--<input type="hidden" name="_token" value="{{Session::token()}}">--}}
                </form>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-12 text-left">
            <div class="signup-form">
                <form method="post" action="{{url('/signup')}}">
                    {{csrf_field()}}
                    <div class="signup-title" style="margin: 20px 20px;">
                        Create new account
                    </div>
                    <input type="text" class="form-control push-buttom bordered" name="signup_username" placeholder="Username" required>
                    <input type="text" class="form-control push-buttom bordered" name="signup_email" placeholder="E-mail" required>
                    <input type="text" class="form-control push-buttom bordered" name="signup_password" placeholder="Password" required>
                    <input type="text" class="form-control push-buttom bordered" name="signup_confirmpassword" placeholder="Confirm password" required>
                    <button type="submit" class="btn btn-normal" style="color: white">Sign up</button>

                    {{--<input type="hidden" name="_token" value="{{Session::token()}}">--}}
                </form>
            </div>
        </div>
    </div>
</div>

</body>

    <script>

        @if(isset($message))
            alert('{{$message}}');
        @endif
    </script>

</html>
