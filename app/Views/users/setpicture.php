<?php
	//Scss path for this view file /src/sess/pages/setpicture.scss
?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>

<div class="setpicture_container">
	<div class="contents row">
		<h1>Upload your picture</h1>
		<div class="img_preview col-md-6 col-sm-12">
			<div class="pic">
				<img src="/img/nopic.png" />
			</div>
		</div>
		<div class="upload_opt col-md-6 col-sm-12">
			<input type="file" name="image" id="browse" />
			<label for="browse" class="btn btn-primary btn-lg browse">Browse Picture</label>
			<div class="filename">&nbsp;</div>
			<div class="err">&nbsp;</div>
			<div class="progress_container">
				<div class="progress_bar">&nbsp;</div>
				<div class="percent">0%</div>
			</div>
		</div>
		<div class="skip_container col-md-12">
			<button type="button" class="btn btn-success" id="skip">Skip</button>
		</div>
		<div class="btn_container col-md-12">
			<button type="button" class="btn btn-danger" id="reset">Upload Again</button>
			<button type="button" class="btn btn-success" id="continue">Continue</button>
		</div>
	</div>
</div>

<script>
	$("#browse").on("change", (e) => {

		$(".err").html("&nbsp;");

		var filename = e.target.files[0].name;
		var size = parseFloat(e.target.files[0].size / 1024).toFixed(2);
		var type = e.target.files[0].type;

		//Get File extention.
		var arr = filename.split(".");
		var arr_nums = 0;

		while (arr_nums < arr.length) {
			arr_nums++;
		}

		var file_ext = arr[arr_nums - 1];

		if (filename.length > 15) {
			filename = filename.substring(0, 15) + "..." + file_ext;
		}
		
		$(".filename").text(filename);

		//Validation.
		if (type !== "image/jpeg" && type !== "image/png") {
			$(".err").text("jpeg and png image only.");
		} else if (size > 1024) {
			$(".err").text("File size too large.");
		} else {
			$(".progress_container").css("visibility", "visible");

			$("#browse").upload("/imageUpload",{
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
			}, (picture) => {
				$(".pic img").attr("src", '/img/users/pictures/' + picture);
				$(".browse").css("visibility", "hidden");
				$(".btn_container").show();
				$(".skip_container").hide();
			}, (prog, val) => {
				$(".progress_bar").css("width", val + "%");
				$(".percent").text(val + "%");
			});
		}
	});

	$("#reset").on("click", function() {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		}

		$.post('/imageUpload/remove', data, function(r) {
			if (r == "ok") {
				$(".browse").css("visibility", "visible");
				$(".btn_container").hide();
				$(".progress_container").css("visibility", "hidden");
				$(".progress_bar").css("width", 0);
				$(".percent").text("0");
				$(".skip_container").show();
				$(".filename").html("&nbsp;");
				$(".pic img").attr("src", "/img/nopic.png");
				$("#browse").val("");
			}
		});
	});

	$("#skip, #continue").on("click", function() {
		location = "/mychannel";
	});
</script>

<?= $this->endSection() ?>
