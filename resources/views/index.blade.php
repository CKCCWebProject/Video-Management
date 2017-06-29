<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            background-color: #EBEBEB;
            font-family: 'Raleway', sans-serif;
        }

        .folder {
            width: 150px;
            height: 105px;
            margin: 0 auto;
            margin-top: 50px;
            position: relative;
            background-color: #f7f193;
            border-radius: 0 6px 6px 6px;
            box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.59);
        }

        .folder:before {
            content: '';
            width: 50%;
            height: 12px;
            border-radius: 0 20px 0 0;
            background-color: #F7F193;
            position: absolute;
            top: -12px;
            left: 0px;
        }

        .playlist {
            width: 150px;
            height: 105px;
            margin: 0 auto;
            margin-top: 50px;
            position: relative;
            background-color: #9A3D3D;
            border-radius: 0 6px 6px 6px;
            box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.59);
        }

        .playlist:before {
            content: '';
            width: 50%;
            height: 12px;
            border-radius: 0 20px 0 0;
            background-color: #9A3D3D;
            position: absolute;
            top: -12px;
            left: 0px;
        }

        .lesson {
            width: 150px;
            height: 105px;
            margin: 0 auto;
            margin-top: 50px;
            position: relative;
            background-color: #586BCE;
            border-radius: 0 6px 6px 6px;
            box-shadow: 4px 4px 7px rgba(0, 0, 0, 0.59);
        }

        .lesson:before {
            content: '';
            width: 50%;
            height: 12px;
            border-radius: 0 20px 0 0;
            background-color: #586BCE;
            position: absolute;
            top: -12px;
            left: 0px;
        }

        .arrow-right {
            width: 0;
            height: 0;
            border-top: 30px solid transparent;
            border-bottom: 30px solid transparent;
            border-left: 50px solid green;
        }

        .arrow-right:hover {
            width: 0;
            height: 0;
            border-top: 40vw solid transparent;
            border-bottom: 40px solid transparent;
            border-left: 60px solid green;
        }
    </style>
</head>
<body>

<div class="folder">

</div>
<div class="playlist">
    <div class="arrow-right">

    </div>
</div>
<div class="lesson">

</div>

{{--<footer class="container-fluid text-center">--}}
{{--<p>Footer Text</p>--}}
{{--</footer>--}}

</body>
</html>
