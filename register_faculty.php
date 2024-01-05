<?php
include(__DIR__ . "/partials/head.php");
?>
<div class="wrapper">
	<?php
	include(__DIR__ . "/partials/header.php");
	include(__DIR__ . "/partials/sidebar.php");
	?>
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="container-fluid">
				<div class="row mb-2">
					<div class="col-sm-6">
						<h1 class="m-0">Registration Form</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Register Faculty</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="px-2">
					<div class="d-flex justify-content-end mb-3">
						<a class="btn-sm" href="faculty.php">
							Back
							<i class="fas fa-solid fa-arrow-left ml-2 text-center"></i>
						</a>

					</div>
				</div>
				<form id="registration-form">
					<div class="row mb-3">
						<label for="firstname" class="col-sm-1 col-form-label">Firstname</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="firstname" name="firstname" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="middlename" class="col-sm-1 col-form-label">Middlname</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="middlename" name="middlename" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="lastname" class="col-sm-1 col-form-label">Lastname</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="lastname" name="lastname" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="gender" class="col-sm-1 col-form-label">Gender</label>
						<div class="col-sm-11">
							<select class="form-control" name="gender" id="gender">
								<option value="male">Male</option>
								<option value="female">Female</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="birthday" class="col-sm-1 col-form-label">Birthday</label>
						<div class="col-sm-11">
							<input type="date" class="form-control" id="birthday" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="contactNumber" class="col-sm-1 col-form-label">Contact No.</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="contactNumber" name="contactNumber" maxlength="11" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="email" class="col-sm-1 col-form-label">Email</label>
						<div class="col-sm-11">
							<input type="email" class="form-control" id="email" name="email" required>
						</div>
					</div>

					<div class="row mb-3">
						<label for="course" class="col-sm-1 col-form-label">Course</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="course" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="institute" class="col-sm-1 col-form-label">Institute</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="institute" required>
						</div>
					</div>
					<button type="submit" class="btn btn-sm btn-primary" id="submit">Register Employee</button>
				</form>
			</div>
		</div>
	</div>
	<!-- /.col-md-6 -->
</div>
<script>
	$(function() {
		$("#registration-form").on("submit", function(e) {
			e.preventDefault();

			//gather form data
			const formData = {
				firstname: $("#firstname").val().trim(),
				lastname: $("#lastname").val().trim(),
				middlename: $("#middlename").val().trim(),
				email: $("#email").val().trim(),
				gender: $("#gender").val(),
				birthday: $("#birthday").val(),
				contact: $("#contactNumber").val().trim(),
				course: $("#course").val().trim(),
				institute: $("#institute").val().trim(),
			};


			const url = "./php/controller/admin/faculty.php";
			$.ajax({
				type: "POST",
				url: url,
				contentType: "application/json",
				data: JSON.stringify(formData),
				success: handleSuccess,
				error: handleError,
			});
		});
		// Success handler
		function handleSuccess(res) {


			if (res.success == true) {
				showToast("success", "Registered successfully!");
			} else if (res.success == false) {
				showToast("error", res.message);
			}
		}
		// Error Handler
		function handleError(err) {
			console.log(err);
		}

		function showToast(icon, title) {
			Toast.fire({
				icon: icon,
				title: title,
			});
		}

	});
</script>



<?php
include(__DIR__ . "/partials/foot.php");
?>