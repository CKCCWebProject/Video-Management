<div class="folder" style="display: flex; align-items: center">
    @if($folder->folderName == 'gift' && $folder->if_deletable == false)
        <div style="width: 100%; clear: both; text-align: center">
        <span>
            <i class="gift-icon fa fa-gift" style="color: white;"></i>
        </span>
        </div>
    @elseif($folder->folderName == 'from public' && $folder->if_deletable == false)
        <div style="width: 100%; clear: both; text-align: center">
        <span>
            <i class="gift-icon fa fa-globe" style="color: white;"></i>
        </span>
        </div>
    @endif
</div>