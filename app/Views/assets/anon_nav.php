<?php
	//Scss path for this view file /src/sess/partials/nav.scss
	use App\Assets\Assets;

	$assets  = new Assets();
	$request = \Config\Services::request();
?>

<?php if (! $assets->hasSession()) :?>
<nav class="main_nav">
	<div class="nav_content">
		<div class="logo_container">
			<a href="/">YouGerv</a>
		</div>
		<div class="search_container">
			<div class="text_input">
				<form id="the_search" action="/search" method="get">
					<input type="text" name="s" class="search" placeholder="Search Videos Here" autocomplete="off" <?= $request->getGet('s') ? 'value="' . $request->getGet('s') . '"' : ''; ?> />
					<i class="fas fa-search search-btn"></i>
				</form>
			</div>
		</div>
		<div class="links_container">
			<ul class="lg">
				<li><a href="/upload"><i class="fas fa-upload"></i> Upload</a></li>
				<li><a href="/login"><i class="fas fa-user"></i> Login</a></li>
				<li><a href="/register"><i class="fas fa-user-plus"></i> Register</a></li>
			</ul>
			<ul class="sm">
				<li><i class="fas fa-search search-btn-toggler"></i></li>
				<li><a href="/upload"><i class="fas fa-upload"></i></a></li>
				<li><a href="/login"><i class="fas fa-user"></i></a></li>
				<li><a href="/register"><i class="fas fa-user-plus"></i></a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</nav>
<div class="search_floating">
	<div class="contents">
		<div class="text_input">
			<form id="the_search" method="get">
				<input type="text" name="s" class="search_m" placeholder="Search Videos Here" autocomplete="off" <?= $request->getGet('s') ? 'value="' . $request->getGet('s') . '"' : ''; ?> />
				<i class="fas fa-search search-btn-toggle"></i>
			</form>
		</div>
	</div>
</div>

<script>
	var toggle_sm_search = false;

	$(".search-btn-toggler").on("click", function() {
		if (!toggle_sm_search) {
			toggle_sm_search = true;
			$(".search_floating").slideDown();
		} else {
			toggle_sm_search = false;
			$(".search_floating").slideUp();
		}
	});

	$(".search-btn").on("click", function() {
		$("#the_search").submit();
	});

	$(window).on("click", function(e) {
		if (!e.target.matches(".search-btn-toggler") && !e.target.matches(".search_floating") && !e.target.matches(".search_floating [type=text]") && !e.target.matches(".search_floating .search-btn-toggle")) {
			toggle_sm_search = false;
			$(".search_floating").slideUp();
		}
	});
</script>

<?php elseif ($assets->hasSession()) : ?>
<nav class="main_nav">
	<div class="nav_content">
		<div class="logo_container2">
			<a href="/">YouGerv</a>
		</div>
		<div class="search_container">
			<div class="text_input">
				<form id="the_search" action="/search" method="get">
					<input type="text" name="s" class="search" placeholder="Search Videos Here" autocomplete="off" <?= $request->getGet('s') ? 'value="' . $request->getGet('s') . '"' : ''; ?> />
					<i class="fas fa-search search-btn"></i>
				</form>
			</div>
		</div>
		<div class="links_container2">
			<ul class="lg">
				<li><a href="/upload"><i class="fas fa-upload"></i> Upload</a></li>
				<li><img id="thumbnail_toggler" src="<?= $assets->get_thumbnail() ?>" /></li>
				<li><span id="nickname_toggler"><?= $assets->get_nickname(); ?></span></li>
				<li>
					<span class="bell" id="notification1"><i class="fas fa-bell"></i></span>
					<span class="noti_num1"></span>
				</li>
				<li><span id="user_menu_toggler">▼</span></li>
			</ul>
			<ul class="sm">
				<li><i class="fas fa-search search-btn-toggler"></i></li>
				<li><a href="/upload"><i class="fas fa-upload"></i></a></li>
				<li><img id="thumbnail_toggler2" src="<?= $assets->get_thumbnail() ?>" /></li>
				<li>
					<span class="bell" id="notification2"><i class="fas fa-bell"></i></span>
					<span class="noti_num2"></span>
				</li>
				<li><span id="user_menu_toggler2">▼</span></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</nav>
<div class="search_floating search_floating2">
	<div class="contents">
		<div class="text_input">
			<form id="the_search" method="get">
				<input type="text" name="s" class="search_m" placeholder="Search Videos Here" autocomplete="off" <?= $request->getGet('s') ? 'value="' . $request->getGet('s') . '"' : ''; ?> />
				<i class="fas fa-search search-btn-toggle"></i>
			</form>
		</div>
	</div>
</div>
<div class="user_menu">
	<div class="contents">
		<div class="top">
			<ul>
				<li><img src="<?= $assets->get_thumbnail() ?>" /></li>
				<li><?= $assets->get_fullname() ?></li>
			</ul>
		</div>
		<div class="bottom">
			<ul>
				<li><a href="/mychannel"><i class="fas fa-tv"></i> My Channel</a></li>
				<li><a href="/upload"><i class="fas fa-upload"></i> Upload Video</a></li>
				<li><a href="/mychannel?page=myvideos"><i class="fas fa-video"></i> My Videos</a></li>
				<li><a href="/mychannel?page=mysubscribers"><i class="fas fa-users"></i> My Subscribers</a></li>
				<li><a href="/mychannel?page=mysubscription"><i class="fas fa-user-circle"></i> My Subscriptions</a></li>
				<li><a href="/accountsettings"><i class="fas fa-user-cog"></i> Account Settings</a></li>
				<li><a href="/logout">Logout</a></li>
			</ul>
		</div>
	</div>
</div>

<div class="user_notifications">
	<div class="notification_list"></div>
	<div class="btn_container">
		<span id="clear_notifications">Clear Notifications</span>
	</div>
</div>

<script>
	var toggle_sm_search = false;
	var user_menu_toggle = false;

	$(".search-btn-toggler").on("click", function() {
		if (!toggle_sm_search) {
			toggle_sm_search = true;
			$(".search_floating").slideDown();
		} else {
			toggle_sm_search = false;
			$(".search_floating").slideUp();
		}
	});

	$(".search-btn").on("click", function() {
		$("#the_search").submit();
	});

	$("#user_menu_toggler, #user_menu_toggler2, #thumbnail_toggler, #thumbnail_toggler2, #nickname_toggler").on("click", function() {
		if (!user_menu_toggle) {
			user_menu_toggle = true;
			$(".user_menu").fadeIn();
		} else {
			user_menu_toggle = false;
			$(".user_menu").fadeOut();
		}
	});

	$(window).on("click", function(e) {
		if (!e.target.matches(".search-btn-toggler") && !e.target.matches(".search_floating") && !e.target.matches(".search_floating [type=text]") && !e.target.matches(".search_floating .search-btn-toggle")) {
			toggle_sm_search = false;
			$(".search_floating").slideUp();
		}
	});

	$(window).on("click", function(e) {
		if (!e.target.matches("#user_menu_toggler") && !e.target.matches(".user_menu") && !e.target.matches("#user_menu_toggler2") && !e.target.matches(".user_menu a") && !e.target.matches("#thumbnail_toggler") && !e.target.matches("#thumbnail_toggler2") && !e.target.matches("#nickname_toggler")) {
			user_menu_toggle = false;
			$(".user_menu").fadeOut();
		}
	});

	$(window).on("click", function(e) {
		if (!e.target.matches("#notification1 i") && !e.target.matches("#notification2 i") && !e.target.matches(".user_notifications") && !e.target.matches(".notification_list") && !e.target.matches(".notification_list ul") && !e.target.matches(".notification_list ul li") && !e.target.matches(".notification_list ul li a") && !e.target.matches(".notification_list ul li a img")) {
			notification_toggle = false;
			$(".user_notifications").fadeOut(function() {
				notification_toggle = false;
				$(".user_notifications").fadeOut();
			});
		}
	});

	$("#clear_notifications").on("click", function() {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		};

		$.post("/notifications/clear", data, function(r) {
			$(".noti_num1, .noti_num2").hide().text("");
		});
	});

	$(document).ready(() => {
		var notification_toggle = false;

		_resize_notification();

		$(window).resize(() => {
			_resize_notification();
		});

		var interval = setInterval(() => {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
			};

			$.post("/notifications/check", data, r => {
				if (r > 0 && r <= 20) {
					$(".noti_num1, .noti_num2").show().text(r);
				} else if (r > 20) {
					$(".noti_num1, .noti_num2").show().text("20+");
				} else if (r <= 0) {
					$(".noti_num1, .noti_num2").hide().text("");
				}
			});
		}, 3000);

		var notifications = new Promise((resolve, reject) => {
			$("#notification1, #notification2").on("click", () => {
				var data = {
					"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
				};

				if (!notification_toggle) {
					notification_toggle = true;
					$(".user_notifications").fadeIn();
				} else {
					notification_toggle = false;
					$(".user_notifications").fadeOut(function() {
						notification_toggle = false;
						$(".user_notifications").fadeOut();
					});
				}

				$.post("/notifications/update", data, r => {
					if (r == "ok") {
						$(".noti_num1, .noti_num2").hide().text("");
						resolve();
					}
				});
			});
		});

		notifications.then(() => {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
			};

			$.post("/notifications/get", data, r => {
				$(".user_notifications .notification_list").html(r);
			});
		});
	});

	function _resize_notification() {
		var height = $(window).height();
		var new_height = height - 200;

		$(".notification_list").css("height", new_height + "px");
	}
</script>
<?php endif; ?>
