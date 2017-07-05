<div class="row" style="text-align: center; margin-bottom: 10px">
    <hr/>
</div>
<div class="favorite-list">
    <form action="">
        <div class="row" style="color: grey; display: flex; align-items: center; margin-bottom: 40px;">
            <div>
                <input type="checkbox" id="select-all">
            </div>
            <div style="padding-top: 7px; margin-left: 10px;">
                <label for="select-all" class="select-all">Select all</label>
            </div>
            <div style="margin-right: 20px; margin-left: auto">
                <button type="submit" class="btn btn-danger">remove from favorite
                </button>
            </div>
        </div>
        <div class="row">
            <ul class="list-favorite">
                <li class="each-fav row" style="display: flex; align-items: center">
                    <input class="check-fav checkbox checkbox-primary" type="checkbox" id="select-all">
                    <div class="favorite-thumbnail profile-preview" style="background-image: url('https://www.smashingmagazine.com/wp-content/uploads/2015/06/10-dithering-opt.jpg')"></div>
                    <div class="fav-text">
                        <div class="fav-title">
                            My lovely owl
                        </div>
                        <div class="fav-dir">
                            home/animals
                        </div>
                    </div>
                </li>
                <li class="each-fav row" style="display: flex; align-items: center">
                    <input class="check-fav checkbox checkbox-primary" type="checkbox" id="select-all">
                    <div class="favorite-thumbnail profile-preview" style="background-image: url('https://www.smashingmagazine.com/wp-content/uploads/2015/06/10-dithering-opt.jpg')"></div>
                    <div class="fav-text">
                        <div class="fav-title">
                            My lovely owl
                        </div>
                        <div class="fav-dir">
                            home/animals
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </form>
</div>

<script>
    $("#select-all").change(function () {
        if ($("#select-all").prop("checked") == true) {
            $(".check-fav").prop("checked", true);
        } else {
            $(".check-fav").prop("checked", false);
        }
    });
</script>