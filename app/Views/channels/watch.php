<?php
	//Scss path for this view file /src/sess/pages/watch.scss

	use App\Assets\Assets;

	$assets = new Assets();
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="watch_container">
	<div class="left">
		<div class="contents">
			<div class="video">
				<video id="player" height="400" playsinline controls data-poster="/vids/thumbs/<?= $data['slug'] ?>.jpg">
					<source src="/videostream/<?= $data['filename'] ?>?key=<?= $secure_video_key ?>" type="video/mp4" />
				</video>
				<div class="clear"></div>
				<div class="details">
					<h1><?= $data['title'] ?></h1>
					<div class="upper_details">
						<div class="uploader">
							<ul>
								<li>
									<a href="/channel/<?= $data['user_id'] . '/' . $data['firstname'] . '_' . $data['lastname'] ?>"><img src="<?= $assets->get_thumbnail($data['user_id']) ?>" /></a>
								</li>
								<li>Uploded by: <a href="/channel/<?= $data['user_id'] . '/' . $data['firstname'] . '_' . $data['lastname'] ?>"><?= $data['firstname'] . ' ' . $data['lastname'] ?></a></li>
							</ul>
						</div>
						<div class="stats">
							<ul>
								<?php if (! $assets->hasSession()): ?>
									<li><i data-toggle="modal" data-target="#modalAlert" class="far fa-thumbs-up" ></i> <?= $data['likes'] ?></li>
								<?php else: ?>
									<li><i id="like" class="far fa-thumbs-up"></i> <span id="likes"><?= $data['likes'] ?></span></li>
								<?php endif; ?>

								<li><i class="fas fa-tv"></i> <?= $data['views'] ?></li>
							</ul>
						</div>
						<div class="clear"></div>
					</div>
					<div class="upload_date">Uploaded: <?= $assets->when($data['created_at']) ?></div>
					<div class="desc">
						<?= $data['description'] ?>
					</div>
					<div class="comments">
						<h2>Comments</h2>
						<div class="field">
							<?php if ($assets->hasSession()): ?>
								<div class="comment_form">
									<ul>
										<li><img src="<?= $assets->get_thumbnail() ?>" /></li>
										<li>
											<div class="comment_fm">
												<textarea id="comment"></textarea>
											</div>
											<div class="btns">
												<button type="button" id="cancel" class="btn btn-danger">Cancel</button> <button type="button" id="postcomment" class="btn btn-primary">Comment</button>
											</div>
										</li>
										<li class="clear"></li>
									</ul>
								</div>
							<?php else: ?>
								<a href="/login?redirect=watch/<?= $data['slug'] ?>">Login</a> or <a href="/register">Register</a> to comment.
							<?php endif; ?>
						</div>
						<div class="comment_contents">
							Coments here.
						</div>
						<div class="comments_loader">
							<button type="button" id="loadmore" class="btn btn-primary btn-block">Read More</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="right">
		<div class="contents">
			<h4>Latest Videos</h4>
			<ul>
				<?php foreach ($latest_videos as $video): ?>
					<li>
						<div class="thumb">
							<a href="/watch/<?= $video['slug'] ?>"><img src="/vids/thumbs/<?= $video['slug'] ?>.jpg" /></a>
							<div class="length"><?= $video['length'] ?></div>
						</div>
						<div class="title"><a href="/watch/<?= $video['slug'] ?>" title="<?= $video['title'] ?>"><?= $assets->reduce_title($video['title']) ?></a></div>
						<div class="uploader">
							<a href="/channel/<?= $video['user_id'] . '/' . $video['firstname'] . '_' . $video['lastname'] ?>"><?= $video['firstname'] . ' ' . $video['lastname'] ?></a>
						</div>
						<div class="uploaded_date"><?= $assets->when($video['created_at']) ?></div>
						<div class="clear"></div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
	
	<?php if (! $assets->hasSession()): ?>
		<!-- Modal -->
		<div class="modal fade" id="modalAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalCenterTitle">Requires Login</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						You need to Login to like videos.
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="login">Login</button>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>

<script>
	var page = 50;
	var elm = document.querySelector(".desc");

	new Plyr('#player', {autoplay: false});

	load_comments();

	<?= $assets->hasSession() ? 'stretchTextarea("#comment");' : ''; ?>

	$("#comment").on("keyup change input", () => {
		if ($("#comment").val().length > 0) {
			$(".btns").show();
		} else {
			$(".btns").hide();
		}
	});

	$(".comment_fm").on("click", () => {
		if ($("#comment").html().length == 0) {
			$("#comment").focus();
		} else {
			$("#comment").focus(() => {
				var c = $("#comment").html();
				$("#comment").html("").html(c);
			});
		}
	});

	$("#postcomment").on("click", () => {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			user_id: <?= $assets->getUserId($assets->getSession('username')) ?>,
			video_id: <?= $data['video_id'] ?>,
			slug: "<?= $data['slug'] ?>",
			comment: $("#comment").val()
		};

		$.post("/comments/postcomment", data, r => {
			if (r == "ok") {
				var data = {
					"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
					video_user_id: <?= $user_id ?>,
					comentor_id: <?= $assets->getUserId($assets->getSession('username')) ?>,
					notification_type: "video_comment",
					slug: "<?= $data['slug'] ?>",
				};

				//Send notification.
				$.post("/notifications/create", data, () => {
					_cancel();
					load_comments();
				});
			}
		});
	})

	$("#cancel").on("click", () => {
		_cancel();
	});

	$("#loadmore").on("click", () => {
		page = page + 5;
		load_comments();
	});

	$("#login").on("click", () => {
		location = "/login?redirect=watch/<?= $data['slug'] ?>"
	});

	$("#like").on("click", () => {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			video_id: <?= $data['video_id'] ?>,
			slug: "<?= $data['slug'] ?>"
		};

		$.post("/like", data, r => {
			if (r) {
				$("#likes").html(r);
			}
		});
	});

	elm.addEventListener("click", function(e) {
		if (e.srcElement.localName == "a") {
			e.preventDefault();
			location = "/out?redirect=" + e.target.href;
		}
	});

	function _cancel() {
		$("#comment").val("");
		$(".btns").hide();
	}

	function load_comments() {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			video_id: <?= $data['video_id'] ?>,
			slug: "<?= $data['slug'] ?>",
			page: page
		};

		$.post("/comments", data, r => {
			$(".comment_contents").html(r);
		});
	}

	function _delete(id) {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			video_id: <?= $data['video_id'] ?>,
			slug: "<?= $data['slug'] ?>",
			comment_id: id
		};

		$.post("/comments/delete", data, r => {
			if (r == "ok") {
				load_comments();
			}
		});
	}
</script>

<?= $this->endSection() ?>
