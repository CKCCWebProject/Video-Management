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
            @include('playList')
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <div class="fold-name">
                Play list name hello world is the new word
            </div>
            <div class="fold-info">
                information
            </div>
        </div>
        <div class="folder-setting">
            <i class="fa fa-ellipsis-v"></i>
        </div>
    </div>

    <div class="row each-folder" style="display: flex; align-items: center;">
        <div style="float: left;">
            @include('folder')
        </div>
        <div class="fold-text" style="float: left; color: black;">
            <div class="fold-name">
                Play list name hello world is the new word
            </div>
            <div class="fold-info">
                information
            </div>
        </div>
        <div class="folder-setting">
            <i class="fa fa-ellipsis-v"></i>
        </div>
    </div>
</div>