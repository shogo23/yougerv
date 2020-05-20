<?php
	//Scss path for this view file /src/sess/pages/upload.scss
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="upload_contents">
	<div class="contents">
		<div class="video_source">
			<h1>Video Source</h1>
			<input type="file" name="video" id="video" />
			<div class="err">&nbsp;</div>
			<div class="filename">Browse Video File</div>
			<label for="video" class="btn btn-primary" id="browse">Browse File</label>
			<div class="upload_progress">
				<div class="label">Uploading Video</div>
				<div class="progress_container">
					<div class="progress_bar">&nbsp;</div>
					<div class="percent">0%</div>
				</div>
			</div>
			<div class="convert_progress">
				<div class="label">Converting Video</div>
				<div class="progress_container">
					<div class="progress_bar">&nbsp;</div>
					<div class="percent">0%</div>
				</div>
			</div>
		</div>
		<div class="video_details">
			<h1>Video Details</h1>
			<div class="fields">
				<div class="field">
					<labe for="title">Title:</label>
					<input type="text" id="title" autocomplete="off" />
				</div>
				<div class="field">
					<label for="description">Description:</label>
					<textarea id="description"></textarea>
				</div>
				<div class="field">
					<labe for="tags">Tags:</label>
					<div id="tags"></div>
				</div>
				<div class="btn_container">
					<div class="save_notification">Saved!</div>
					<button type="button" class="btn btn-primary" id="save">Save</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var slug = slug(15);

	let upload_video = new Promise((resolve, reject) => {
		$("#video").on("change", function(e) {
			//Filename
			var filename = e.target.files[0].name;

			//Split to get .ext
			var file = filename.split(".");

			//Max length of split.
			var len = file.length;

			//File Extension name.
			var file_ext = file[len - 1].toLowerCase();

			$(".filename").text(filename);

			if (!video_extensions(file_ext)) {
			$(".err").text(filename + " is not a video format.");
			} else {
				$(".err").html("&nbsp;");

				$("#video").upload('/upload', {
					"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
					"slug": slug
				}, (data) => {

					$(".convert_progress").show();
					$("#video").attr("disabled", "disabled");

					var d = {
						"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
						slug: data.slug,
						filename: data.filename
					};

					$.post("/upload/convert", d, (data) => {
						if (data == "ok") {
							resolve();
						}
					});
					_progress();
				}, (prog, val) => {
					$(".upload_progress").show();
					$(".upload_progress .progress_bar").css("width", val + "%");
					$(".upload_progress .percent").text(val + "%");
				});
			}
		});
	});

	$("#tags").shogotags({
		tag_border_color: "#ff4338",
		tag_background_color: "#ff4338",
		tag_border_radius: "5px",
		data: ""
	});

	let video_details = new Promise((resolve, reject) => {
		$("#save").on("click", function() {
			var title = $("#title").val();
			var description = $("#description").val();
			var tags = $("#s_tags").val();

			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				slug: slug,
				title: title,
				description: description,
				tags: tags
			};

			$.post("/upload/details", data, function(r) {
				if (r == "ok") {
					$(".save_notification").show();
					setTimeout(() => {
						$(".save_notification").fadeOut();
					}, 5000);
					resolve();
				}
			});
		});
	});

	Promise.all([upload_video, video_details]).then((data) => {
		location = "/watch/" + slug;
	});

	function slug(length) {
		var result = '';
		var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_-';
		var charactersLength = characters.length;

		for (var i = 0; i < length; i++) {
			result += characters.charAt(Math.floor(Math.random() * charactersLength));
		}

		return result;
	}

	function video_extensions(ext) {
		var exts = [
			'mp4', 'm4a', 'm4v', 'f4v', 'f4a', 'm4b', 'm4r', 'f4b', 'mov', '3gp', '3gp2', '3gpp', '3gpp2', 
			'ogg',  'oga', 'ogv', 'ogx', 'wmv', 'wma', 'asf', 'webm', 'flv', 'avi', 'rm', 'mpg', 'mpeg', 'vob'
		];

		if (exts.indexOf(ext) > -1) {
			return true;
		}

		return false;
	}

	function _progress() {
		var file = "/vids/progress_log/progress_" + slug + ".txt";
		var interval = setInterval(() => {
			var xhr = new XMLHttpRequest();
			xhr.open('HEAD', file, false);
			xhr.send();
			
			if (xhr.status == "404") {
				$(".convert_progress .progress_bar").css("width", "0%");
				$(".convert_progress .percent").text("0%");
			} else {
				fetch(file)
				.then(res => {
					if (!res.ok) {
						$(".convert_progress .progress_bar").css("width", "0%");
						$(".convert_progress .percent").text("0%");
					} else {
						return res.json();
					}
				}).then(progress => {
						if (progress >= 99) {
							clearInterval(interval);
							$(".convert_progress .progress_bar").css("width", "100%");
							$(".convert_progress .percent").text("100%");
						} else {
							

							$(".convert_progress .progress_bar").css("width", progress + "%");
							$(".convert_progress .percent").text(progress + "%");
						}
				}).catch(error => {
					$(".convert_progress .progress_bar").css("width", "0%");
					$(".convert_progress .percent").text("0%");
				});
			}
		}, 1000);
	}
</script>

<?= $this->endSection() ?>
