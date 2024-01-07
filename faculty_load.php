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
						<h1 class="m-0">Subjects</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Subjects</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div id="page_link" class="d-flex justify-content-end mb-3">

				</div>
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of subjects</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Code</th>
								<th scope="col">Description</th>
								<th scope="col">Unit</th>
								<th scope="col">Type</th>
								<th scope="col">Status</th>
								<th scope="col">Assigned At</th>
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
		// Initial load of table data
		refreshTable();

		// $("#page_link").append(`<a class="btn-sm btn-primary mr-3" href="assign_student.php?id=${facultyId}">
		// 				Assign Student
		// 			</a>`);

		$("#page_link").append(`<a class="btn-sm btn-info" href="assign_faculty.php?id=${facultyId}">
						Assign Faculty
					</a>`);

		// Function to refresh the table
		function refreshTable() {

			const url = `./php/controller/admin/grades.php?id=${facultyId}`;

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
                                <p class="card-text">No Assigned Subjects!</p>
                            </td>
                        </tr>
                    `);
					}
				},
				error: handleError
			});
		}

		const generateRowMarkup = (data) => {

			const status = data.status == '1' ? "Active" : "Inactive";
			const statusColor = data.status == "1" ? "text-success" : "text-danger";
			const assignedAt = formatDateTime(data.created_at);


			return `<tr onclick="window.location='handled_student.php?code=${data.code}&id=${facultyId}'">
					<td class="align-middle">${data.code}</td>
                    <td class="align-middle">${data.description}</td>
                    <td class="align-middle">${data.unit}</td>
                    <td class="align-middle">${data.type}</td>
                    <td class="align-middle ${statusColor}">${status}</td>
                    <td class="align-middle">${assignedAt}</td>
                    <td class="align-middle d-flex align-items-center">
                        <form class="delete-form">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" id="code" name="code" value="${data.code}">
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
					const subject_code = $(this).find('input[name="code"]').val();
					console.log(subject_code)
					const url = `./php/controller/admin/grades.php?id=${facultyId}&code=${subject_code}`;
					const data = {
						id: facultyId,
						code: subject_code
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
	});
</script>

<?php
include(__DIR__ . "/partials/foot.php");
?>