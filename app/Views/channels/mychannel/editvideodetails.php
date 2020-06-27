<?php
	use App\Assets\Assets;

	$assets = new Assets();

?>

<div class="video_details">
	<div class="contents">
		<h1>Edit Video Details</h1>
		<div class="fields">
			<div class="field">
				<label for="title">Title:</label>
				<input type="text" id="title" value="<?= $videos[0]['title'] ?>" autocomplete="off" />
			</div>
			<div class="field">
			<label for="description">Description:</label>
				<textarea id="description"><?= strip_tags($videos[0]['description']) ?></textarea>
			</div>
			<div class="field">
				<label for="tags">Tags:</label>
				<div id="tags"></div>
			</div>
			<div class="btn_container">
				<button type="button" class="btn btn-primary" id="save_details">Save</button> <button type="button" class="btn btn-danger" onclick="javascript: _close_myvideo()">Cancel</button>
			</div>
			<div class="ajax_loader">
				<img src="/img/ajax_loader_small.gif" />
			</div>
		</div>
	</div>
</div>

<script>
	$("#tags").shogotags({
		tag_border_color: "#ff4338",
		tag_background_color: "#ff4338",
		tag_border_radius: "5px",
		data: "<?= $videos[0]['tags'] ?>"
	});
	
	$("#save_details").on("click", () => {
		var title = $("#title").val();
		var description = $("#description").val();
		var tags = $("#s_tags").val();

		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
			video_id: <?= $video_id ?>,
			title: title,
			description: description,
			tags: tags
		};

		$(".btn_container").hide();
		$(".ajax_loader").show();
		
		$.post("/mychannel/myvideos/editdetails/save", data, r => {
			apply_changes(<?= $video_id ?>, r);
			_close_myvideo();
			// _active();
			// $(window).scrollTop(0);
		});
	});
</script>
