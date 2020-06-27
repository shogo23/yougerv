<?php
    use App\Assets\Assets;
    $assets = new Assets();
?>

<?php if (count($subscriptions) <= 0) : ?>
<div class="no_subscriptions alert alert-info">
    You don't have subscribers at this time.
</div>
<?php else : ?>

<div class="my_subscriptions">
    <h1>My Subscriptions</h1>

    <ul>
        <?php foreach ($subscriptions as $subscription) : ?>
            <li id="subscription_<?= $subscription['user_id'] ?>">
                <div class="thumb">
                    <a href="/channel/<?= $subscription['user_id'] ?>/<?= $subscription['firstname'] . '_' . $subscription['lastname'] ?>"><img src="<?= $assets->get_picture($subscription['user_id']) ?>" /></a>
                </div>
                <div class="details">
                    <div class="fullname">
                        <a href="/channel/<?= $subscription['user_id'] ?>/<?= $subscription['firstname'] . '_' . $subscription['lastname'] ?>"><?= $subscription['firstname'] . ' ' . $subscription['lastname'] ?></a>
                    </div>
                    <div class="joined">
                        Joined At: <?= $assets->when($subscription['created_at']) ?>
                    </div>
                    <div class="opt">
                        <span class="btn btn-outline-danger" onclick="javascript: remove(<?= $subscription['user_id'] ?>)">Remove</span>
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
            user_id: id
        };

        $.post("/mychannel/mysubscription/remove", data, r => {
            if (r == "ok") {
                $(".my_subscriptions ul li#subscription_" + id).fadeOut();
            }
        });
    }
</script>

<?php endif; ?>