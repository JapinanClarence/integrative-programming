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
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of students</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Student Id</th>
								<th scope="col">Fullname</th>
								<th scope="col">Subject</th>
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
		const facultyId = JSON.parse(localStorage.getItem("user"));

		// Function to get URL parameters
		function getUrlParameter(name) {
			name = name.replace(/[[]/, '\\[').replace(/[\]]/, '\\]');
			var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
			var results = regex.exec(location.search);
			return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
		}

		// Get the code from the URL parameter
		const code = getUrlParameter('code');
		// Initial load of table data
		refreshTable();

		// Function to refresh the table
		function refreshTable() {
			const url = `./../php/controller/faculty/grades.php?code=${code}&id=${facultyId.user_id}`;

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
                                <p class="card-text">No Handled Students!</p>
                            </td>
                        </tr>
                    `);
					}
				},
				error: handleError
			});
		}

		const generateRowMarkup = (data) => {
			const grade = !data.grade ? "text-secondary" : "text-dark";

			return `<tr>
        <td class="align-middle">${data.student_id}</td>
        <td class="align-middle">${data.fullname}</td>
        <td class="align-middle">${data.subject_code}</td>
        <td class="align-middle ${grade}">${data.grade}</td>
        <td class="align-middle">
            <button class="btn btn-sm btn-success add-grade-btn" data-subject-code="${data.subject_code}" data-student-id="${data.student_id}">Add Grade</button>
        </td>
    </tr>`;
		};

		$(document).on("click", ".add-grade-btn", function(e) {

			e.preventDefault();

			Swal.fire({
				title: "Add Grades",
				input: "text",
				inputAttributes: {
					autocapitalize: "off"
				},
				showCancelButton: true,
				confirmButtonText: "Add",
				showLoaderOnConfirm: true,
				preConfirm: async (grade) => {
					try {
						const facultyId = JSON.parse(localStorage.getItem("user"));
						const subjectCode = $(this).data("subject-code");
						const studentId = $(this).data("student-id");
						const url = `./../php/controller/faculty/grades.php?id=${facultyId.user_id}&code=${subjectCode}`;
						const data = {
							studentId: studentId,
							grade: grade
						};
						// Use jQuery's $.ajax for the AJAX request
						const response = await $.ajax({
							url: url,
							method: "PATCH", // Adjust the method if needed
							contentType: "application/json",
							data: JSON.stringify(data),
							success: function(res) {
								if (res.success) {
									// Show SweetAlert for successful operation
									Swal.fire({
										title: "Success",
										text: "Grades added successfully",
										icon: "success"
									});
								} else {
									// Show SweetAlert for unsuccessful operation
									Swal.fire({
										title: "Error",
										text: res.message,
										icon: "error"
									});
								}

								// Refresh the table after any operation
								refreshTable();
							},
						});

						if (response.error) {
							// Handle error response
							return Swal.showValidationMessage(response.error);
						}

						return response;
					} catch (error) {
						Swal.showValidationMessage(`Request failed: ${error}`);
					}
				},
				allowOutsideClick: () => !Swal.isLoading()
			});

		});


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