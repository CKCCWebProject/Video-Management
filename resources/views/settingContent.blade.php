<?php
    $user = \App\User::find(session('userId'));
?>
<div class="row">
    </div>
    <div class="panel panel-primary" style="max-width: 1000px; margin: auto; margin-bottom: 30px">
        <div class="panel-heading">
            Username
            <a style="color: white; font-weight: bold; float: right" data-toggle="modal" data-target="#edit-username">
                <i class="fa fa-edit"> </i> edit
            </a>
        </div>
        <div class="panel-body">{{$user->username}}</div>
    </div>
    <div class="panel panel-primary" style="max-width: 1000px; margin: auto; margin-bottom: 30px">
        <div class="panel-heading">
            E-mail
            <a style="color: white; font-weight: bold; float: right" data-toggle="modal" data-target="#edit-email">
                <i class="fa fa-edit"> </i> edit
            </a>
        </div>
        <div class="panel-body">{{$user->email}}</div>
    </div>
    <div class="panel panel-primary" style="max-width: 1000px; margin: auto; margin-bottom: 30px">
        <div class="panel-heading">
            Description
            <a style="color: white; font-weight: bold; float: right" data-toggle="modal" data-target="#edit-description">
                <i class="fa fa-edit"> </i> edit
            </a>
        </div>
        <div class="panel-body">{!! $user->description==''?'<span style="color: lightgrey">nothing to show</span>':$user->description !!}</div>
    </div>
    <div style="text-align: center">
        <button class="btn" data-toggle="modal" data-target="#change-password">Change password</button>
    </div>
    <div class="row" style="text-align: center;">
        <a href="{{url('signout')}}"><button class="btn btn-danger logout">Log out</button></a>
    </div>
    <div class="suicide row" style="margin-top: 60px; font-weight: bolder;">
        <a data-toggle="modal" data-target="#deleteAccount">Delete account</a>
    </div>
</div>