<div class="top-margin"></div>

<div class="row" style="margin-bottom: 10px">
    @include('homeNavigation')
</div>
<div class="row" style="text-align: center; margin-bottom: 10px">
    @include('directories')
</div>
<div class="row">
    @include('createFolder')
</div>
<div class="row">
    <div class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            <div>
                @include('playList')
            </div>
            <div>

            </div>
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <div class="fold-name">
                Play list name hello world is the new word
            </div>
            <div class="fold-info">
                information
            </div>
        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#">edit</a></li>
                <li class="set-opt"><a href="#">share setting</a></li>
                <li class="set-opt"><a href="#">copy</a></li>
                <li class="set-opt"><a href="#">delete</a></li>
            </ul>
        </div>
    </div>

    <div class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            <div>
                @include('folder')
            </div>
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <div class="fold-name">
                Play list name hello world is the new word
            </div>
            <div class="fold-info">
                information
            </div>
        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#">edit</a></li>
                <li class="set-opt"><a href="#">share setting</a></li>
                <li class="set-opt"><a href="#">copy</a></li>
                <li class="set-opt"><a href="#">delete</a></li>
            </ul>
        </div>
    </div>

    <div class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            <div>
                @include('lesson')
            </div>
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <div class="fold-name">
                Play list name hello world is the new word
            </div>
            <div class="fold-info">
                information
            </div>
        </div>
        <div class="folder-setting dropdown">
            <i class="tree-dots fa fa-ellipsis-v" type="button" data-toggle="dropdown"></i>
            <ul class="dropdown-menu setting-option">
                <li class="set-opt"><a href="#">edit</a></li>
                <li class="set-opt"><a href="#">share setting</a></li>
                <li class="set-opt"><a href="#">copy</a></li>
                <li class="set-opt"><a href="#">delete</a></li>
            </ul>
        </div>
    </div>
</div>