<?php
	//Scss path for this view file /src/sess/pages/out.scss
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="out_page">
	<div class="contents">
		<div class="warning">
			<div class="img">
				<img src="/img/warning2.png" />
			</div>
			<div class="msg"><span class="link"><?= urldecode($link) ?></span> is not part of this website. It could be dangerous to proceed.</div>
			<div class="btns">
				<button type="button" id="back" class="btn btn-primary">Go Back</button> <a class="btn btn-danger" href="<?= urldecode($link) ?>">Proceed</a>
			</div>
		</div>
	</div>
</div>

<script>
	
	_out_page();

	$("#back").on("click", () => {
		window.history.back();
	});

	function _out_page() {
		var height = $(window).height();
		var watch = $(".out_page .contents").height();
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height > watch) {
			$(".out_page .contents").css({
				height: new_height + "px"
			});
		}
	}
</script>

<?= $this->endSection() ?>
