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
						<h1 class="m-0">Student</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Student</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div id="links" class="d-flex justify-content-end mb-3">

				</div>
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of students</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Student Id</th>
								<th scope="col">Fullname</th>
								<th scope="col">Subject Code</th>
								<th scope="col">Grade</th>
								<th scope="col">Action</th>
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


		$("#links").append(`<a class="btn-sm btn-info" href="enroll_student.php?id=${facultyId}&code=${subjectCode}">
						Enroll Student
					</a>`);
		$("#links").append(`<a class="btn-sm btn-primary ml-3" href="faculty_load.php?id=${facultyId}">
							Back
							<i class="fas fa-solid fa-arrow-left ml-2 text-center"></i>
						</a>`);


		// Initial load of table data
		refreshTable();

		// Function to refresh the table
		function refreshTable() {
			const url = `./php/controller/admin/grades.php?action=student_records&id=${facultyId}&code=${subjectCode}`;

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

			const gradeColor = !data.grade ? "text-secondary" : "text-dark";

			return `<tr>
					<td class="align-middle">${data.student_id}</td>
                    <td class="align-middle">${data.fullname}</td>
                    <td class="align-middle">${data.subject_code}</td>
                    <td class="align-middle ${gradeColor}">${data.grade}</td>
                    <td class="align-middle d-flex align-items-center">
                        <form class="delete-form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" id="id" name="id" value="${data.student_id}">
							<input type="hidden" id="code" name="code" value="${data.subject_code}">
                            <button class="btn delete-btn" type="submit">
                                <i class="fas fa-trash text-danger"></i>
                            </button>
                        </form>
                    </td>
                </tr>`;
		};

		// Event listener for the delete form
		$(document).on("submit", ".delete-form", function(e) {
			e.preventDefault();

			// Add a confirmation before deleting
			Swal.fire({
				title: "Are you sure?",
				text: "You won't be able to revert this!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, delete it!"
			}).then((result) => {
				if (result.isConfirmed) {
					const student_id = $(this).find('input[name="id"]').val().trim();
					const code = $(this).find('input[name="code"]').val().trim();
					const url = `./php/controller/admin/grades.php?id=${student_id}&code=${code}&action=unenroll`;

					const data = {
						id: student_id
					};

					$.ajax({
						type: "DELETE",
						url: url,
						contentType: "application/json",
						data: JSON.stringify(data),
						success: function(res) {
							// Refresh the table after successful operation
							refreshTable();
							handleSuccess(res);
						},
						error: handleError,
					});
				}
			});
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