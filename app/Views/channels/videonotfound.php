<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="watch_container">
    <div class="notfound">
        <div class="img">
            <img src="/img/videonotfound.png" />
        </div>
        <div class="msg">
            The video you requestes was not found.
        </div>
    </div>
</div>

<script>

    _watchContainer();

    $(window).resize(function() {
        _watchContainer();
    });

    function _watchContainer() {
        var height = $(window).height();
        var watch = $(".watch_container").height();
        var main_nav = Math.round($(".main_nav").height());
        var new_height = height - main_nav;

        if (height > watch) {
            $(".watch_container").css({
                height: new_height + "px"
            });
        }
    }
</script>

<?= $this->endSection() ?>