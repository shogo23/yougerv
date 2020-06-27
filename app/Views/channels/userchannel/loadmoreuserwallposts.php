<?php
	use App\Assets\Assets;

	$assets = new Assets();
?>

<?php foreach ($userwalls as $wall): ?>
	<li id="post_<?= $wall['id'] ?>">
		<div class="thumb">
			<a href="/channel/<?= $wall['poster_id'] . '/' . $wall['firstname'] . '_' . $wall['lastname'] ?>"><img src="<?= $assets->get_thumbnail($wall['poster_id']) ?>" /></a>
		</div>
		<div class="post_contents">
			<?php if ($assets->hasSession() && $walls->is_your_post($wall['id'], $assets->getUserId($assets->getSession('username')))) : ?>
				<div class="opt">
					<span onclick="javascript: _edit(' . $wall['id'] . ')"><i class="fas fa-edit"></i> Edit</span> | <span onclick="javascript: _delete(<?= $wall['id'] ?>)"><i class="fas fa-trash"></i> Delete</span>
				</div>
			<?php endif; ?>
			<div class="fullname">
				<a href="/channel/<?= $wall['poster_id'] . '/' . $wall['firstname'] . '_' . $wall['lastname'] ?>"><?= $wall['firstname'] . ' ' . $wall['lastname'] ?></a>
			</div>
			<div class="date">
				Posted at: <?= $assets->when($wall['created_at']) ?>
			</div>
			<?php if ($assets->hasSession() && $walls->is_your_post($wall['id'], $assets->getUserId($assets->getSession('username')))) : ?>
				<div class="opt_mini">
					<?= ! $wall['approved'] ? '<span onclick="javascript: _approve(' . $wall['id'] . ')"><i class="fas fa-thumbs-up"></i> Approve |</span>' : '<span onclick="javascript: _edit(' . $wall['id'] . ')"><i class="fas fa-edit"></i> Edit</span> |'; ?> <span onclick="javascript: _delete(<?= $wall['id'] ?>)"><i class="fas fa-trash"></i> Delete</span>
				</div>
			<?php endif; ?>
			<div class="post">
				<?= $wall['post'] ?>
			</div>
			<div class="edit_container">
				
			</div>
		</div>
		<div class="clear"></div>
	</li>
<?php endforeach; ?>
