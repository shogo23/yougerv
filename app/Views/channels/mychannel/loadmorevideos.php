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
        <div class="opt_btn">
            <div class="btn-group">
                <i class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="javascript:" onclick="javascript: _edit(<?= $video['id'] ?>)">Edit Video Details</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" onclick="javascript: _delete_video(<?= $video['id'] ?>)" href="javascript:">Delete Video</a>
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </li>
<?php endforeach; ?>