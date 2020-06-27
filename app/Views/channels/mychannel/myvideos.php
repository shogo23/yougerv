<?php
	use App\Assets\Assets;

	$assets = new Assets();
?>

<?php if (count($videos) <= 0) : ?>
<div class="no_myvideos alert alert-info">You don't have videos at this time.</div>
<?php else : ?>

<div class="blackscreen">
	<div class="video_container">
		<div class="content_loader">
			
		</div>
	</div>
</div>
<div class="myvideos">
	<h1>My Videos</h1>
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
		</ul>
	</div>
</div>

<script>
	var fetching_data = false;
	var offset = 10;
	var line_height = 0;

	_resize_myvideos();

	$(window).resize(() => {
		_resize_myvideos();
	});

	$(window).on("scroll" , () => {
		if ($(window).scrollTop() >= $(document).height() - $(window).height() - 200 && !fetching_data) {
			fetching_data = true;

			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				user_id: <?= $user_id ?>,
				offset: offset
			};

			$.post('/mychannel/myvideos/loadmorevideos', data, (r) => {
				$(".videos ul").append(r);
				fetching_data = false;
				offset += 10;
			});
		}
	});

	$(window).on("click", e => {
		if (e.target.matches(".blackscreen") || e.target.matches(".video_container")) {
			_close_myvideo();
		}
	});

	function _edit(video_id) {
		$(".blackscreen").fadeIn();
		$("body").css({
			overflow: "hidden"
		});

		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			video_id: video_id
		};

		$(".content_loader").css({
			"line-height": line_height + "px",
			"text-align": "center"
		}).html('<img src="/img/ajax_loader.gif" />');

		$.post("/mychannel/myvideos/editdetails", data, (r) => {
			$(".content_loader").css({
				"line-height": "normal",
				"text-align": "left"
			}).html(r);
		});
	}

	function _resize_myvideos() {
		var height = $(window).height();
		var new_height = height - 200;
		line_height = new_height;

		$(".content_loader").css({
			"height": new_height + "px"
		});
	}

	function _close_myvideo() {
		$(".blackscreen").fadeOut(500, () => {
			$(".content_loader").html("");
			$("body").css({
				overflow: "auto"
			});
		});
	}

	function _delete_video(video_id) {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			video_id: video_id
		};

		$.post("/mychannel/myvideos/delete", data, r => {
			if (r == "ok") {
				$(".videos ul li#video_" + video_id).fadeOut();
			}
		});
	}

	//Change video title has been changed onces edit saved from editvideodetails.php.
	function apply_changes(video_id, title) {
		$(".videos ul li#video_" + video_id + " .details .title a").html(title);
	}
</script>

<?php endif; ?>
