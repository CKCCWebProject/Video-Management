<div class="row" style="margin-bottom: 10px">
    @include('homeNavigation')
</div>
<div class="row" style="text-align: center; margin-bottom: 10px">
    @include('directories')
</div>
<div class="row">
    @include('createFolder')
</div>
<div class="row" style="display: flex; align-items: center">
    <div class="row">
        <div style="float: left">
            @include('playList')
        </div>
        <div style="float: left; color: black">
            <div class="row">
                Play list name
            </div>
            <div class="row">
                information
            </div>
        </div>
    </div>
</div>