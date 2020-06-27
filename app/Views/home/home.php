<?php
	//Scss path for this view file /src/sess/pages/home.scss

	use App\Assets\Assets;
	use App\Models\ChannelsModel;

	$assets   = new Assets();
	$channels = new ChannelsModel();
	$request  = \Config\Services::request();
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="home_contents">
	<div class="contents">
		<?php if ($assets->hasSession() && ! $request->getGet('page_video') || $request->getGet('page_video') === 1) : ?>
			<div class="subscription_videos">
				<?php foreach ($subscriptions as $subscription) : ?>
					<h1><?= $subscription['firstname'] . ' ' . $subscription['lastname'] ?>'s Latest Videos</h1>
					<ul>
						<?php foreach ($channels->get_subscribed_videos($subscription['id']) as $video) : ?>
							<li data-aos="fade-up">
								<div class="thumb">
									<a href="/watch/<?= $video['slug'] ?>"><img alt="thumb" src="/vids/thumbs/<?= $video['slug'] ?>.jpg" /></a>
									<div class="length"><?= $video['length'] ?></div>
								</div>
								<div class="details">
									<div class="title"><a title="<?= $video['title'] ?>" href="/watch/<?= $video['slug'] ?>"><?= $assets->reduce_title($video['title']) ?></a></div>
									<div class="uploader">
										<a href="/channel/<?= $video['user_id'] . '/' . $video['firstname'] . '_' . $video['lastname'] ?>"><?= $video['firstname'] . ' ' . $video['lastname'] ?></a>
									</div>
									<div class="date"><?= $assets->when($video['created_at']) ?></div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<div class="videos">
			<h1>Latest Videos</h1>
			<ul>
				<?php foreach ($videos as $video): ?>
					<li data-aos="fade-up">
						<div class="thumb">
							<a href="/watch/<?= $video['slug'] ?>"><img alt="thumb" src="/vids/thumbs/<?= $video['slug'] ?>.jpg" /></a>
							<div class="length"><?= $video['length'] ?></div>
						</div>
						<div class="details">
							<div class="title"><a title="<?= $video['title'] ?>" href="/watch/<?= $video['slug'] ?>"><?= $assets->reduce_title($video['title']) ?></a></div>
							<div class="uploader">
								<a href="/channel/<?= $video['user_id'] . '/' . $video['firstname'] . '_' . $video['lastname'] ?>"><?= $video['firstname'] . ' ' . $video['lastname'] ?></a>
							</div>
							<div class="date"><?= $assets->when($video['created_at']) ?></div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="clear"></div>
		</div>
		
		<?= $pagination_visibility ? $pager->links('video', 'custom_simple') : ''; ?>
	</div>
</div>

<script>
	AOS.init();
</script>

<?= $this->endSection() ?>
