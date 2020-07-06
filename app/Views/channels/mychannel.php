<?php
	//Scss path for this view file /src/sess/pages/mychannel.scss

	use App\Assets\Assets;
	use Config\Services;

	$assets  = new Assets();
	$request = Services::request();

?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="mychannel_container">
	<div class="contents">
		<div class="user_details">
			<div class="the_contents">
				<div class="picture">
					<img src="<?= $assets->get_picture($user_details['user_id']) ?>" />
				</div>
				<div class="details">
					<div class="fullname"><?= $user_details['firstname'] . ' ' . $user_details['lastname'] ?></div>
					<div class="joined">Joined at: <?= $assets->when($user_details['created_at']) ?></div>
				</div>
				<div class="clear"></div>
			</div>

			<nav class="mychannel_nav">
				<ul>
					<li><span id="mywall" class="_nav">My Wall</span></li>
					<li><span id="myvideos" class="_nav">My Videos</span></li>
					<li><span id="mysubscribers" class="_nav">My Subscribers</span></li>
					<li><span id="mysubscription" class="_nav">My Subscription</span></li>
				</ul>
			</nav>

			<div class="mychannel_nav_mini btn-group">
				<button type="button" id="nav_mini" class="btn btn-lg btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					&nbsp;
				</button>
				<div class="dropdown-menu">
					<a class="dropdown-item" onclick="javascript: _nav_mini_link('mywall')" href="javascript:">My Wall</a>
					<a class="dropdown-item" onclick="javascript: _nav_mini_link('myvideos')" href="javascript:">My Videos</a>
					<a class="dropdown-item" onclick="javascript: _nav_mini_link('mysubscribers')" href="javascript:">My Subscribers</a>
					<a class="dropdown-item" onclick="javascript: _nav_mini_link('mysubscription')" href="javascript:">My Subscription</a>
				</div>
			</div>
		</div>
		<div class="page"></div>
	</div>
</div>

<script>
	<?php if ($request->getGet('page')) : ?>
		var page_active = "<?= $request->getGet('page') ?>";
	<?php else : ?>
		var page_active = "mywall";
	<?php endif; ?>

	_active();

	_resize();

	$(window).on("click change resize", () => {
		_resize();
	});

	$(".mychannel_container").on("click change resize", () => {
		_resize();
	});

	$("#mywall").on("click", () => {
		page_active = "mywall";
		_active();
	});

	$("#myvideos").on("click", () => {
		page_active = "myvideos";
		_active();
	});

	$("#mysubscribers").on("click", () => {
		page_active = "mysubscribers";
		_active();
	});

	$("#mysubscription").on("click", () => {
		page_active = "mysubscription";
		_active();
	});


	function _nav_mini_link(link) {
		page_active = link;
		_active();
	}

	function _active() {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			user_id: <?= $user_details['user_id'] ?>
		};

		switch (page_active) {
			case "myvideos":
				var page = 'myvideos';
				var url = '/mychannel?page=myvideos';
				$("#nav_mini").html("My Videos");
			break;

			case "mysubscribers":
				var page = 'mysubscribers';
				var url = '/mychannel?page=mysubscribers';
				$("#nav_mini").html("My Subscribers");
			break;

			case "mysubscription":
				var page = 'mysubscription';
				var url = '/mychannel?page=mysubscription';
				$("#nav_mini").html("My Subscriptions");
			break;

			default:
				var page = 'mywall';
				var url = '/mychannel';
				$("#nav_mini").html("My Wall");
		}

		$("._nav").each((i) => {
			i + 1;

			$("._nav:nth-child(" + i + ")").removeClass("mychannel_nav_active");
		});

		$.post("/mychannel/" + page, data, function(r) {
			$("#" + page_active).addClass("mychannel_nav_active");
			history.pushState("", "", url);
			$(".page").html(r);
			_resize();
		});
	}

	function _resize() {
		var height = $(window).outerHeight();
		var section = $(document).height();
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height >= section) {
			$(".mychannel_container").css({
				height: new_height + "px"
			});
		} else {
			$(".mychannel_container").css({
				height: "auto"
			});
		}
	}
</script>

<?= $this->endSection() ?>
