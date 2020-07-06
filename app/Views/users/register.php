<?php
	//Scss path for this view file /src/sess/pages/register.scss
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="register_contents">
	<div class="contents">
		<h1>Register</h1>
		<?php if ($validation !== null && $validation->getErrors()): ?>
			<div class="errors alert alert-danger">
				<ul>
					<?php foreach ($validation->getErrors() as $error): ?>
						<li><?= $error ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<div class="fields">
			<form method="post" accept-charset="utf-8">
				<?= csrf_field() ?>
				<div>
					<label for="username">Username:</label>
					<input type="text" name="username" id="username" autocomplete="off" <?= ($request['username']) ? 'value="' . $request['username'] . '"' : '' ?> />
				</div>
				<div>
					<label for="password">Password:</label>
					<input type="password" name="password" id="password" <?= ($request['password']) ? 'value="' . $request['password'] . '"' : '' ?> />
				</div>
				<div>
					<label for="password_confirm">Repeat Password:</label>
					<input type="password" name="password_confirm" id="password_confirm" <?= ($request['password_confirm']) ? 'value="' . $request['password_confirm'] . '"' : '' ?> />
				</div>
				<div>
					<label for="firstname">Firstname:</label>
					<input type="text" name="firstname" id="firstname" autocomplete="off" <?= ($request['firstname']) ? 'value="' . $request['firstname'] . '"' : '' ?> />
				</div>
				<div>
					<label for="lastname">Lastname:</label>
					<input type="text" name="lastname" id="lastname" autocomplete="off" <?= ($request['lastname']) ? 'value="' . $request['lastname'] . '"' : '' ?> />
				</div>
				<div>
					<label for="lastname">Nickname:</label>
					<input type="text" name="nickname" id="nickname" autocomplete="off" <?= ($request['nickname']) ? 'value="' . $request['nickname'] . '"' : '' ?> />
				</div>
				<div class="sub_container">
					<button type="submit" class="btn btn-primary">Register</button>
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
		var section = $(".register_contents .contents").height();
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height >= section) {
			$(".register_contents .contents").css({
				height: new_height + "px"
			});
		} else {
			$(".register_contents .contents").css({
				height: "auto"
			});
		}
	}
</script>
<?= $this->endSection() ?>
