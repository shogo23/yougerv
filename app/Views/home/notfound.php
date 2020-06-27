<?php
	//Scss path for this view file /src/sess/pages/noutfound.scss
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="notfound">
	<div class="contents">
		<div class="img">
			<img src="/img/404.png" />
		</div>
		<div class="msg">
			The page you requestes was not found.
		</div>
	</div>
</div>

<script>

	_notfound_page();

	$(window).resize(() => {
		_notfound_page();
	});

	function _notfound_page() {
		var height = $(window).height();
		var watch = $(".notfound .contents").height();
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height > watch) {
			$(".notfound .contents").css({
				height: new_height + "px"
			});
		}
	}
</script>

<?= $this->endSection() ?>
