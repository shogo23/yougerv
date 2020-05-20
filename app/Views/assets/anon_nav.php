<?php
	//Scss path for this view file /src/sess/partials/nav.scss
	use App\Assets\Assets;

	$assets = new Assets();
?>

<?php if (!$assets->hasSession()) :?>
<nav class="main_nav">
	<div class="nav_content">
		<div class="logo_container">
			<a href="/">YouGerv</a>
		</div>
		<div class="search_container">
			<div class="text_input">
				<form id="the_search" method="get">
					<input type="text" name="s" class="search" placeholder="Search Videos Here" autocomplete="off" />
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
				<input type="text" name="s" class="search_m" placeholder="Search Videos Here" autocomplete="off" />
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

<?php elseif ($assets->hasSession()): ?>
<nav class="main_nav">
	<div class="nav_content">
		<div class="logo_container">
			<a href="/">YouGerv</a>
		</div>
		<div class="search_container">
			<div class="text_input">
				<form id="the_search" method="get">
					<input type="text" name="s" class="search" placeholder="Search Videos Here" autocomplete="off" />
					<i class="fas fa-search search-btn"></i>
				</form>
			</div>
		</div>
		<div class="links_container2">
			<ul class="lg">
				<li><a href="/upload"><i class="fas fa-upload"></i> Upload</a></li>
				<li><img id="thumbnail_toggler" src="<?= $assets->get_thumbnail() ?>" /></li>
				<li><span id="nickname_toggler"><?= $assets->get_nickname(); ?></span></li>
				<li><span id="user_menu_toggler">▼</span></li>
			</ul>
			<ul class="sm">
				<li><i class="fas fa-search search-btn-toggler"></i></li>
				<li><a href="/upload"><i class="fas fa-upload"></i></a></li>
				<li><img id="thumbnail_toggler2" src="<?= $assets->get_thumbnail() ?>" /></li>
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
				<input type="text" name="s" class="search_m" placeholder="Search Videos Here" autocomplete="off" />
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
				<li><a href="/"><i class="fas fa-upload"></i> Upload Video</a></li>
				<li><a href="/"><i class="fas fa-users"></i> My Subscribers</a></li>
				<li><a href="/"><i class="fas fa-user-circle"></i> My Subscriptions</a></li>
				<li><a href="/"><i class="fas fa-user-cog"></i> Account Settings</a></li>
				<li><a href="/logout">Logout</a></li>
			</ul>
		</div>
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
</script>
<?php endif; ?>
