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
							<li class="breadcrumb-item active">Register Subject</li>
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
					<div id="back_link" class="d-flex justify-content-end mb-3">
						<!-- back button -->
					</div>
				</div>
				<form id="registration-form">
					<div class="row mb-3">
						<label for="subject" class="col-sm-1 col-form-label">Subject</label>
						<div class="col-sm-11">
							<select class="form-control" id="subject" name="subject" required>

							</select>
						</div>
					</div>
					<div class="row mb-3">
						<label for="student" class="col-sm-1 col-form-label">Student</label>
						<div class="col-sm-11">
							<select class="form-control" id="student" name="student" required>

							</select>
						</div>
					</div>
					<button type="submit" class="btn btn-sm btn-primary" id="submit">Enroll student</button>
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
		const facultyId = getUrlParameter('id');
		const subjectCode = getUrlParameter('code');

		$("#back_link").append(`<a class="btn-sm" href="handled_student.php?code=${subjectCode}&id=${facultyId}">
							Back
							<i class="fas fa-solid fa-arrow-left ml-2 text-center"></i>
						</a>`);

		const url = `./php/controller/admin/grades.php?id=${facultyId}`;
		//populate form info and auto refresh
		subjectInfo();
		studentInfo();

		function subjectInfo() {
			$.ajax({
				type: "GET",
				url: url,
				success: function(res) {
					res.data.map((data) => {
						$("#subject").append(`<option value="${data.code}">${data.code}</option>`);
					});
				},
				error: handleError,
			});
		}

		function studentInfo() {
			$.ajax({
				type: "GET",
				url: `./php/controller/admin/student.php`,
				success: function(res) {
					console.log(res);
					res.data.map((data) => {

						const fullname = data.first_name + " " + data.middle_name.charAt(0) + ". " + data.last_name;
						$("#student").append(`<option value="${data.student_id}">${fullname}</option>`);
					});
				},
				error: handleError,
			});
		}
		$("#registration-form").on("submit", function(e) {
			e.preventDefault();

			//gather form data
			const formData = {
				code: $("#subject").val(),
				facultyId: facultyId,
				studentId: $("#student").val().trim()
			};

			const url = `./php/controller/admin/grades.php?id=${facultyId}&action=assign_student`;
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
				showToast("success", "Assigned successfully!");

				// setTimeout(() => {
				// 	formInfo();
				// }, 3000);
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