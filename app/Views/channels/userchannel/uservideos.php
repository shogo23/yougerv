<?php
    use App\Assets\Assets;
    $assets = new Assets();
?>

<?php if (count($videos ) <= 0 ) : ?>
<div class="no_user_videos alert alert-info">
    There are no videos at this time.
</div>
<?php else : ?>

<div class="uservideos">
    <h1><?= $firstname . ' ' . $lastname ?>'s Videos</h1>
    <div class="videos">
        <ul>
            <?php foreach ($videos as $video) : ?>
                <li id="video_<?= $video['id'] ?>">
                    <div class="thumb">
                        <a href="/watch/<?= $video['slug'] ?>"><img alt="thumb" src="/vids/thumbs/<?= $video['slug'] ?>.jpg" /></a>
                        <div class="length"><?= $video['length'] ?></div>
                    </div>
                    <div class="details">
                        <div class="title"><a title="<?= $video['title'] ?>" href="/watch/<?= $video['slug'] ?>"><?= $assets->reduce_title($video['title']) ?></a></div>
                        <div class="date clear"><?= $assets->when($video['created_at']) ?></div>
                    </div>
                    <div class="clear"></div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    var fetching_data = false;
    var offset = 10;

    $(window).on("scroll" , () => {
        if ($(window).scrollTop() >= $(document).height() - $(window).height() - 200 && !fetching_data) {
            fetching_data = true;

            var data = {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                channel_owner_id: <?= $channel_owner_id ?>,
                offset: offset
            };

            $.post('/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/loadmoreuservideos', data, (r) => {
                $(".videos ul").append(r);
                fetching_data = false;
                offset += 10;
            });
        }
    });
</script>
<?php endif; ?>