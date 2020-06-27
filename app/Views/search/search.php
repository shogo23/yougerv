<?php
	//Scss path for this view file /src/sess/pages/search.scss
	
	use App\Assets\Assets;
    $assets = new Assets();
    $request = \Config\Services::request();
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="search_page">
    <div class="contents">
        <?php if (count($channels) > 0 && !$request->getGet('page_video') || $request->getPostGet('page_video') == 1) : ?>
            <div class="channel_search">
                <h1>Channel(s)</h1>

                <ul>
                    <?php foreach ($channels as $channel) : ?>
                        <li>
                            <div class="thumb">
                                <a href="/channel/<?= $channel->id ?>/<?= $channel->firstname . '_' . $channel->lastname ?>"><img src="<?= $assets->get_picture($channel->id) ?>" /></a>
                            </div>
                            <div class="details">
                                <div class="fullname">
                                    <a href="/channel/<?= $channel->id ?>/<?= $channel->firstname . '_' . $channel->lastname ?>"><?= $channel->firstname . ' ' . $channel->lastname ?></a>
                                </div>
                                <div class="joined">
                                    Joined At: <?= $assets->when($channel->created_at) ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (count($videos) > 0) : ?>
            <div class="video_search">
                <h1>Videos</h1>
                <ul>
                    <?php foreach ($videos as $video) : ?>
                        <li>
                            <div class="thumb">
                                <a href="/watch/<?= $video['slug'] ?>"><img alt="thumb" src="/vids/thumbs/<?= $video['slug'] ?>.jpg" /></a>
                                <div class="length"><?= $video['length'] ?></div>
                            </div>
                            <div class="details">
                                <div class="title"><a title="<?= $video['title'] ?>" href="/watch/<?= $video['slug'] ?>"><?= $assets->reduce_title($video['title']) ?></a></div>
                                <div class="uploader">
                                    <a href="/channel/<?= $video['user_id'] . '/' . $video['firstname'] . '_' . $video['lastname'] ?>"><?= $video['firstname'] . ' ' . $video['lastname'] ?></a>
                                </div>
                                <div class="date clear"><?= $assets->when($video['created_at']) ?></div>
                            </div>
                            <div class="clear"></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?= $pagination_visibility ? $pager->links('video', 'custom_simple') : ''; ?>
        <?php endif; ?>

        <?php if (count($channels) <= 0 && count($videos) <= 0) : ?>
            <div class="no_results">
                <div class="img">
                    <img src="/img/mg.png" />
                </div>
                <div class="msg">
                    No results found
                </div>
            </div>
        <?php endif; ?>
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