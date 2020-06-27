<?php
	use App\Assets\Assets;

	$assets = new Assets();
?>

<?php if ($walls) : ?>

<ul>
	<?php foreach ($walls as $wall) : ?>
		<li id="id_<?= $wall['id'] ?>">
			<div class="thumb">
				<img src="<?= $assets->get_thumbnail($wall['user_id']) ?>" />
			</div>
			<div class="the_post">
				<div class="post_content">
					<div class="post_date">Posted at: <?= $assets->when($wall['created_at']) ?></div>
					<div class="post_msg">
						<?= $wall['post'] ?>
					</div>
				</div>
				<div class="opt" onclick="javascript: _delete(<?= $wall['id'] ?>)">
					<i class="fas fa-trash"></i>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</li>
	<?php endforeach; ?>
</ul>

<script>
	var offset = 10;

	$(".mywall_posts ul li").each((i) => {
		i = i + 1;

		var post_height = $(".mywall_posts ul li:nth-child(" + i + ")").height();
		var new_height = (post_height / 2) - 10;

		$(".mywall_posts ul li:nth-child(" + i + ") .the_post .opt").css({
			"margin-top": new_height + "px"
		});
	});

	$(window).on("scroll", () => {
		if ($(window).scrollTop() >= $(document).height() - $(window).height()) {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				user_id: <?= $user_id ?>,
				offset: offset
			}

			$.post("/mychannel/mywall/moreposts", data, r => {
				$(".mywall_posts ul").append(r);
				offset += 10;
			});
		}
	});

	function _delete(id) {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			user_id: <?= $user_id ?>,
			id: id
		}

		$.post("/mychannel/mywall/deletepost", data, r => {
			if (r == "ok") {
				$("#id_" + id).fadeOut();
			}
		});
	}
</script>

<?php else : ?>
	<div class="nopost alert alert-danger">
		There are no posts at this time.
	</div>
<?php endif; ?>
