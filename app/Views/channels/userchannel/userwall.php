<?php
    use App\Assets\Assets;
    $assets = new Assets();
?>

<div class="userwall">
    <div class="contents">
        <?php if ($assets->hasSession()) : ?>
            <div class="form">
                <div class="field">
                    <label for="post">Write your post on <?= $firstname . ' ' .$lastname ?>'s wall</label>
                    <textarea id="post"></textarea>
                </div>
                <div class="btn_container">
                    <button type="button" id="send" class="btn btn-primary">Post</button>
                </div>
            </div>
            <div class="flash_msg alert alert-success">
                Your post needs to approve by <?= $firstname . ' ' . $lastname ?>.
            </div>
        <?php endif; ?>
        <div class="userwall_posts">
            
        </div>
    </div>
</div>

<script>
    <?= $assets->hasSession() ? 'stretchTextarea("#post");' : ''; ?>

    load_wallposts();

    $("#send").on("click", () => {
        if ($("#post").val() !== "") {
            var data = {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                channel_owner_id: <?= $channel_owner_id ?>,
                "post": $("#post").val()
            }

            $.post("/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/createwallpost", data, r => {
                if (r == "ok") {
                    var data = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        channel_owner_id: <?= $channel_owner_id ?>,
                        channel_owner_firstname: "<?= $firstname ?>",
                        channel_owner_lastname: "<?= $lastname ?>",
                        notification_type: "wall_post"
                    };

                    //Send Notification.
                    $.post("/notifications/create", data, r => {
                        $("#post").val("");
                        $(".flash_msg").show();

                        setTimeout(() => {
                            $(".flash_msg").fadeOut();
                        }, 20000);
                    });
                }
            });
        }
    });

    function load_wallposts() {
        var data = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            channel_owner_id: <?= $channel_owner_id ?>
        };

        $.post("/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/loaduserposts", data, r => {
            $(".userwall_posts").html(r);
        });
    }
</script>