<?php
    $user = \App\User::find(session('userId'));
?>
<div class="setting-container">
    <table class="setting-table table table-striped">
        <tbody>
            <tr>
                <td class="setting-title">
                    Username
                </td>
                <td>
                    {{$user->username}}
                </td>
            </tr>
            <tr>
                <td class="setting-title">
                    E-mail
                </td>
                <td>
                    {{$user->email}}
                </td>
            </tr>
            <tr>
                <td class="setting-title">
                    Description
                </td>
                <td style="text-align: justify">
                    {!! $user->decription==''?'<span style="color: lightgrey">(Write something about you)</span>':$user->decription !!}
                </td>
            </tr>
            <tr>
                <td class="setting-title" colspan="2">
                    Change password
                    <div style="float: right">
                        <i class="fa fa-chevron-right"></i>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row" style="text-align: center;">
        <a href="{{url('signout')}}"><button class="btn btn-danger logout">Log out</button></a>
    </div>
    <div class="suicide row" style="margin-top: 60px; font-weight: bolder;">
        <a data-toggle="modal" data-target="#deleteAccount">Delete account</a>
    </div>
</div>