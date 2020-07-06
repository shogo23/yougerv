<?php
	//Scss path for this view file /src/sess/pages/login.scss
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="login_contents">
	<div class="contents">
		<h1>Login</h1>
		<div class="login">
			<?php if ($validation !== null && $validation->getError('username')): ?>
				<div class="err errors alert alert-danger">
					<?= $validation->getError('username') ?>
				</div>
			<?php elseif ($validation !== null && $validation->getError('password')): ?>
				<div class="err errors alert alert-danger">
					<?= $validation->getError('password') ?>
				</div>
			<?php endif; ?>
			<form method="post" accept-charset="utf-8">
				<?= csrf_field() ?>
				<div class="text_field">
					<i class="fas fa-user"></i>
					<input type="text" name="username" id="username" placeholder="Username" autocomplete="off" />
				</div>
				<div class="text_field">
					<i class="fas fa-key"></i>
					<input type="password" name="password" id="password" placeholder="Password" />
				</div>
				<div class="btn_container">
					<button type="submit" class="btn btn-primary btn-block">Login</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	_resize();

	$(window).resize(() => {
		_resize();
	});

	function _resize() {
		var height = $(window).outerHeight();
		var section = $(".login_contents .contents").height();
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height >= section) {
			$(".login_contents").css({
				height: new_height + "px"
			});
		} else {
			$(".login_contents").css({
				height: "auto"
			});
		}
	}
</script>

<?= $this->endSection() ?>
