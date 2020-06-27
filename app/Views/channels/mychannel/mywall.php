<div class="mywall">
    <div class="contents">
        <div class="form">
            <div class="field">
                <label for="post">Write your Post</label>
                <textarea id="post"></textarea>
            </div>
            <div class="btn_container">
                <button type="button" id="send" class="btn btn-primary">Post</button>
            </div>
        </div>
        <div class="mywall_posts">
            
        </div>
    </div>
</div>

<script>

    stretchTextarea("#post");

    load_wallposts();

    $("#send").on("click", () => {
        if ($("#post").val() !== "") {
            var data = {
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                user_id: <?= $user_id ?>,
                "post": $("#post").val()
            }

            $.post("/mychannel/mywall/creatwallepost", data, r => {
                if (r == "ok") {
                    var data = {
                        "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
                        notification_type: "my_wallpost"
                    };

                    //Send notifications.
                    $.post("/notifications/create", data, () => {
                        $("#post").val("");
                        load_wallposts();
                    });
                }
            });
        }
    });

    function load_wallposts() {
        var data = {
            "<?= csrf_token() ?>": "<?= csrf_hash() ?>",
            user_id: <?= $user_id ?>
        };

        $.post("/mychannel/mywall/getposts", data, r => {
            $(".mywall_posts").html(r);
        });
    }
</script>