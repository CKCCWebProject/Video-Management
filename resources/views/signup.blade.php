<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
    <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <script src="{{asset('js/bootstrap.min.js')}}"></script>

</head>
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
                <form action="#">
                    <div class="login-form col-xs-12 col-sm-10">
                        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 push-buttom-s">
                            <input class="form-control input-login" style="width: 100%;" type="text" placeholder="Your e-mail">
                        </div>
                        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 push-buttom-s">
                            <input class="form-control input-login" style="width: 100%;" type="password" placeholder="Your password">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2" style="text-align: center">
                        <button type="submit" class="btn btn-primary btn-login">
                            <span class="glyphicon glyphicon-log-in"></span>&nbsp; Log in
                        </button>
                    </div>
                </form>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-12 text-left">
            <div class="signup-form">
                <form action="#">
                    <div class="signup-title" style="margin: 20px 20px;">
                        Create new account
                    </div>
                    <input type="text" class="form-control push-buttom bordered" placeholder="Username">
                    <input type="text" class="form-control push-buttom bordered" placeholder="E-mail">
                    <input type="text" class="form-control push-buttom bordered" placeholder="Password">
                    <input type="text" class="form-control push-buttom bordered" placeholder="Confirm password">
                    <button class="btn btn-normal" style="color: white">Sign up</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{--<footer class="container-fluid text-center">--}}
    {{--<p>Footer Text</p>--}}
{{--</footer>--}}

</body>
</html>
