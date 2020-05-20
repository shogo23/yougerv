<?php
    use App\Assets\Assets;
    $assets = new Assets();
?>

<?php if (count($comments) > 0): ?>
    <div class="total_comments">Comments: <?= $total_comments ?></div>
    <ul id="comments_results">
        <?php foreach ($comments as $comment): ?>
            <li>
                <div class="thumb">
                    <img src="<?= $assets->get_thumbnail($comment['user_id']) ?>" />
                </div>
                <div class="comm">
                    <div class="com_content">
                        <div class="commentor">
                            <span class="name"><?= $assets->get_fullname($comment['user_id']) ?></span> 
                            <span class="date"><?= $assets->when($comment['created_at']) ?></span>
                        </div>
                        <?= $comment['comment'] ?>
                    </div>
                </div>
                <div class="opt">
                    <?php if ($comments_model->is_comment_author($assets->getUserId($comment['user_id']), $comment['id'])): ?>
                        <span class="delete_btn" onclick="javascript: _delete(<?= $comment['id'] ?>)"><i class="far fa-trash-alt"></i><span>
                    <?php else: ?>
                        &nbsp;
                    <?php endif; ?>
                </div>
                <div class="clear"></div>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        checkResults();

        function checkResults() {
            var total_results = <?= $total_comments ?>;
            var current_results = $("#comments_results li").length;

            if (total_results > current_results) {
                $(".comments_loader").show();
            } else {
                $(".comments_loader").hide();
            }
        }
    </script>
<?php else: ?>
    
    <div class="no_comments">
        There are not comments.
    </div>

<?php endif; ?>