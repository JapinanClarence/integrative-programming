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
						<h1 class="m-0">Dashboard</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Dashboard</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="py-2">
					<div class="card">
						<div class="row">
							<div class="col-md-4 gradient-custom text-center text-dark" style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
								<img src="./../asset/img/user-profile.png" alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
								<h5 id="fullname"></h5>
								<p id="address"></p>
								<!-- <i class="far fa-edit mb-5"></i> -->
							</div>
							<div class="col-md-8">
								<div class="card-body p-4">
									<h6>Information</h6>
									<hr class="mt-0 mb-4">
									<div class="row pt-1">
										<div class="col-6 mb-3">
											<h6>Email</h6>
											<p id="email" class="text-muted"></p>
										</div>
										<div class="col-6 mb-3">
											<h6>Phone</h6>
											<p id="contact_number" class="text-muted"></p>
										</div>
									</div>
									<!-- <h6>Projects</h6> -->
									<hr class="mt-0 mb-4">
									<div class="row pt-1">
										<div class="col-6 mb-3">
											<h6>Course</h6>
											<p id="course" class="text-muted"></p>
										</div>
										<div class="col-6 mb-3">
											<h6>Grade</h6>
											<p id="grade" class="text-muted"></p>
										</div>

									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- /.col-md-6 -->
	</div>
	<!-- /.row -->
</div><!-- /.container-fluid -->
</div>

</div>
<!-- ./wrapper -->
<script>
	$(function() {
		const studentId = JSON.parse(localStorage.getItem("user"));


		const url = `./../php/controller/student/student.php?id=${studentId.user_id}`;

		$.ajax({
			type: "GET",
			url: url,
			success: function(res) {

				if (res.success) {
					const fullname = res.first_name + " " + res.middle_name.charAt(0) + ". " + res.last_name;

					const address =
						res.street +
						", " +
						res.barangay +
						", " +
						res.municipality +
						", " +
						res.province;

					const averageGrade = !res.average_grade ? 0 : res.average_grade;

					$("#email").text(res.email);
					$("#contact_number").text(res.contact_number);
					$("#fullname").text(fullname);
					$("#address").text(address);
					$("#course").text(res.course);
					$("#grade").text(res.average_grade);
				}
			},
			error: handleError
		});

		// Success handler
		function handleSuccess(res) {
			const data = JSON.parse(res);

			if (data.success == true) {
				showToast("success", data.message);
			} else if (data.success == false) {
				showToast("error", data.message);
			}
		}

		// Your existing error handler
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