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
							<li class="breadcrumb-item active">Register Course</li>
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
						<a class="btn-sm" href="institute.php">
							Back
							<i class="fas fa-solid fa-arrow-left ml-2 text-center"></i>
						</a>

					</div>
				</div>
				<form id="update-form">
					<div class="row mb-3">
						<label for="title" class="col-sm-1 col-form-label">Title</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="title" name="title" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="slug" class="col-sm-1 col-form-label">Slug</label>
						<div class="col-sm-11">
							<input type="text" class="form-control" id="slug" name="slug" required>
						</div>
					</div>
					<div class="row mb-3">
						<label for="description" class="col-sm-1 col-form-label">Description</label>
						<div class="col-sm-11">
							<textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
						</div>
					</div>
					<button type="submit" class="btn btn-sm btn-primary mb-3" id="submit">Update Institute</button>
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

		const url = `./php/controller/admin/institute.php?id=${id}`;
		$.ajax({
			type: "GET",
			url: url,
			success: function(res) {
				$("#title").val(res.title);
				$("#slug").val(res.slug);
				$("#description").val(res.description);
			},
			error: handleError,
		});

		$("#update-form").on("submit", function(e) {
			e.preventDefault();

			//gather form data
			const formData = {
				title: $("#title").val().trim(),
				slug: $("#slug").val(),
				description: $("#description").val().trim(),
			};

			const url = `./php/controller/admin/institute.php?id=${id}`;
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