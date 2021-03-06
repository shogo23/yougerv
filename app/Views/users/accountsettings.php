<?php
	//Scss path for this view file /src/sess/pages/accountsettings.scss

	use App\Assets\Assets;

	$assets = new Assets();
?>

<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<div class="accountsettings">
	<div class="contents">
		<h1>Account Settings</h1>
		<table class="lg">
			<tr class="fullname_view">
				<td>Fullname:</td>
				<td><?= $fullname ?></td>
				<td><i id="fullname_toggle" class="fas fa-edit"></i></td>
			</tr>
			<tr class="fullname_edit">
				<td>Fullname</td>
				<td>
					<div class="fullname_form">
						<div class="fullname_alert_error alert alert-danger">abc</div>
						<div class="fullname_alert_success alert alert-primary">Fullname has been changed.</div>
						<div class="field">
							<input type="text" id="firstname" placeholder="Your Firstname Here" autocomplete="off" maxlength="11" />
						</div>
						<div class="field">
							<input type="text" id="lastname" placeholder="Your Lastname Here" autocomplete="off" maxlength="11" />
						</div>
						<div class="btns">
							<button type="button" class="btn btn-primary" id="fullname_save">Save</button>
							<button type="button" class="btn btn-danger" id="fullname_cancel">Cancel</button>
						</div>
					</div>
				</td>
				<td><i class="far fa-window-close" id="fullname_cancel2"></i></td>
			</tr>
			<tr class="nickname_view">
				<td>Nickname:</td>
				<td><?= $nickname ?></td>
				<td><i class="fas fa-edit" id="nickname_toggle"></i></td>
			</tr>
			<tr class="nickname_edit">
				<td>Nickname:</td>
				<td>
					<div class="nickname_form">
						<div class="nickname_alert_error alert alert-danger"></div>
						<div class="nickname_alert_success alert alert-primary">Nickname has been changed.</div>
						<div class="field">
							<input type="text" id="nickname" placeholder="Nickname Here" autocomplete="off" maxlength="11" />
						</div>
						<div class="btns">
							<button type="button" class="btn btn-primary" id="nickname_save">Save</button>
							<button type="button" class="btn btn-danger" id="nickname_cancel">Cancel</button>
						</div>
					</div>
				</td>
				<td><i class="far fa-window-close" id="nickname_cancel2"></i></td>
			</tr>
			<tr class="password_view">
				<td>Password:</td>
				<td>&nbsp;</td>
				<td><i class="fas fa-edit" id="password_toggle"></i></td>
			</tr>
			<tr class="password_edit">
				<td>Password:</td>
				<td>
					<div class="password_form">
						<div class="password_alert_error alert alert-danger">abc</div>
						<div class="password_alert_success alert alert-primary">Password has been changed.</div>
						<div class="field">
							<input type="password" id="current_password" placeholder="Your Current Password Here" />
						</div>
						<div class="field">
							<input type="password" id="new_password" placeholder="Your New Password Here" />
						</div>
						<div class="field">
							<input type="password" id="rpassword" placeholder="Your Confirm your New Password" />
						</div>
						<div class="btns">
							<button type="button" class="btn btn-primary" id="password_save">Save</button>
							<button type="button" class="btn btn-danger" id="password_cancel">Cancel</button>
						</div>
					</div>
				</td>
				<td><i class="far fa-window-close" id="password_cancel2"></i></td>
			</tr>
			<tr class="picture_view">
				<td>Picture:</td>
				<td>&nbsp;</td>
				<td><i class="fas fa-edit" id="picturee_toggle"></i></td>
			</tr>
			<tr class="picture_edit">
				<td>Picture:</td>
				<td>
					<div class="picture_form">
						<div class="left">
							<img src="<?= $assets->get_picture() ?>" />
						</div>
						<div class="right">
							<input type="file" name="image" id="image" />
							<label for="image" id="browse" class="btn btn-primary btn-lg">Browse</label>
							<div class="filename">&nbsp;</div>
							<div class="err">&nbsp;</div>
							<div class="progress_container">
								<div class="progress_bar">&nbsp;</div>
								<div class="percent">0%</div>
							</div>
							<div class="success">Upload Complete</div>
						</div>
						<div class="clear"></div>
						<div class="btn_container">
							<button id="picture_reset" class="btn btn-danger" type="button">Upload Again</button>
						</div>
					</div>
				</td>
				<td><i class="far fa-window-close" id="picture_cancel"></i></td>
			</tr>
		</table>

		<div class="sm">
			<div class="fullname">
				<h4>Change Fullname</h4>
				<div class="m_fullname_alert_error alert alert-danger">error</div>
				<div class="m_fullname_alert_success alert alert-primary">Fullname has been changed</div>
				<div class="field">
					<label for="m_firstname">Fistname:</label>
					<input type="text" id="m_firstname" maxlength="11" />
				</div>
				<div class="field">
					<label for="m_lastname">Lastname:</label>
					<input type="text" id="m_lastname" maxlength="11" />
				</div>
				<div class="m_btns">
					<button type="button" class="btn btn-primary" id="m_fullname_save">Save</button>
					<button type="button" class="btn btn-danger" id="m_fullname_clear">Clear</button>
				</div>
			</div>
			<div class="nickname">
				<h4>Change Nickname</h4>
				<div class="m_nickname_alert_error alert alert-danger">error</div>
				<div class="m_nickname_alert_success alert alert-primary">Nickname has been changed</div>
				<div class="field">
					<label for="m_nickname">Nickname:</label>
					<input type="text" id="m_nickname" maxlength="11" />
				</div>
				<div class="m_btns">
					<button type="button" class="btn btn-primary" id="m_nickname_save">Save</button>
					<button type="button" class="btn btn-danger" id="m_nickname_clear">Clear</button>
				</div>
			</div>
			<div class="passwords">
				<h4>Change Password</h4>
				<div class="m_passwords_alert_error alert alert-danger">error</div>
				<div class="m_passwords_alert_success alert alert-primary">Password has been changed</div>
				<div class="field">
					<label for="m_current_password">Current Password:</label>
					<input type="password" id="m_current_password" />
				</div>
				<div class="field">
					<label for="m_new_password">New Password:</label>
					<input type="password" id="m_new_password" />
				</div>
				<div class="field">
					<label for="m_rpassword">Confirm New Password:</label>
					<input type="password" id="m_rpassword" />
				</div>
				<div class="m_btns">
					<button type="button" class="btn btn-primary" id="m_password_save">Save</button>
					<button type="button" class="btn btn-danger" id="m_password_clear">Clear</button>
				</div>
			</div>
			<div class="picture">
				<h4>Upload Picture</h4>
				<div class="form">
					<div class="top">
						<img src="<?= $assets->get_picture() ?>" />
					</div>
					<div class="bottom">
						<input type="file" name="image" id="m_image" />
						<label for="m_image" id="m_browse" class="btn btn-primary btn-lg">Browse</label>
						<div class="m_filename">&nbsp;</div>
						<div class="m_err">&nbsp;</div>
						<div class="m_progress_container progress_container">
							<div class="progress_bar">&nbsp;</div>
							<div class="percent">0%</div>
						</div>
						<div class="m_success">Upload Complete</div>
					</div>
					<div class="m_btn_container">
						<button id="m_picture_reset" class="btn btn-danger" type="button">Upload Again</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var fullname_bool = false;
	var nickname_bool = false;
	var password_bool = false;
	var picture_bool = false;

	_resize();

	$(window).on("click change resize", () => {
		_resize();
	});

	$("#fullname_toggle").on("click", () => {
		_fullname();
	});

	$("#fullname_cancel, #fullname_cancel2").on("click", () => {
		_fullname();
	});

	$("#nickname_toggle").on("click", () => {
		_nickname();
	});

	$("#nickname_cancel, #nickname_cancel2").on("click", () => {
		_nickname();
	});

	$("#password_toggle").on("click", () => {
		_password();
	});

	$("#password_cancel, #password_cancel2").on("click", () => {
		_password();
	});

	$("#picturee_toggle, #picture_cancel").on("click", () => {
		_picture();
	});

	$("#fullname_save").on("click", () => {
		if ($("#firstname").val() == "") {
			$(".fullname_alert_error").fadeIn().text("Please enter your firstname");
			$("#firstname").css("border-color", "red").focus();
		} else if ($("#firstname").val().length <= 2) {
			$(".fullname_alert_error").fadeIn().text("Firstname is too short.");
			$("#firstname").css("border-color", "red").focus();
		} else if ($("#lastname").val() == "") {
			$(".fullname_alert_error").fadeIn().text("Please enter your lastname");
			$("#lastname").css("border-color", "red").focus();
		} else if ($("#lastname").val().length < 2) {
			$(".fullname_alert_error").fadeIn().text("Lastname is too short.");
			$("#lastname").css("border-color", "red").focus();
		} else {
			var data =  {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				firstname: $("#firstname").val(),
				lastname: $("#lastname").val()
			};

			$.post("/accountsettings/fullname/save", data, r => {
				if (r == "ok") {
					$(".fullname_view td:nth-child(2)").text($("#firstname").val() + " " + $("#lastname").val());
					$(".fullname_alert_success").fadeIn();
					setTimeout(() => {
						$(".fullname_alert_success").fadeOut(() => {
							_fullname();
						});
					}, 5000);
				} 
			});
		}
	});

	$("#nickname_save").on("click", function() {
		if ($("#nickname").val() == "") {
			$(".nickname_alert_error").fadeIn().text("Please enter your firstname");
			$("#nickname").css("border-color", "red").focus();
		} else if ($("#nickname").val().length <= 2) {
			$(".nickname_alert_error").fadeIn().text("Nickname is too short");
			$("#nickname").css("border-color", "red").focus();
		} else {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				nickname: $("#nickname").val()
			};

			$.post("/accountsettings/nickname/save", data, r => {
				if (r == "ok") {
					$(".nickname_view td:nth-child(2)").text($("#nickname").val());
					$("#nickname_toggler").html($("#nickname").val());
					$(".nickname_alert_success").fadeIn();
					setTimeout(() => {
						$(".nickname_alert_success").fadeOut(() => {
							_nickname();
						});
					}, 5000);
				}
			});
		}
	});

	$("#password_save").on("click", () => {
		if ($("#current_password").val() == "") {
			$(".password_alert_error").fadeIn().text("Please enter your current password");
			$("#current_password").css("border-color", "red").focus();
		} else if ($("#new_password").val() == "") {
			$(".password_alert_error").fadeIn().text("Please enter your new password");
			$("#new_password").css("border-color", "red").focus();
		} else if ($("#new_password").val().length <= 5) {
			$(".password_alert_error").fadeIn().text("New password is too short");
			$("#new_password").css("border-color", "red").focus();
		} else if ($("#rpassword").val() == "") {
			$(".password_alert_error").fadeIn().text("Please confirm your new password");
			$("#rpassword").css("border-color", "red").focus();
		} else if ($("#new_password").val() !== $("#rpassword").val()) {
			$(".password_alert_error").fadeIn().text("New password and confirm password did not matched");
			$("#new_password").css("border-color", "red").focus();
		} else {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				password: $("#current_password").val()
			};

			$.post("/accountsettings/password/check", data, r => {
				if (r == 0) {
					$(".password_alert_error").fadeIn().text("Current password is incorrect");
					$("#current_password").css("border-color", "red").focus();
				} else {
					var data = {
						"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
						password: $("#new_password").val()
					};

					$.post("/accountsettings/password/save", data, r => {
						if (r == "ok") {
							$(".password_alert_success").fadeIn();
							setTimeout(() => {
								$(".password_alert_success").fadeOut(() => {
									_password();
								});
							}, 5000);
						}
					});
				}
			});
		}
	});

	$("#m_fullname_save").on("click", () => {
		if ($("#m_firstname").val() == "") {
			$("#m_firstname").css("border-color", "red").focus();
			$(".m_fullname_alert_error").fadeIn().text("Please enter your firstname");
		} else if ($("#m_firstname").val().length <= 2) {
			$("#m_firstname").css("border-color", "red").focus();
			$(".m_fullname_alert_error").fadeIn().text("Firstname is too short");
		} else if ($("#m_lastname").val() == "") {
			$("#m_lastname").css("border-color", "red").focus();
			$(".m_fullname_alert_error").fadeIn().text("Please enter your lastname");
		} else if ($("#m_lastname").val().length <= 2) {
			$("#m_lastname").css("border-color", "red").focus();
			$(".m_fullname_alert_error").fadeIn().text("Lastname is too short");
		} else {
			var data =  {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				firstname: $("#m_firstname").val(),
				lastname: $("#m_lastname").val()
			};

			$.post("/accountsettings/fullname/save", data, r => {
				if (r == "ok") {
					$(".fullname_view td:nth-child(2)").text($("#firstname").val() + " " + $("#lastname").val());
					$(".m_fullname_alert_success").fadeIn();
					$("#m_firstname").val("");
					$("#m_lastname").val("");
					setTimeout(() => {
						$(".m_fullname_alert_success").fadeOut(() => {
							$(".m_fullname_alert_success").fadeOut();
						});
					}, 5000);
				} 
			});
		}
	});

	$("#m_fullname_clear").on("click", () => {
		$("#m_firstname").css("border-color", "#ccc").val("");
		$("#m_lastname").css("border-color", "#ccc").val("");
		$(".m_fullname_alert_error").fadeOut(() => {
			$(".m_fullname_alert_error").text("");
		});
	});

	$("#m_nickname_save").on("click", () => {
		if ($("#m_nickname").val() == "") {
			$("#m_nickname").css("border-color", "red").focus();
			$(".m_nickname_alert_error").fadeIn().text("Please enter your nickname");
		} else if ($("#m_nickname").val().length <= 2) {
			$("#m_nickname").css("border-color", "red").focus();
			$(".m_nickname_alert_error").fadeIn().text("Nickname is too short");
		} else {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				nickname: $("#m_nickname").val()
			};

			$.post("/accountsettings/nickname/save", data, r => {
				if (r == "ok") {
					$(".nickname_view td:nth-child(2)").text($("#m_nickname").val());
					$("#nickname_toggler").html($("#m_nickname").val());
					$(".m_nickname_alert_success").fadeIn();
					$("#m_nickname").val("");
					setTimeout(() => {
						$(".m_nickname_alert_success").fadeOut(() => {
							$(".m_nickname_alert_error").fadeOut(() => {
								$(".m_nickname_alert_error").text("");
							});
						});
					}, 5000);
				}
			});
		}
	});

	$("#m_nickname_clear").on("click", () => {
		$("#m_nickname").css("border-color", "#ccc").val("");
		$(".m_nickname_alert_error").fadeOut(() => {
			$(".m_nickname_alert_error").text("");
		});
	});

	$("#m_password_save").on("click", () => {
		if ($("#m_current_password").val() == "") {
			$("#m_current_password").css("border-color", "red").focus();
			$(".m_passwords_alert_error").fadeIn().text("Please enter your current password");
		} else if ($("#m_new_password").val() == "") {
			$("#m_new_password").css("border-color", "red").focus();
			$(".m_passwords_alert_error").fadeIn().text("Please enter your new password");
		} else if ($("#m_new_password").val().length <= 5) {
			$("#m_new_password").css("border-color", "red").focus();
			$(".m_passwords_alert_error").fadeIn().text("New password is too short");
		} else if ($("#m_rpassword").val() == "") {
			$("#m_rpassword").css("border-color", "red").focus();
			$(".m_passwords_alert_error").fadeIn().text("Please confirm your new password");
		} else if ($("#m_new_password").val() !== $("#m_rpassword").val()) {
			$("#m_new_password").css("border-color", "red").focus();
			$("#m_rpassword").css("border-color", "red");
			$(".m_passwords_alert_error").fadeIn().text("New password and confirm password did not matched");
		} else {
			var data = {
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
				password: $("#m_current_password").val()
			};

			$.post("/accountsettings/password/check", data, r => {
				if (r == 0) {
					$(".m_passwords_alert_error").fadeIn().text("Current password is incorrect");
					$("#m_current_password").css("border-color", "red").focus();
				} else {
					var data = {
						"<?= csrf_token() ?>": "<?= csrf_hash() ?>",
						password: $("#m_new_password").val()
					};

					$.post("/accountsettings/password/save", data, r => {
						if (r == "ok") {
							$("#m_current_password").val("");
							$("#m_new_password").val("");
							$("#m_rpassword").val("");
							$(".m_passwords_alert_success").fadeIn();
							setTimeout(() => {
								$(".m_passwords_alert_success").fadeOut();
							}, 5000);
						}
					});
				}
			});
		}
	});

	$("#m_password_clear").on("click", () => {
		$("#m_current_password").css("border-color", "#ccc").val("");
		$("#m_new_password").css("border-color", "#ccc").val("");
		$("#m_rpassword").css("border-color", "#ccc").val("");
		$(".m_passwords_alert_error").fadeOut(() => {
			$(".m_passwords_alert_error").text("");
		});
	});

	$("#image").on("change", e => {
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

			$("#image").upload("/imageUpload",{
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
			}, (picture) => {
				$(".picture_form .left img, #thumbnail_toggler, .user_menu .contents .top img").attr("src", '/img/users/pictures/' + picture);
				$("#browse").css("visibility", "hidden");
				$(".success").css("visibility", "visible");
				$(".btn_container").css("visibility", "visible");
			}, (prog, val) => {
				$(".progress_bar").css("width", val + "%");
				$(".percent").text(val + "%");
			});
		}
	});

	$("#picture_reset").on("click", () => {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		}

		$.post('/imageUpload/remove', data, function(r) {
			if (r == "ok") {
				$(".picture_form .left img, #thumbnail_toggler, .user_menu .contents .top img").attr("src", "/img/nopic.png");
				$("#browse").css("visibility", "visible");
				$(".btn_container").css("visibility", "hidden");
				$(".progress_container").css("visibility", "hidden");
				$(".progress_bar").css("width", 0);
				$(".percent").text("0");
				$(".filename").html("&nbsp;");
				$("#image").val("");
			}
		});
	});

	$("#m_image").on("change", e => {
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
		
		$(".m_filename").text(filename);

		//Validation.
		if (type !== "image/jpeg" && type !== "image/png") {
			$(".m_err").text("jpeg and png image only.");
		} else if (size > 1024) {
			$(".m_err").text("File size too large.");
		} else {
			$(".m_progress_container").css("visibility", "visible");

			$("#m_image").upload("/imageUpload",{
				"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
			}, (picture) => {
				$(".sm .picture .form .top img, #thumbnail_toggler2, .user_menu .contents .top ul li:first-child img").attr("src", '/img/users/pictures/' + picture);
				$("#m_browse").css("visibility", "hidden");
				$(".m_success").css("visibility", "visible");
				$(".m_btn_container").css("visibility", "visible");
			}, (prog, val) => {
				$(".m_progress_container .progress_bar").css("width", val + "%");
				$(".m_progress_container .percent").text(val + "%");
			});
		}
	});

	$("#m_picture_reset").on("click", () => {
		var data = {
			"<?= csrf_token() ?>": "<?= csrf_hash() ?>"
		}

		$.post('/imageUpload/remove', data, function(r) {
			if (r == "ok") {
				$(".sm .picture .form .top img, #thumbnail_toggler2, .user_menu .contents .top ul li:first-child img").attr("src", "/img/nopic.png");
				$("#m_browse").css("visibility", "visible");
				$(".m_btn_container").css("visibility", "hidden");
				$(".m_progress_container").css("visibility", "hidden");
				$("m_progress_container .progress_bar").css("width", 0);
				$(".m_progress_container .percent").text("0");
				$(".m_filename").html("&nbsp;");
				$(".m_success").css("visibility", "none");
				$("#m_image").val("");
			}
		});
	});



	$("#firstname").on("keyup", () => {
		$("#firstname").css("border-color", "#ccc");
		$(".fullname_alert_error").fadeOut(() => {
			$(".fullname_alert_error").text("");
		});
	});

	$("#lastname").on("keyup", () => {
		$("#lastname").css("border-color", "#ccc");
		$(".fullname_alert_error").fadeOut(() => {
			$(".fullname_alert_error").text("");
		});
	});

	$("#nickname").on("keyup", () => {
		$("#nickname").css("border-color", "#ccc");
		$(".nickname_alert_error").fadeOut(() => {
			$(".nickname_alert_error").text("");
		});
	});

	$("#current_password").on("keyup", () => {
		$("#current_password").css("border-color", "#ccc");
		$(".password_alert_error").fadeOut(() => {
			$(".password_alert_error").text("");
		});
	});

	$("#new_password").on("keyup", () => {
		$("#new_password").css("border-color", "#ccc");
		$(".password_alert_error").fadeOut(() => {
			$(".password_alert_error").text("");
		});
	});

	$("#rpassword").on("keyup", () => {
		$("#rpassword").css("border-color", "#ccc");
		$(".password_alert_error").fadeOut(() => {
			$(".password_alert_error").text("");
		});
	});

	$("#m_firstname").on("keyup", () => {
		$("#m_firstname").css("border-color", "#ccc");
		$(".m_fullname_alert_error").fadeOut(() => {
			$(".m_fullname_alert_error").text("");
		});
	});

	$("#m_lastname").on("keyup", () => {
		$("#m_lastname").css("border-color", "#ccc");
		$(".m_fullname_alert_error").fadeOut(() => {
			$(".m_fullname_alert_error").text("");
		});
	});

	$("#m_nickname").on("keyup", () => {
		$("#m_nickname").css("border-color", "#ccc");
		$(".m_nickname_alert_error").fadeOut(() => {
			$(".m_nickname_alert_error").text("");
		});
	});

	$("#m_current_password").on("keyup", () => {
		$("#m_current_password").css("border-color", "#ccc");
		$(".m_passwords_alert_error").fadeOut(() => {
			$(".m_passwords_alert_error").text("");
		});
	});

	$("#m_new_password").on("keyup", () => {
		$("#m_new_password").css("border-color", "#ccc");
		$(".m_passwords_alert_error").fadeOut(() => {
			$(".m_passwords_alert_error").text("");
		});
	});

	$("#m_rpassword").on("click", () => {
		$("#m_rpassword").css("border-color", "#ccc");
		$(".m_passwords_alert_error").fadeOut(() => {
			$(".m_passwords_alert_error").text("");
		});
	});

	function _fullname() {
		if (!fullname_bool) {
			fullname_bool = true;

			$(".fullname_view").hide();
			$(".fullname_edit").show();
		} else {
			fullname_bool = false;

			$(".fullname_edit").hide();
			$(".fullname_view").show();

			$("#firstname").val("");
			$("#lastname").val("");

			$("#firstname").css("border-color", "#ccc");
			$(".fullname_alert_error").fadeOut(() => {
				$(".fullname_alert_error").text("");
			});

			$("#lastname").css("border-color", "#ccc");
			$(".fullname_alert_error").fadeOut(() => {
				$(".fullname_alert_error").text("");
			});
		}
	}

	function _nickname() {
		if (!nickname_bool) {
			nickname_bool = true;

			$(".nickname_view").hide();
			$(".nickname_edit").show();
		} else {
			nickname_bool = false;

			$(".nickname_edit").hide();
			$(".nickname_view").show();

			$("#nickname").val("");

			$("#nickname").css("border-color", "#ccc");
			$(".nickname_alert_error").fadeOut(() => {
				$(".nickname_alert_error").text("");
			});
		}
	}

	function _password() {
		if (!password_bool) {
			password_bool = true;
			
			$(".password_view").hide();
			$(".password_edit").show();
		} else {
			password_bool = false;

			$(".password_edit").hide();
			$(".password_view").show();

			$("#current_password").val("");
			$("#new_password").val("");
			$("#rpassword").val("");

			$("#current_password").css("border-color", "#ccc");
			$(".password_alert_error").fadeOut(() => {
				$(".password_alert_error").text("");
			});

			$("#new_password").css("border-color", "#ccc");
			$(".password_alert_error").fadeOut(() => {
				$(".password_alert_error").text("");
			});

			$("#rpassword").css("border-color", "#ccc");
			$(".password_alert_error").fadeOut(() => {
				$(".password_alert_error").text("");
			});
		}
	}

	function _picture() {
		if (!picture_bool) {
			picture_bool = true;

			$(".picture_view").hide();
			$(".picture_edit").show();
		} else {
			picture_bool = false;

			$(".picture_edit").hide();
			$(".picture_view").show();

			$("#browse").css("visibility", "visible");
			$(".btn_container").css("visibility", "hidden");
			$(".progress_container").css("visibility", "hidden");
			$(".progress_bar").css("width", 0);
			$(".percent").text("0");
			$(".filename").html("&nbsp;");
			$(".err").html("&nbsp;");
			$(".success").css("visibility", "hidden");
			$("#image").val("");
		}
	}

	function _resize() {
		var height = $(window).outerHeight();
		var accountsettings = $("section").height() + 58;
		var main_nav = Math.round($(".main_nav").height());
		var new_height = height - main_nav;

		if (height >= accountsettings) {
			$(".accountsettings .contents").css({
				height: new_height + "px"
			});
		}
	}
	
</script>

<?= $this->endSection() ?>
