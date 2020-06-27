<?php
	use App\Assets\Assets;

	$assets = new Assets();
?>

<?php if (count($userwalls) <= 0) : ?>
	<div class="user_no_post alert alert-info">
		There are no post at this time. <?= $assets->hasSession() ? 'Be the first to post a message for ' . $firstname . ' ' . $lastname . '.' : '' ?>
	</div>
	<?php ?>

<?php else: ?>
<ul>
	<?php foreach ($userwalls as $wall): ?>
		<li id="post_<?= $wall['id'] ?>">
			<div class="thumb">
				<a class="_ex" href="/channel/<?= $wall['poster_id'] . '/' . $wall['firstname'] . '_' . $wall['lastname'] ?>"><img src="<?= $assets->get_thumbnail($wall['poster_id']) ?>" /></a>
			</div>
			<div class="post_contents">
				<?php if ($assets->hasSession() && $walls->is_your_post($wall['id'], $assets->getUserId($assets->getSession('username')))) : ?>
					<div class="opt">
						<span onclick="javascript: _edit(<?= $wall['id'] ?>)"><i class="fas fa-edit"></i> Edit</span> | <span onclick="javascript: _delete(<?= $wall['id'] ?>)"><i class="fas fa-trash"></i> Delete</span>
					</div>
				<?php endif; ?>
				<div class="fullname">
					<a class="_ex" href="/channel/<?= $wall['poster_id'] . '/' . $wall['firstname'] . '_' . $wall['lastname'] ?>"><?= $wall['firstname'] . ' ' . $wall['lastname'] ?></a>
				</div>
				<div class="date">
					Posted at: <?= $assets->when($wall['created_at']) ?>
				</div>
				<?php if ($assets->hasSession() && $walls->is_your_post($wall['id'], $assets->getUserId($assets->getSession('username')))) : ?>
					<div class="opt_mini">
						<i class="fas fa-edit"></i> Edit</span> |<span onclick="javascript: _delete(<?= $wall['id'] ?>)"><i class="fas fa-trash"></i> Delete</span>
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
</ul>

<script>
	var offset = 10;
	var working = false;
	var edit_toggled = false;
	var elm = document.querySelector(".userwall_posts ul");
	
	$(window).on("scroll", () => {
		if ($(window).scrollTop() >= $(document).height() - $(window).height() && !working) {
			working = true;
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				channel_owner_id: <?= $channel_owner_id ?>,
				offset: offset
			};

			$.post("/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/loadmoreuserposts", data, r => {
				$(".userwall_posts ul").append(r);
				offset += 10;
				working = false;
			});
		}
	});

	elm.addEventListener("click", function(e) {
		if (e.srcElement.localName == "a" && e.target.className !== "_ex") {
			e.preventDefault();
			location = "/out?redirect=" + e.target.href;
		}
	});

	<?php if ($assets->hasSession()) : ?>
	function _edit(id) {
		if (!edit_toggled) {
			edit_toggled = true;

			var orig_post = $("#post_" + id + " .post_contents .post").html();
			$("#post_" + id + " .post_contents .post").hide();
			$("#post_" + id + " .post_contents .edit_container").show();

			var container = document.createElement("div");
			container.classList.add("update_container");
			
			var txtarea = document.createElement("textarea");
			txtarea.classList.add("update_post");
			txtarea.setAttribute("id", "post_update");
			txtarea.innerHTML = $.trim(filter_tags(orig_post));
			container.append(txtarea);

			var btn_container = document.createElement("div");
			btn_container.classList.add("btn_container");
			
			var update_btn = document.createElement("button");
			update_btn.classList.add("btn");
			update_btn.classList.add("btn-primary");
			update_btn.setAttribute("id", "update");
			update_btn.setAttribute("type", "button");
			update_btn.setAttribute("onclick", "javascript: _update(" + id + ")");
			update_btn.innerHTML = "Save";
			btn_container.append(update_btn);

			var cancel_btn = document.createElement("button");
			cancel_btn.classList.add("btn");
			cancel_btn.classList.add("btn-danger");
			cancel_btn.setAttribute("id", "cancel");
			cancel_btn.setAttribute("type", "button");
			cancel_btn.setAttribute("onclick", "javascript: _cancel_edit(" + id + ")");
			cancel_btn.innerHTML = "Cancel";
			btn_container.append(cancel_btn);

			container.append(btn_container);

			$("#post_" + id + " .post_contents .edit_container").append(container);

			stretchTextarea("#post_update");
		}
	}

	function _cancel_edit(id) {
		edit_toggled = false;
		$("#post_" + id + " .post_contents .post").show();
		$("#post_" + id + " .post_contents .edit_container").html("").hide();
	}

	function _update(id) {
		var post = $("#post_" + id + " .post_contents .edit_container #post_update").val();
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			poster_id: <?= $assets->getUserId($assets->getSession('username')) ?>,
			post_id: id,
			post: post
		};

		$.post("/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/update", data, r => {
			$("#post_" + id + " .post_contents .post").html(r).show();
			$("#post_" + id + " .post_contents .edit_container").html("").hide();
			edit_toggled = false;
		});
	}

	function _delete(id) {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			channel_owner_id: <?= $channel_owner_id ?>,
			post_id: id
		};

		$.post("/channel/<?= $channel_owner_id ?>/<?= $firstname . '_' . $lastname ?>/delete", data, r => {
			if (r == "ok") {
				$("#post_" + id).fadeOut();
			}
		});
	}

	function filter_tags(str) {
		return str.replace(/(<([^>]+)>)/ig,"")
	}

	<?php endif; ?>
</script>
<?php endif; ?>
