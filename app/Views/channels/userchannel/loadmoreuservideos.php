<?php
    use App\Assets\Assets;
    $assets = new Assets();
?>

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