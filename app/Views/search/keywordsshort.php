<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div class="search_page">
    <div class="contents">
        <div class="no_results">
            <div class="img">
                <img src="/img/warning01.png" />
            </div>
            <div class="msg">
                Keywords is too short
            </div>
        </div>
    </div>
</div>

<script>
    
    _search_page();

    function _search_page() {
        var height = $(window).height();
        var watch = $(".search_page .contents").height();
        var main_nav = Math.round($(".main_nav").height());
        var new_height = height - main_nav;

        if (height > watch) {
            $(".search_page .contents").css({
                height: new_height + "px"
            });
        }
    }
</script>
<?= $this->endSection() ?>