<?php
/**
 * @var \App\Views\Pager\PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<div class="pagination">
	<ul>
		<?php if ($pager->hasPrevious()) : ?>
			<li>
				<a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
					<span aria-hidden="true"><?= lang('Pager.first') ?></span>
				</a>
			</li>
			<li>
				<a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
		<?php endif; ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li>
				<a href="<?= $link['uri'] ?>" <?= $link['active'] ? 'class="active"' : '' ?>">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach; ?>

		<?php if ($pager->hasNext()) : ?>
			<li>
				<a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
			<li>
				<a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
					<span aria-hidden="true"><?= lang('Pager.last') ?></span>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>

<div class="mini_pagination">
	<ul>
		<?php if ($pager->hasPrevious()) : ?>
				<li>
					<a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
						<span aria-hidden="true"><?= lang('Pager.first') ?></span>
					</a>
				</li>
				<li>
					<a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
						<span aria-hidden="true">&laquo;</span>
					</a>
				</li>
		<?php endif; ?>

		<li>
			<select id="paginate">
				<?php foreach ($pager->links() as $link) : ?>
					<option value="<?= $link['uri'] ?>" <?= $link['active'] ? 'selected' : '' ?>>Page <?= $link['title'] ?></option>
				<?php endforeach; ?>
			</select>
		</li>

		<?php if ($pager->hasNext()) : ?>
				<li>
					<a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
						<span aria-hidden="true">&raquo;</span>
					</a>
				</li>
				<li>
					<a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
						<span aria-hidden="true"><?= lang('Pager.last') ?></span>
					</a>
				</li>
		<?php endif; ?>
	<ul>
</div>

<script>
    $("#paginate").on("change", () => {
        location =  $("#paginate").val();
    });
</script>

