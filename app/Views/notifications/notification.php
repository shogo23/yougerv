<?php
	use App\Assets\Assets;

	$assets = new Assets();
?>

<ul>
	<?php foreach ($notifications as $notification) : ?>
		<?php $type = json_decode($notification['notification'], true)['type'] ?>


		<?php if ($type === 'video_upload') : ?>
			<?php
				$n                 = json_decode($notification['notification'], true);
				$video_uploader_id = $n['video_uploader_id'];
				$slug              = $n['slug'];
				$message           = $n['message'];
			?>

			<li>
				<a href="/watch/<?= $slug ?>">
					<div class="thumb">
						<img src="<?= $assets->get_thumbnail($video_uploader_id) ?>" />
					</div>
					<div class="info">
						<div class="message">
							<?= $message ?>
						</div>
						<div class="date"><?= $assets->when($notification['created_at']) ?></div>
					</div>
					<div class="clear"></div>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($type === 'video_comment') : ?>
			<?php
				$n              = json_decode($notification['notification'], true);
				$commentator_id = $n['commentator_id'];
				$slug           = $n['slug'];
				$message        = $n['message'];
			?>

			<li>
				<a href="/watch/<?= $slug ?>">
					<div class="thumb">
						<img src="<?= $assets->get_thumbnail($commentator_id) ?>" />
					</div>
					<div class="info">
						<div class="message">
							<?= $message ?>
						</div>
						<div class="date"><?= $assets->when($notification['created_at']) ?></div>
					</div>
					<div class="clear"></div>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($type === 'my_wallpost') : ?>
			<?php
				$n         = json_decode($notification['notification'], true);
				$user_id   = $n['user_id'];
				$firstname = $n['firstname'];
				$lastname  = $n['lastname'];
				$message   = $n['message'];
			?>

			<li>
				<a href="/channel/<?= $user_id ?>/<?= $firstname . '_' . $lastname ?>">
					<div class="thumb">
						<img src="<?= $assets->get_thumbnail($user_id) ?>" />
					</div>
					<div class="info">
						<div class="message">
							<?= $message ?>
						</div>
						<div class="date"><?= $assets->when($notification['created_at']) ?></div>
					</div>
					<div class="clear"></div>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($type === 'wall_post') : ?>
			<?php
				$n         = json_decode($notification['notification'], true);
				$poster_id = $n['poster_id'];
				$message   = $n['notification'];
			?>

			<li>
				<a href="/mychannel">
					<div class="thumb">
						<img src="<?= $assets->get_thumbnail($poster_id) ?>" />
					</div>
					<div class="info">
						<div class="message">
							<?= $message ?>
						</div>
						<div class="date"><?= $assets->when($notification['created_at']) ?></div>
					</div>
					<div class="clear"></div>
				</a>
			</li>
		<?php endif; ?>

		<?php if ($type === 'subscribe') : ?>
			<?php
				$n             = json_decode($notification['notification'], true);
				$subscriber_id = $n['subscriber_id'];
				$message       = $n['notification'];
			?>

			<li>
				<a href="/mychannel?page=mysubscribers">
					<div class="thumb">
						<img src="<?= $assets->get_thumbnail($subscriber_id) ?>" />
					</div>
					<div class="info">
						<div class="message">
							<?= $message ?>
						</div>
						<div class="date"><?= $assets->when($notification['created_at']) ?></div>
					</div>
					<div class="clear"></div>
				</a>
			</li>
		<?php endif; ?>

	<?php endforeach; ?>
</ul>
