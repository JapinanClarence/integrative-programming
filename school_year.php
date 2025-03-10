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
						<h1 class="m-0">School Year</h1>
					</div><!-- /.col -->
					<div class="col-sm-6">
						<ol class="breadcrumb float-sm-right">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">School Year</li>
						</ol>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->

		<!-- Main content -->
		<div class="content">
			<div class="container-fluid">
				<div class="d-flex justify-content-end mb-3">
					<a class="btn-sm btn-info" href="register_schoolyear.php">
						Register School Year
					</a>
				</div>
				<div class="table-responsive-sm rounded" style="height: 500px; overflow-y: auto;">
					<table class="table table-light table-striped rounded table-hover ">
						<caption>List of subjects</caption>
						<thead class="thead-dark">
							<tr>
								<th scope="col">Id</th>
								<th scope="col">School Year</th>
								<th scope="col">Semester</th>
								<th scope="col">Status</th>
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
		// Initial load of table data
		refreshTable();

		// Function to refresh the table
		function refreshTable() {
			const url = "./php/controller/admin/schoolyear.php";

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
                                <p class="card-text">No Registered School Year!</p>
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

			return `<tr>
					<td class="align-middle">${data.id}</td>
                    <td class="align-middle">${data.school_year}</td>
                    <td class="align-middle">${data.semester}</td>
                    <td class="align-middle ${statusColor}">
						${status}
					</td>
                    <td class="align-middle d-flex align-items-center">
					<a href="edit_schoolyear.php?id=${data.id}" class="mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form class="delete-form">
                            <input type="hidden" id="delete_id" name="delete_id" value="${data.id}">
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
					const delete_id = $(this).find('input[name="delete_id"]').val();

					const url = `./php/controller/admin/schoolyear.php?id=${delete_id}`;
					const data = {
						id: delete_id
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
		// Event listener for the delete form
		$(document).on("submit", ".udpate-form", function(e) {
			e.preventDefault();
			const update_id = $(this).find('input[name="update_id"]').val();
			const currentStatus = $("#status").val();
			const newStatus = currentStatus == 1 ? '0' : '1';

			console.log(currentStatus);
			// //gather form data
			// const formData = {
			// 	status: $("#status").val(),
			// 	description: $("#description").val().trim(),
			// 	institute: $("#institute").val()
			// };

			// const url = `./php/controller/admin/institute.php?id=${update_id}`;
			// $.ajax({
			// 	type: "PATCH",
			// 	url: url,
			// 	contentType: "application/json",
			// 	data: JSON.stringify(formData),
			// 	success: function(res) {
			// 		showToast("success", "Update successfull");
			// 	},
			// 	error: handleError,
			// });
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