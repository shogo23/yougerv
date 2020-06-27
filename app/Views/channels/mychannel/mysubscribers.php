<?php
    use App\Assets\Assets;
    $assets = new Assets();
?>

<?php if (count($subscribers) <= 0) : ?>
<div class="no_subscribers alert alert-info">
    You don't have subscribers at this time.
</div>
<?php else : ?>

<div class="my_subscribers">
    <h1>My Subscribers</h1>

    <ul>
        <?php foreach ($subscribers as $subscriber) : ?>
            <li id="subscriber_<?= $subscriber['subscriber_id'] ?>">
                <div class="thumb">
                    <a href="/channel/<?= $subscriber['subscriber_id'] ?>/<?= $subscriber['firstname'] . '_' . $subscriber['lastname'] ?>"><img src="<?= $assets->get_picture($subscriber['subscriber_id']) ?>" /></a>
                </div>
                <div class="details">
                    <div class="fullname">
                        <a href="/channel/<?= $subscriber['subscriber_id'] ?>/<?= $subscriber['firstname'] . '_' . $subscriber['lastname'] ?>"><?= $subscriber['firstname'] . ' ' . $subscriber['lastname'] ?></a>
                    </div>
                    <div class="joined">
                        Joined At: <?= $assets->when($subscriber['created_at']) ?>
                    </div>
                    <div class="opt">
                        <span class="btn btn-outline-danger" onclick="javascript: remove(<?= $subscriber['subscriber_id'] ?>)">Remove</span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    

    function remove(id) {
        var data = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            subscriber_id: id
        };

        $.post("/mychannel/mysubscribers/remove", data, r => {
            if (r == "ok") {
                $(".my_subscribers ul li#subscriber_" + id).fadeOut();
            }
        });
    }
</script>

<?php endif; ?>