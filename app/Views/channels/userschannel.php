<?php
	//Scss path for this view file /src/sess/pages/userschannel.scss

	use App\Assets\Assets;

	$assets = new Assets();
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="userschannel">
	<div class="contents">
		<div class="user_details">
			<div class="the_contents">
				<div class="picture">
					<img src="<?= $assets->get_picture($user_details['user_id']) ?>" />
				</div>
				<div class="details">
					<div class="fullname"><?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?></div>
					<div class="joined">Joined at: <?= $assets->when($user_details['created_at']) ?></div>
					<div class="subscription">
						<span id="subscribe"></span>
					</div>
				</div>
				<div class="clear"></div>
			</div>

			<nav class="userchannel_nav">
				<ul>
					<li><span id="userwall" class="_nav"><?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?>'s Wall</span></li>
					<li><span id="uservideos" class="_nav"><?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?>'s Videos</span></li>
				</ul>
			</nav>

			<div class="userchannel_nav_mini btn-group">
				<button type="button" id="nav_mini" class="btn btn-lg btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					&nbsp;
				</button>
				<div class="dropdown-menu">
					<a class="dropdown-item" onclick="javascript: _nav_mini_link('userwall')" href="javascript:"><?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?>'s My Wall</a>
					<a class="dropdown-item" onclick="javascript: _nav_mini_link('uservideos')" href="javascript:"><?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?>'s Videos</a>
				</div>
			</div>
		</div>
		<div class="page"></div>
	</div>
</div>

<script>
	var page_active = "userwall";
	<?php if ($assets->hasSession()) : ?>
		<?= ! $is_subscribed ? 'var is_subscribed = false' : 'var is_subscribed = true'; ?>

	load_subscribe_btn();
	<?php endif; ?>

	_active();

	_resize();

	$(window).on("click change resize", () => {
		_resize();
	});

	$("#userwall").on("click", () => {
		page_active = "userwall";
		_active();
	});

	$("#uservideos").on("click", () => {
		page_active = "uservideos";
		_active();
	});

	$("#subscribe").on("click", () => {
		if (!is_subscribed) {
			is_subscribed = true;
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				channel_owner_id: <?= $channel_owner_id ?>,
				subscribe: 1
			};

			$("#subscribe").removeClass("btn btn-outline-danger");
			$("#subscribe").addClass("btn btn-outline-info").html("Unsubscribe");
		} else {
			is_subscribed = false;
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				channel_owner_id: <?= $channel_owner_id ?>,
				subscribe: 0
			};

			$("#subscribe").removeClass("btn btn-outline-info");
			$("#subscribe").addClass("btn btn-outline-danger").html("Subscribe");
		}

		$.post("/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/subscribe", data, () => {
			if (is_subscribed) {
				var data = {
					"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
					channel_owner_id: <?= $channel_owner_id ?>,
					channel_owner_firstname: "<?= $firstname ?>",
					channel_owner_lastname: "<?= $lastname ?>",
					notification_type: "subscribe"
				};

				$.post("/notifications/create", data, r => {
					console.log(r);
				});
			}
		});
	});

	function _nav_mini_link(link) {
		page_active = link;
		_active();
	}

	function _active() {
		if (page_active == "userwall") {
			var page = "userwall";
			$("#nav_mini").html("<?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?>'s Wall");
		} else if (page_active == "uservideos") {
			var page = "uservideos";
			$("#nav_mini").html("<?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?>'s Videos");
		}

		$("._nav").each((i) => {
			i + 1;

			$("._nav:nth-child(" + i + ")").removeClass("userchannel_nav_active");
		});

		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			user_id: <?= $user_details['user_id'] ?>
		};

		$.post("/channel/<?= $channel_owner_id . '/' . $user_details['firstname'] . '_' . $user_details['lastname'] ?>/" + page, data, r => {
			$(".page").html(r)
			_resize();
		})

		$("#" + page_active).addClass("userchannel_nav_active");
	}

	function _resize() {
		var height = $(window).outerHeight();
		var section = $(document).height();
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height >= section) {
			$(".userschannel").css({
				height: new_height + "px"
			});
		} else {
			$(".userschannel").css({
				height: "auto"
			});
		}
	}

	<?php if ($assets->hasSession()) : ?>
	function load_subscribe_btn() {
		if (!is_subscribed) {
			$("#subscribe").removeClass("btn btn-outline-info");
			$("#subscribe").addClass("btn btn-outline-danger").html("Subscribe");
		} else {
			$("#subscribe").removeClass("btn btn-outline-danger");
			$("#subscribe").addClass("btn btn-outline-info").html("Unsubscribe");
		}
	}
	<?php endif; ?>
</script>

<?= $this->endSection() ?>
