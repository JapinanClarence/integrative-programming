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
						<h1 class="m-0">Enrolled Subjects</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Enrolled Subjects</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of subjects</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Code</th>
								<th scope="col">Grade</th>
								<th scope="col">Faculty</th>
								<th scope="col">Enrolled At</th>
							</tr>
						</thead>
						<form id="delete-form">
							<tbody id="table-body">
								<!-- table data -->
							</tbody>
						</form>
					</table>
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
		// Initial load of table data
		refreshTable();

		// Function to refresh the table
		function refreshTable() {
			const url = `./../php/controller/student/grades.php?id=${studentId.user_id}`;

			$.ajax({
				type: "GET",
				url: url,
				success: function(res) {

					// Clear existing table rows
					$("#table-body").empty();

					if (res.success) {

						res.data.map((data) => {
							$("#table-body").append(generateRowMarkup(data));
						});
					} else {
						$("#table-body").append(`
                        <tr>
                            <td colspan="6" class="text-center">
                                <p class="card-text">No Registered Students!</p>
                            </td>
                        </tr>
                    `);
					}
				},
				error: handleError
			});
		}

		const generateRowMarkup = (data) => {
			const grade = !data.grades ? "text-secondary" : "text-dark";

			return `<tr onclick=window.location='subject.php?code=${data.subject_code}'>
				<td class="align-middle">${data.subject_code}</td>
				<td class="align-middle ${grade}">${data.grades}</td>
				<td class="align-middle">${data.faculty}</td>
				<td class="align-middle">${data.created_at}</td>
                </tr>`;
		};

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