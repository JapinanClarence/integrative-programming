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
				<div class="d-flex justify-content-start mb-1 font-weight-bold">
					School Year:<span id="school_year" class="ml-2"></span>
				</div>
				<div class="row">
					<div class="col-lg-3 col-md-3">
						<div class="">
							<div class="">
								<!-- small card -->
								<div class="small-box bg-info">
									<div class="inner">
										<h3 id="studentCount">0</h3>

										<p>Total Students Handled</p>
									</div>
									<div class="icon">
										<i class="fas fa-solid fa-user-graduate"></i>
									</div>
									<div class="small-box-footer" style="height: 10px;">

									</div>
								</div>
							</div>
							<!-- ./col -->
							<div class="">
								<!-- small card -->
								<div class="small-box bg-warning">
									<div class="inner text-white">
										<h3 id="subjectCount"></h3>
										<p>Total Subjects Handled</p>
									</div>
									<div class="icon">
										<i class="fas fa-solid fa-book"></i>
									</div>
									<div class="small-box-footer" style="height: 10px;">

									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-9 col-md-9">
						<div class="d-flex flex-column">
							<h4>Total Students by Subject</h4>
							<div class="" style="height: 200px; overflow-y:auto;">
								<ul id="student_list" class="list-group">

								</ul>
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
		const facultyId = JSON.parse(localStorage.getItem("user"));
		// Initial load of table data
		refreshTable();

		// Function to refresh the table
		function refreshTable() {
			const url = `./../php/controller/faculty/dashboard.php?id=${facultyId.user_id}`;

			$.ajax({
				type: "GET",
				url: url,
				success: function(res) {

					// Clear existing table rows
					$("#table-body").empty();

					const studentCount = !res.total_students ? 0 : res.total_students;
					const subjectCount = !res.total_subjects_handled ? 0 : res.total_subjects_handled;

					if (res.success) {
						$("#studentCount").text(studentCount);
						$("#subjectCount").text(subjectCount);
						$("#school_year").text(res.school_year);

						$.each(res.data, function(subject, count) {
							// Create list item and append to the list
							var listItem = $('<li class="list-group-item"><span class="font-weight-bold">' + subject + ':</span> ' + count + '</li>');
							$('#student_list').append(listItem);
						});

					}
				},
				error: handleError
			});
		}


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

		//format date time
		function formatDateTime(inputDateTime) {
			// Parse the input datetime string
			const parsedDateTime = new Date(inputDateTime);

			// Extract components of the date and time
			const year = parsedDateTime.getFullYear();
			const month = (parsedDateTime.getMonth() + 1).toString().padStart(2, "0"); // Month is zero-indexed, so add 1
			const day = parsedDateTime.getDate().toString().padStart(2, "0");
			const hours = parsedDateTime.getHours().toString().padStart(2, "0");
			const minutes = parsedDateTime.getMinutes().toString().padStart(2, "0");
			const ampm = parsedDateTime.getHours() >= 12 ? "pm" : "am";

			// Adjust hours for 12-hour format
			const formattedHours = parsedDateTime.getHours() % 12 || 12;

			// Construct the formatted datetime string
			const formattedDateTime = `${month}/${day}/${year} ${formattedHours}:${minutes}${ampm}`;

			return formattedDateTime;
		}

		function formatDate(inputDate) {
			const date = new Date(inputDate);
			const month = (date.getMonth() + 1).toString().padStart(2, '0'); // Month is zero-based
			const day = date.getDate().toString().padStart(2, '0');
			const year = date.getFullYear();

			return `${month}/${day}/${year}`;
		}
	});
</script>


<?php
include(__DIR__ . "/partials/foot.php");
?>