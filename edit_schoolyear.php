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
						<a class="btn-sm" href="school_year.php">
							Back
							<i class="fas fa-solid fa-arrow-left ml-2 text-center"></i>
						</a>

					</div>
				</div>
				<form id="update-form">
					<div class="row mb-3">
						<label for="school_year" class="col-sm-1 col-form-label">School Year</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="school_year" name="school_year" placeholder="e.g(2021-2022)" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="semester" class="col-sm-1 col-form-label">Semester</label>
						<div class="col-sm-11">
							<select class="form-control" id="semester" name="semester" required>
								<option value="1st">First semester</option>
								<option value="2nd">Second semester</option>
								<option value="3rd">Third semester</option>
							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="status" class="col-sm-1 col-form-label">Status</label>
						<div class="col-sm-11">
							<select class="form-control" id="status" name="status" required>
								<option value="0">Inactive</option>
								<option value="1">Active</option>
							</select>
						</div>
					</div>
					<button type="submit" class="btn btn-sm btn-primary" id="submit">Update School Year</button>
				</form>
			</div>
		</div>
	</div>
	<!-- /.col-md-6 -->
</div>
<script>
	$(function() {
		// Function to get URL parameters
		function getUrlParameter(name) {
			name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
			var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
			var results = regex.exec(location.search);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		}

		// Get the student ID from the URL parameter
		const id = getUrlParameter('id');

		const url = `./php/controller/admin/schoolyear.php?id=${id}`;
		$.ajax({
			type: "GET",
			url: url,
			success: function(res) {
				$("#school_year").val(res.school_year);
				$("#semester").val(res.semester);
			},
			error: handleError,
		});

		$("#update-form").on("submit", function(e) {
			e.preventDefault();

			//gather form data
			const formData = {
				schoolYear: $("#school_year").val().trim(),
				semester: $("#semester").val(),
				status: $("#status").val(),
			};

			const url = `./php/controller/admin/schoolyear.php?id=${id}`;
			$.ajax({
				type: "PATCH",
				url: url,
				contentType: "application/json",
				data: JSON.stringify(formData),
				success: function(res) {
					showToast("success", "Update successfull");
				},
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